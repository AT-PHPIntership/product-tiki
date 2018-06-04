<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use App\Models\Category;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class UpdateCategoryTest extends DuskTestCase
{
    use DatabaseMigrations;
    
    public function setUp()
    {
        parent::setUp();
        factory('App\Models\Category', 2)->create();
    }

    /**
     * Test url update category
     *
     * @return void
     */
    public function testUpdateCategoryUrl()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/admin/categories')
                    ->click('#edit1');
            $browser->assertPathIs('/admin/categories/1/edit')
                    ->assertSee('Edit Category');
        });
    }

    /**
     * List case for Test validate for input Update Category
     *
     * @return array
     */
    public function listCaseTestValidateForInput()
    {
        return [
            ['name', '', 'The name field is required.'],
            ['name', '    ', 'The name field is required.'],
            ['name', '.-=+{}()[]^$@#', 'The name format is invalid.'],
            ['name', 'Iphone', 'The name has already been taken.'],
        ];
    }

    /**
     * List case for Test validate for input Update Category
     *
     * @param string $name name of field
     * @param string $content content
     * @param string $message message show when validate
     *
     * @dataProvider listCaseTestValidateForInput
     *
     * @return array
     */
    public function testCategoryValidateForInput($name, $content, $message)
    {
        factory('App\Models\Category', 1)->create([
            'name' => 'Iphone'
        ]);
        $this->browse(function (Browser $browser) use ($name, $content, $message) {
            $browser->visit('admin/categories/1/edit')
                    ->assertSee('Edit Category')
                    ->type($name, $content);
            $browser->press('Submit')
                    ->assertSee($message);
        });
    }

    /**
     * Test Category Edit Success.
     *
     * @return void
     */
    public function testEditCategorySuccess()
    {
        $testName = 'Laptop';
        $categoryOther = Category::find(2);
        $this->browse(function (Browser $browser) use ($testName, $categoryOther) {
            $browser->visit('/admin/categories/1/edit')
                    ->assertSee('Edit Category')
                    ->type('name', $testName)
                    ->select('parent_id', $categoryOther->id)
                    ->press('Submit')
                    ->assertSee('Update Category Successfull!')
                    ->assertPathIs('/admin/categories');
        });
        $this->assertDatabaseHas('categories', [
            'name' => $testName,
            'parent_id' => $categoryOther->id,
            'level' => $categoryOther->level++,
        ]);
    }
}
