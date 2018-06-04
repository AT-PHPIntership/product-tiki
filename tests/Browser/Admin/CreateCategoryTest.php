<?php

namespace Tests\Browser\Admin;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use App\Models\Category;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CreateCategoryTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * Test url create category
     *
     * @return void
     */
    public function testCreateCategoriesUrl()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/admin/categories')
                    ->clickLink('Add Categories')
                    ->assertPathIs('/admin/categories/create')
                    ->assertSee('Add Category');
        });
    }

    /**
     * List case for Test validate for input Create User
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
     * List case for Test validate for input Create Category Exist
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
        factory('App\Models\Category')->create([
            'name' => 'Iphone'
        ]);
        $this->browse(function (Browser $browser) use ($name, $content, $message) {
            $browser->visit('admin/categories/create')
                    ->type($name, $content);
            $browser->press('Submit')
                    ->assertSee($message);
        });
    }

    /**
     * Dusk test create category success.
     *
     * @return void
     */
    public function testCreatesCategoryNoParentCategorySuccess()
    {
        $testContent = 'Smart Phone'; 
        $this->browse(function (Browser $browser) use ($testContent) {
            $browser->visit('admin/categories/create')
                    ->type('name', $testContent);       
            $browser->press('Submit')
                    ->assertSee('Create New Category Successfull!');
            $this->assertDatabaseHas('categories', [
                'id' => 1,
                'name' => $testContent,
                'parent_id' => null,
                'level' => 0
            ]);
        });
    }

    /**
     * Dusk test create category success.
     *
     * @return void
     */
    public function testCreatesCategoryHasParentCategorySuccess()
    {
        $testContent = 'Iphone';
        $category = factory('App\Models\Category')->create();
        $this->browse(function (Browser $browser) use ($testContent, $category) {
            $browser->visit('admin/categories/create')
                    ->type('name', $testContent)
                    ->select('parent_id', $category->id);       
            $browser->press('Submit')
                    ->assertSee('Create New Category Successfull!');
            $this->assertDatabaseHas('categories', [
                'id' => 2,
                'name' => $testContent,
                'parent_id' => $category->id,
                'level' => $category->level + 1,
            ]);
        });
    }
}
