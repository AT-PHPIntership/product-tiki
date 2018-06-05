<?php

namespace Tests\Browser\Pages\Users;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Models\User;
use App\Models\UserInfo;

class CreateUserTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * Test url create user
     *
     * @return void
     */
    public function testCreateUserUrl()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/admin/users')
                ->clickLink('Add User')
                ->assertPathIs('/admin/users/create')
                ->assertSee('Create User');
        });
    }

    /**
     * List case for test validate for input
     *
     * @return array
     */
    public function listCaseTestValidateForInput()
    {
        return [
            ['username', '', 'The username field is required.'],
            ['email', '', 'The email field is required.'],
            ['password', '', 'The password field is required.'],
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
     * 
     * @dataProvider listCaseTestValidateForInput
     *
     * @return void
     */
    public function testValidateForInput($name, $content, $message)
    {
        $this->browse(function (Browser $browser) use ($name, $content, $message) {
            $browser->visit('admin/users/create')
                ->type($name, $content)
                ->press('Submit')                   
                ->assertSee($message);
        });
    }

    /**
     * List case for test validate for input
     *
     * @return array
     */
    public function listCaseAlreadyTestValidateForInput()
    {
        return [
            ['username', 'stoy', 'The username has already been taken.'],
            ['email', 'greynolds@example.com', 'The email has already been taken.'],
            ['identity_card', '154599812', 'The identity card has already been taken.'],
        ];
    }

    /**
     * Dusk test validate for input
     *
     * @param string $name name of field
     * @param string $content content
     * @param string $message message show when validate
     * 
     * @dataProvider listCaseAlreadyTestValidateForInput
     *
     * @return void
     */
    public function testValidateaAlreadyForInput($name, $content, $message)
    {
        $users = factory('App\Models\User')->create([
            'username' => 'stoy',
            'email' => 'greynolds@example.com',
        ]);
        factory(UserInfo::class)->create([
            'user_id' => $users->id,    
            'identity_card' => '154599812'
        ]);       
        $this->browse(function (Browser $browser) use ($name, $content, $message) {
            $browser->visit('admin/users/create')
                ->type($name, $content)
                ->press('Submit')                   
                ->assertSee($message);
        });
    }

    /**
     * Dusk test create user success.
     *
     * @return void
     */
    public function testCreatesUserSuccess()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('admin/users/create')
                ->type('username', 'suong')
                ->type('email', 'suongmai@gmail.com')
                ->type('password', '123456')
                ->type('full_name', 'luong suong mai')
                ->type('address', 'Quang Nam')
                ->radio('#gender', '1')
                ->type('phone', '0121324356')
                ->type('identity_card', '205454545')
                ->keys('#dob', '07-07-2000');
            $browser->press('Submit')
                ->assertSee('Create user successfully');
            $this->assertDatabaseHas('users', [
                'username' => 'suong',
                'email' => 'suongmai@gmail.com',
            ]);
            $this->assertDatabaseHas('user_info', [
                'full_name' => 'luong suong mai',
                'address' => 'Quang Nam',
                'phone' => '0121324356',
                'gender' => '1',
                'identity_card' => '205454545',
                'dob' => '2000-07-07',
            ]);
        });
    }
}
