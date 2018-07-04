<?php

namespace Tests\Browser\Admin\Order;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Models\Order;

class OrderListTest extends DuskTestCase
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
        factory('App\Models\Category', 3)->create();
        factory('App\Models\Product', 10)->create();
        factory('App\Models\User', 10)->create();
        factory('App\Models\Order')->create([
            'status' => 0
        ]);
        factory('App\Models\Order', 10)->create();
    }

    /**
     * Test Order List
     *
     * @return void
     */
    public function testListOrders()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user)
                    ->visit('/admin/orders')
                    ->assertSee("All Orders");
        });
    }

    /**
     * Test delete Order
     *
     * @return void
     */
    public function testDeleteOrders()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user)
                    ->visit('/admin/orders')
                    ->click('.btn-danger')
                    ->acceptDialog()
                    ->pause(1000)
                    ->assertSee('Deleted');
            $this->assertSoftDeleted('orders', [
                'id' => 1,
            ]);
        });
    }

    /**
     * Test details Order
     *
     * @return void
     */
    public function testDetailOrder()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user)
                    ->visit('/admin/orders')
                    ->click('.btn-primary')
                    ->assertPathIs('/admin/orders/1')
                    ->assertSee('Order Details');
        });
    }

    /**
     * Test change Order status
     *
     * @return void
     */
    public function testChangeOrderStatus()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user)
                    ->visit('/admin/orders/1')
                    ->select('order-status', \App\Models\Order::APPROVED)
                    ->acceptDialog()
                    ->pause(4000)
                    ->assertSee('Updated');
            $this->assertDatabaseHas('orders', [
                'id' => 1,
                'status' => \App\Models\Order::APPROVED
            ]);
        });
    }

    /**
     * Test change Order status
     *
     * @return void
     */
    public function testFilterOrder()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user)
                    ->visit('/admin/orders/')
                    ->select('order_status', \App\Models\Order::APPROVED)
                    ->press('Go')
                    ->pause(1000)
                    ->assertSee('Approved');
            $recordFromDB = Order::where('status', \App\Models\Order::APPROVED)->get()->count();

            $elements = $browser->elements('.table tbody tr');
            $numRecord = count($elements);

            $this->assertTrue($numRecord == $recordFromDB);
        });
    }
}
