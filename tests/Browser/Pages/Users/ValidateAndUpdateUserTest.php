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
            ['full_name', '', 'TThe full name must be a string.'],
            ['address', '', 'The address must be a string.'],
            ['phone', '', 'The phone format is invalid'],
            ['identity_card', '', 'The identity card format is invalid.'],
        ];
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
                    ->type('identity_card', '347368362')
                    ->press('Update')
                    ->assertPathIs('/admin/users')
                    ->assertSee('Update user successfully');                
            $this->assertDatabaseHas('user_info', [
                'full_name' => 'mai luong',
                'address' => 'quang nam',
                'phone' => '0123345454',
                'identity_card' => '347368362',
            ]);
        });
    }
}
