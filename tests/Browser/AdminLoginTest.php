<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class AdminLoginTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * Override function setUp() for make user login
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
    }

    /**
     * Test Login as admin
     *
     * @return void
     */
    public function testFailLogin()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                    ->type('email', 'error@error.err')
                    ->type('password', 'error')
                    ->press('Login')
                    ->assertSee('These credentials do not match our records.');
        });
    }

    /**
     * Test Login as admin
     *
     * @return void
     */
    public function testSuccessLogin()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                    ->type('email', $this->user->email)
                    ->type('password', '12345')
                    ->press('Login')
                    ->assertPathIs('/admin')
                    ->assertSee('Admin Dashboard');
        });
    }

    /**
     * Test Logout as admin
     *
     * @return void
     */
    public function testLogout()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/admin')
                    ->click('.dropdown-toggle')
                    ->clickLink('Log Out')
                    ->assertPathIs('/');
                    // ->assertSee('Admin Dashboard');
        });
    }


}
