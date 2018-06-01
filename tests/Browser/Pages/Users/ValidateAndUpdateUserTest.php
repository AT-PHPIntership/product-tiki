<?php

namespace Tests\Browser\Pages\Users;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Models\User;

class ValidateAndUpdateUserTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * Override function set up database
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        factory(User::class, 2)->create();
    }

    /**
     * Test url update user
     *
     * @return void
     */
    public function testUpdateUserUrl()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/admin/users')
                    ->visit('/admin/users/2/edit')
                    ->assertSee( __('Update User'));
        });
    }

    /**
     * List case for test update user validate for input
     *
     * @return array
     */
    public function listCaseTestUpdateValidateForInput()
    {
        return [
            ['address', '', 'The address must be a string.'],
            ['phone', '', 'The phone format is invalid.'],
            ['identity_card', '', 'The identity card format is invalid.'],
        ];
    }

    /**
     * Dusk test validate for input
     *
     * @param string $name name of field
     * @param string $content content
     * @param string $message message show when validate
     * @param string $listUser list info user
     * 
     * @dataProvider listCaseTestUpdateValidateForInput
     *
     * @return void
     */
    public function testUpdateValidateForInput($name, $content, $message)
    {
        $this->browse(function (Browser $browser) use ($name, $content, $message) {
            $browser->visit('admin/users/create')
                ->press('Submit')                   
                ->assertSee($message);
        });
    }

    /**
     * List case for test update user validate for input
     *
     * @return array
     */
    public function listCaseUpdateAlreadyTestValidateForInput()
    {
        return [
            ['identity_card', '', 'The username has already been taken.'],
        ];
    }

    /**
     * Dusk test validate for input
     *
     * @param string $name name of field
     * @param string $content content
     * @param string $message message show when validate
     * @param string $listUser list info user
     * 
     * @dataProvider listCaseAlreadyTestValidateForInput
     *
     * @return void
     */
    public function testUpdateValidateaAlreadyForInput($name, $content, $message)
    {
        factory('App\Models\UserInfo', 1)->create([
            'idetity_card ' => '',
        ]);       
        $this->browse(function (Browser $browser) use ($name, $content, $message) {
            $browser->visit('admin/users/create')
                ->type('idetity_card', $content)
                ->press('Submit')                   
                ->assertSee($message);
        });
    }

    /**
     * Dusk test update user success.
     *
     * @return void
     */
    public function testUpdateUserSuccess()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/admin/users/2/edit')
                    ->assertSee(__('Update User'))
                    ->screenshot('abc')
                    ->type('full_name', 'mai luong')
                    ->type('address', 'quang nam')
                    ->type('phone', '0123345454')
                    ->press('Update')
                    ->assertPathIs('/admin/users')
                    ->assertSee('Update user successfully');                
            $this->assertDatabaseHas('user_info', [
                'full_name' => 'mai luong',
                'address' => 'quang nam',
                'phone' => '0123345454',
            ]);
        });
    }
}
