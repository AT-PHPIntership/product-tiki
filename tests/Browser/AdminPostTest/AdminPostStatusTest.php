<?php

namespace Tests\Browser\AdminPostTest;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Models\Post;

class AdminPostStatusTest extends DuskTestCase
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
     * test if change post status work.
     *
     * @return void
     */
    public function testChangePostStatus()
    {
        factory('App\Models\Category', 1)->create();
        factory('App\Models\Product', 1)->create();
        factory('App\Models\User', 1)->create();
        factory('App\Models\Post', 1)->states('rating')->create([
            'status' => Post::UNAPPROVED
        ]);
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user);
            $browser->visit('/admin/posts')
                    ->click('#update1')
                    ->assertSee('Approved');
            $browser->visit('/admin/posts')
                    ->assertSee('Approved');
        });
    }

    public function testDeletePost()
    {
        $testContent = 'Post test delete';
        factory('App\Models\Category', 1)->create();
        factory('App\Models\Product', 1)->create();
        factory('App\Models\User', 1)->create();
        factory('App\Models\Post', 1)->states('rating')->create([
            'content' => $testContent
        ]);
        $this->browse(function (Browser $browser) use ($testContent) {
            $browser->loginAs($this->user)
                    ->visit('/admin/posts')
                    ->click('.btn-danger')
                    ->acceptDialog()
                    ->assertDontSee($testContent);
        });
    }
}
