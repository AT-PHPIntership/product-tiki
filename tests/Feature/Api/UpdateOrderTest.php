<?php

namespace Tests\Feature\Api;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Models\Product;
use App\Models\OrderDetail;
use App\Models\Order;

class UpdateOrderTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * Set up
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $category = factory('App\Models\Category')->create();
        $products = factory('App\Models\Product', 2)->create([
            'category_id' => $category->id,
            'quantity' => 5
        ]);
        $order = factory('App\Models\Order')->create([
            'status' => Order::UNAPPROVED
        ]);
        foreach ($products as $product) {
            $order_details = OrderDetail::create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'quantity' => 3,
                'product_price' => $product->price
            ]);
        }
    }

    /**
     * Return structure of json.
     *
     * @return array
     */
    public function jsonStructureUpdateOrderProductExceedQuantity()
    {
        return [
            "result" => [
                "order" => [
                    "user_id",
                    "updated_at",
                    "created_at",
                    "id",
                    "total",
                    "order_details" => [
                        [
                            "id",
                            "product_id",
                            "order_id",
                            "quantity",
                            "product_price",
                            "created_at",
                            "updated_at",
                            "deleted_at"
                        ]
                    ]
                ],
                "errors"
            ],
            "code"
        ];
    }

    /**
     * Return structure of json.
     *
     * @return array
     */
    public function jsonStructureUpdateOrder()
    {
        return [
            "result" => [
                "order" => [
                    "user_id",
                    "updated_at",
                    "created_at",
                    "id",
                    "total",
                    "order_details" => [
                        [
                            "id",
                            "product_id",
                            "order_id",
                            "quantity",
                            "product_price",
                            "created_at",
                            "updated_at",
                            "deleted_at"
                        ]
                    ]
                ],
            ],
            "code"
        ];
    }

    /**
     * Return structure of json.
     *
     * @return array
     */
    public function jsonStructureQuantityMore()
    {
        return [
            "error" => [],
            "code"
        ];
    }

    /**
     * Test status code
     *
     * @return void
     */
    public function testStatusCode()
    {
        $product = Product::find(1);
        $quantity = 2;
        $update = [
            'products' => [
                [
                    "id" => $product->id,
                    "quantity" => $quantity
                ]
            ]
        ];
        $this->jsonUser('PUT', '/api/orders/1', $update)
            ->assertStatus(200)
            ->assertJsonStructure($this->jsonStructureUpdateOrder());
    }

    /**
     * Test status code
     *
     * @return void
     */
    public function testCompareDatabase()
    {
        $product1 = Product::find(1);
        $product2 = Product::find(2);
        $update = [
            'products' => [
                [
                    "id" => $product1->id,
                    "quantity" => $product1->quantity -1
                ],
                [
                    "id" => $product2->id,
                    "quantity" => $product2->quantity -1
                ]
            ]
        ];
        $response = $this->jsonUser('PUT', 'api/orders/1', $update);

        $data = json_decode($response->getContent())->result;
        $updated1 = [
            'order_id' => $data->order->id,
            'product_id' => $product1->id,
            'quantity' => $product1->quantity -1
        ];
        $updated2 = [
            'order_id' => $data->order->id,
            'product_id' => $product2->id,
            'quantity' => $product2->quantity -1
        ];
        $this->assertDatabaseHas('order_details', $updated1);
        $this->assertDatabaseHas('order_details', $updated2);
    }

    /**
     * Test status code
     *
     * @return void
     */
    public function testInvalidUpdateOrder()
    {
        $product1 = Product::find(1);
        $product2 = Product::find(2);
        $update = [
            'products' => [
                [
                    "id" => $product1->id,
                    "quantity" => $product1->quantity +1
                ],
                [
                    "id" => $product2->id,
                    "quantity" => $product2->quantity +1
                ]
            ]
        ];
        $this->jsonUser('PUT', '/api/orders/1', $update)
            ->assertStatus(422)
            ->assertJsonStructure($this->jsonStructureQuantityMore());
    }

    /**
     * Test status code
     *
     * @return void
     */
    public function testOneInvalidQuantity()
    {
        $product1 = Product::find(1);
        $product2 = Product::find(2);
        $update = [
            'products' => [
                [
                    "id" => $product1->id,
                    "quantity" => $product1->quantity -1
                ],
                [
                    "id" => $product2->id,
                    "quantity" => $product2->quantity +1
                ]
            ]
        ];
        $this->jsonUser('PUT', '/api/orders/1', $update)
            ->assertStatus(200)
            ->assertJsonStructure($this->jsonStructureUpdateOrderProductExceedQuantity());
    }
}
