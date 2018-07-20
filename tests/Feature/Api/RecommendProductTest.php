<?php

namespace Tests\Feature\Api;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class RecommendProductTest extends TestCase
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
        factory('App\Models\Category')->create();
        factory('App\Models\Product', 10)->create([
            'category_id' => 1
        ]);
        factory('App\Models\Order')->create();
        factory('App\Models\OrderDetail')->create([
            'order_id' => 1
        ]);

        factory('App\Models\Image', 10)->create();
        
    }

    /**
     * Test status code
     *
     * @return void
     */
    public function testStatusCode()
    {
        $response = $this->json('GET', '/api/products/recommend?product_id=1');
        $response->assertStatus(200);
    }

    /**
     * Return structure of json.
     *
     * @return array
     */
    public function jsonStructureDetailRecommendProduct()
    { 
        return [
            [
                'url' => '/api/recommend?product_id=1&category_id=1',
                'structure' => [
                    'result' => [
                        [
                            'id',
                            'category_id',
                            'name',
                            'preview',
                            'description',
                            'total_rate',
                            'rate_count',
                            'avg_rating',
                            'price',
                            'quantity',
                            'status',
                            'created_at',
                            'updated_at',
                            'deleted_at',
                            'price_formated',
                            'image_path',
                            'order_details_count',
                            'category' => [
                                'id',
                                'parent_id',
                                'name',
                                'level',
                                'created_at',
                                'updated_at',
                                'deleted_at'
                            ],
                            'images'=> [
                                [
                                'id',
                                'product_id',
                                'img_url',
                                'created_at',
                                'updated_at'
                                ]
                            ]
                        ]
                    ],
                    'code'
                ]
            ]
        ];      
    }

    /**
     * @dataProvider jsonStructureDetailRecommendProduct
     *
     * @param string $url url of api detail product 
     * @param array  $structure structure of json 
     *
     * Test api structure
     *
     * @return void
     */
    public function testJsonStructure($url, $structure)
    {
        $response = $this->json('GET', $url);
        $response->assertJsonStructure($structure);
    }

    /**
     * Test check some object compare database.
     *
     * @return void
     */
    public function testCompareDatabase()
    {
        $response = $this->json('GET', 'api/recommend?product_id=1&category=1');
        $data = json_decode($response->getContent())->result;
        $arrayCompare = [
            'id' => $data->id,
            'name' => $data->name,
            'category_id' => $data->category_id
        ];
        $this->assertDatabaseHas('products', $arrayCompare);
        foreach ($data->images as $image) {
            $arrayImage = [
                'id' => $image->id,
                'product_id' => $image->product_id
            ];
            $this->assertDatabaseHas('images', $arrayImage);
        }
    }
}
