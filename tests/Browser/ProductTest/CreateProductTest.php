<?php

namespace Tests\Browser\ProductTest;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CreateProductTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * A Dusk test create product success.
     *
     * @return void
     */
    public function testCreateNewProduct()
    {
        $this->browse(function (Browser $browser) {
            factory('App\Models\Category', 5)->create();

            $browser->visit('/admin/products/create')
                    ->assertSee('Create Product')
                    ->select('category_id')
                    ->type('name', 'Iphone')
                    ->type('description', 'This is a Smart Phone')
                    ->type('price', '10000000')
                    ->type('quantity', '100')
                    ->attach('input_img', __DIR__.'/testing/iphone1.jpg')
                    ->press('Create')
                    ->assertPathIs('/admin/products')
                    ->assertSee('Create product successfully');
        });
    }

    /**
     * A Dusk test input null value.
     *
     * @return void
     */
    public function testNullValue()
    {
        $this->browse(function (Browser $browser) {
            factory('App\Models\Category', 5)->create();

            $browser->visit('/admin/products/create')
                    ->assertSee('Create Product')
                    ->press('Create')
                    ->assertPathIs('/admin/products/create')
                    ->assertDontSee('Create product successfully');
        });
    }

    /**
     * A Dusk test input invalid value.
     *
     * @return void
     */
    public function testInvalidValue()
    {
        $this->browse(function (Browser $browser) {
            factory('App\Models\Category', 5)->create();

            $browser->visit('/admin/products/create')
                    ->assertSee('Create Product')
                    ->select('category_id')
                    ->type('name', 'Iphone')
                    ->type('description', 'This is a Smart Phone')
                    ->type('price', '1.5')
                    ->type('quantity', '1.5')
                    ->attach('input_img', __DIR__.'/testing/iphone1.jpg')
                    ->press('Create')
                    ->assertPathIs('/admin/products/create')
                    ->assertDontSee('Create product successfully');
        });
    }

    /**
     * A Dusk test input invalid format image.
     *
     * @return void
     */
    public function testInvalidImage()
    {
        $this->browse(function (Browser $browser) {
            factory('App\Models\Category', 5)->create();

            $browser->visit('/admin/products/create')
                    ->assertSee('Create Product')
                    ->select('category_id')
                    ->type('name', 'Iphone7')
                    ->type('description', 'This is a Smart Phone')
                    ->type('price', '1000000')
                    ->type('quantity', '10')
                    ->attach('input_img', __DIR__.'/testing/iphone1.zip')
                    ->press('Create')
                    ->assertPathIs('/admin/products/create')
                    ->assertDontSee('Create product successfully');
        });
    }
}
