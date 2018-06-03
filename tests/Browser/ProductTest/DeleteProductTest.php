<?php

namespace Tests\Browser\ProductTest;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Models\Product;

class DeleteProductTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * A Dusk test delete product.
     *
     * @return void
     */
    public function testDeleteProduct()
    {
        $this->browse(function (Browser $browser) {

            factory('App\Models\Category', 5)->create();
            factory('App\Models\Product', 3)->create();

            $product = Product::find(3);
            $browser->visit('/admin/products')
                    ->assertSee('Product List')
                    ->click('tr td #delete-prd' . $product->id . ' > button')
                    ->acceptDialog();

            $elements = $browser->visit('/admin/products')
                                ->elements('.table-responsive table tbody tr');
            $numRecord = count($elements);
            $this->assertTrue($numRecord == 2);

            $this->assertSoftDeleted('products', [
                'id' => $product->id,
                'category_id' => $product->category_id,
                'name' => $product->name
            ]);
        });
    }
}
