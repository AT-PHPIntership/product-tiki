<?php

namespace Tests\Browser\ProductTest;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Models\Product;

class ListProductTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testListProduct()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/admin/products')
                    ->assertSee('Product List');
        });
    }

    /**
     * Test data empty.
     *
     * @return void
     */
    public function testDataEmpty()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/admin/products')
                    ->assertSee('Product List');
            $elements = $browser->elements('.table-responsive table tbody tr');
            $numRecord = count($elements);
            $this->assertTrue($numRecord == 0);
        });
    }

    /**
     * Test pagination.
     *
     * @return void
     */
    public function testPagination()
    {
        $this->browse(function (Browser $browser) {

            factory('App\Models\Category', 5)->create();
            factory('App\Models\Product', 10)->create();

            $elements = $browser->visit('/admin/products')
                ->elements('.table-responsive table tbody tr');
            $numRecord = count($elements);
            $this->assertTrue($numRecord == 5);

            $elements = $browser->visit('/admin/products?page=3')
                ->elements('.table-responsive table tbody tr');
            $numRecord = count($elements);
            $this->assertTrue($numRecord == 0);
        });
    }

    /**
     * Test sort product.
     *
     * @return void
     */
    public function testSortProductByName()
    {
        $this->browse(function (Browser $browser) {

            factory('App\Models\Category', 5)->create();
            factory('App\Models\Product', 10)->create();

            $sorts = [
                [ 'sortBy' => 'category_id' , 'column' => 2 ],
                [ 'sortBy' => 'name' , 'column' => 3 ],
                [ 'sortBy' => 'quantity' , 'column' => 5 ],
                [ 'sortBy' => 'avg_rating' , 'column' => 6 ],
                [ 'sortBy' => 'price' , 'column' => 7 ],
                [ 'sortBy' => 'status' , 'column' => 8 ],
            ];

            foreach ($sorts as $sort) {
                // dd($sort['sortBy']);
                if($sort['sortBy'] == 'category_id'){
                    $productsASC = \DB::table('products')
                                        ->join('categories', 'products.category_id' , '=', 'categories.id')
                                        ->orderBy($sort['sortBy'],'ASC')
                                        ->pluck('categories.name')
                                        ->toArray();
                    // dd($productsASC);
                    $productsDESC = \DB::table('products')
                                        ->join('categories', 'products.category_id' , '=', 'categories.id')
                                        ->orderBy($sort['sortBy'],'DESC')
                                        ->pluck('categories.name')
                                        ->toArray();
                } else {
                    $productsASC = \DB::table('products')->orderBy($sort['sortBy'],'ASC')->pluck($sort['sortBy'])->toArray();
                    $productsDESC = \DB::table('products')->orderBy($sort['sortBy'],'DESC')->pluck($sort['sortBy'])->toArray();
                }

                $browser->visit(route('admin.products.index', ['sortBy' => $sort['sortBy'], 'dir' => 'ASC']));

                for ($i = 1; $i <= 5; $i++) {
                    $elements = '.table-responsive table tbody tr:nth-child(' . $i . ') td:nth-child(' . $sort['column'] . ')';
                    $this->assertEquals($browser->text($elements), $productsASC[$i - 1]);
                }

                $browser->visit(route('admin.products.index', ['sortBy' => $sort['sortBy'], 'dir' => 'DESC']));

                for ($i = 1; $i <= 5; $i++) {
                    $elements = '.table-responsive table tbody tr:nth-child(' . $i . ') td:nth-child(' . $sort['column'] . ')';
                    $this->assertEquals($browser->text($elements), $productsDESC[$i - 1]);
                }
            }
        });
    }
}
