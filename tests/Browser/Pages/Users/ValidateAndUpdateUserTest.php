<?php

namespace Tests\Browser\Pages\Users;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Models\User;
use App\Models\UserInfo;

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
        $users = factory(User::class)->create();
        factory(UserInfo::class)->create([
            'user_id' => $users->id,
        ]);
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
                    ->visit('/admin/users/1/edit')
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
            ['full_name', '', 'The full name must be a string.'],
            ['address', '', 'The address must be a string.'],
            ['phone', '', 'The phone format is invalid'],
            ['identity_card', 'hgfg', 'The identity card format is invalid.'],
        ];
    }

    /**
     * Dusk test validate for input
     *
     * @param string $name name of field
     * @param string $content content
     * @param string $message message show when validate
     * 
     * @dataProvider listCaseTestUpdateValidateForInput
     *
     * @return void
     */
    public function testUpdateValidateForInput($name, $content, $message)
    {
        $this->browse(function (Browser $browser) use ($name, $content, $message) {
            $browser->visit('/admin/users/1/edit')
                ->type($name, $content)
                ->press('Update')                   
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
            $browser->visit('/admin/users/1/edit')
                    ->assertSee('Update User')
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
