<?php

namespace Tests\Feature\Api;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Models\Product;

class CreateOrderTest extends TestCase
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
        factory('App\Models\UserInfo')->create([
            'user_id' => $this->user->id
        ]);
        factory('App\Models\Category')->create();
        factory('App\Models\Product', 2)->create([
            'category_id' => 1,
            'quantity' => 5
        ]);
        
    }

    /**
     * Return structure of json.
     *
     * @return array
     */
    public function jsonStructureCreateOrder()
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
                ]
            ],
            "code"
        ];
    }

    /**
     * Return structure of json.
     *
     * @return array
     */
    public function jsonStructureValidate()
    {
        return [
            "message",
            "errors" => [
                "products.0.quantity" => []
            ],
            "code",
            "request" => [
                "products" => []
            ]
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
        $product1 = Product::find(1);
        $product2 = Product::find(2);
        $quantity = 2;
        $create = [
            'products' => [
                [
                    "id" => $product1->id,
                    "quantity" => $quantity
                ],
                [
                    "id" => $product2->id,
                    "quantity" => $quantity
                ]
            ]
        ];
        $this->jsonUser('POST', 'api/orders', $create)
            ->assertStatus(200);
    }

    /**
     * Test structure code
     *
     * @return void
     */
    public function testStructureCode()
    {
        $product1 = Product::find(1);
        $product2 = Product::find(2);
        $quantity = 2;
        $dataCreate = [
            'products' => [
                [
                    "id" => $product1->id,
                    "quantity" => $quantity
                ],
                [
                    "id" => $product2->id,
                    "quantity" => $quantity
                ]
            ]
        ];
        $this->jsonUser('POST', 'api/orders', $dataCreate)
            ->assertJsonStructure($this->jsonStructureCreateOrder());
    }

    /**
     * Test check some object compare database.
     *
     * @return void
     */
    public function testCompareDatabase()
    {
        $product1 = Product::find(1);
        $product2 = Product::find(2);
        $quantity = 2;
        $dataCreate = [
            'products' => [
                [
                    "id" => $product1->id,
                    "quantity" => $quantity
                ],
                [
                    "id" => $product2->id,
                    "quantity" => $quantity
                ]
            ]
        ];
        $response = $this->jsonUser('POST', 'api/orders', $dataCreate);
        $data = json_decode($response->getContent())->result;

        $arrayOrder = [
            'id' => $data->order->id,
            'user_id' => $data->order->user_id,
            'total' => $data->order->total
        ];
        $this->assertDatabaseHas('orders', $arrayOrder);

        foreach ($data->order->order_details as $order_details) {
            $arrayOrderDetails = [
                'id' => $order_details->id,
                'product_id' => $order_details->product_id,
                'order_id' => $order_details->order_id,
                'quantity' => $order_details->quantity,
                'product_price' => $order_details->product_price
            ];
            $this->assertDatabaseHas('order_details', $arrayOrderDetails);
        }
    }

    /**
     * Test validate create order
     *
     * @return void
     */
    public function testCreateValidate()
    {
        $product = Product::find(1);
        $dataCreate = [
            'products' => [
                [
                    "id" => $product->id,
                    "quantity" => null
                ]
            ]
        ];
        $this->jsonUser('POST', 'api/orders', $dataCreate)
            ->assertJsonStructure($this->jsonStructureValidate());
    }

    /**
     * Test validate create order more quantity than quantity in database
     *
     * @return void
     */
    public function testValidateQuantityMore()
    {
        $product = Product::find(1);
        $dataCreate = [
            'products' => [
                [
                    "id" => $product->id,
                    "quantity" => $product->quantity + 1
                ]
            ]
        ];
        $this->jsonUser('POST', 'api/orders', $dataCreate)
            ->assertStatus(422)
            ->assertJsonStructure($this->jsonStructureQuantityMore());
    }
}
