<?php

namespace Tests\Browser\AdminPostTest;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class AdminListPostTest extends DuskTestCase
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
     * test if post list work.
     *
     * @return void
     */
    public function testAdminPostList()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user)
                    ->visit('/admin/posts')
                    ->assertSee('All Posts');
        });
    }

    /**
     * test if search post work.
     *
     * @return void
     */
    public function testSearchPost()
    {
        $testContent = 'dkashkdjhdasndjkashdkjah';
        factory('App\Models\Category', 1)->create();
        factory('App\Models\Product', 1)->create();
        factory('App\Models\User', 1)->create();
        factory('App\Models\Post', 1)->states('rating')->create([
            'content' => $testContent
        ]);
        $this->browse(function (Browser $browser) use ($testContent) {
            $browser->loginAs($this->user)
                    ->visit('/admin/posts')
                    ->type('content', $testContent)
                    ->press('Go!')
                    ->assertSee($testContent);
        });
    }
}
