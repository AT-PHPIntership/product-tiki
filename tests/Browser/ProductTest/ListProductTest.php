<?php

namespace Tests\Browser\ProductTest;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

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
     * Make cases for test.
     *
     * @return array
     */
    public function dataForTest()
    {
        return [
            ['category_id' , 2],
            ['name' , 3],
            ['quantity' , 5],
            ['avg_rating' , 6],
            ['price' , 7],
            ['status' , 8],
        ];
    }

    /**
     * Test sort product asc.
     *
     * @dataProvider dataForTest
     *
     * @return void
     */
    public function testSortProductAsc($sortBy, $column)
    {
        $this->browse(function (Browser $browser) use ($sortBy, $column) {

            factory('App\Models\Category', 5)->create();
            factory('App\Models\Product', 10)->create();

            if ($sortBy == 'category_id') {
                $productsAsc = \DB::table('products')
                                    ->join('categories', 'products.category_id' , '=', 'categories.id')
                                    ->orderBy($sortBy, 'ASC')
                                    ->pluck('categories.name')
                                    ->toArray();
            } else {
                $productsAsc = \DB::table('products')->orderBy($sortBy, 'ASC')->pluck($sortBy)->toArray();
            }

            $browser->visit(route('admin.products.index', ['sortBy' => $sortBy, 'dir' => 'ASC']));

            for ($i = 1; $i <= 5; $i++) {
                $elements = ".table-responsive table tbody tr:nth-child($i) td:nth-child($column)";
                $this->assertEquals($browser->text($elements), $productsAsc[$i - 1]);
            }
        });
    }

    /**
     * Test sort product desc.
     *
     * @dataProvider dataForTest
     *
     * @return void
     */
    public function testSortProductDesc($sortBy, $column)
    {
        $this->browse(function (Browser $browser) use ($sortBy, $column) {

            factory('App\Models\Category', 5)->create();
            factory('App\Models\Product', 10)->create();

            if ($sortBy == 'category_id') {
                $productsDesc = \DB::table('products')
                                    ->join('categories', 'products.category_id' , '=', 'categories.id')
                                    ->orderBy($sortBy, 'DESC')
                                    ->pluck('categories.name')
                                    ->toArray();
            } else {
                $productsDesc = \DB::table('products')->orderBy($sortBy, 'DESC')->pluck($sortBy)->toArray();
            }

            $browser->visit(route('admin.products.index', ['sortBy' => $sortBy, 'dir' => 'DESC']));

            for ($i = 1; $i <= 5; $i++) {
                $elements = ".table-responsive table tbody tr:nth-child($i) td:nth-child($column)";
                $this->assertEquals($browser->text($elements), $productsDesc[$i - 1]);
            }
        });
    }

    /**
     * Test search product.
     *
     * @return void
     */
    public function testSearchProduct()
    {
        $this->browse(function (Browser $browser) {

            $name = 'lorem';
            factory('App\Models\Category', 5)->create();
            factory('App\Models\Product', 10)->create();
            factory('App\Models\Product', 1)->create([
                'name' => $name
            ]);

            $elements = $browser->visit('/admin/products')
                                ->type('content', $name)
                                ->press('Go')
                                ->assertSee($name);

        });
    }
}
