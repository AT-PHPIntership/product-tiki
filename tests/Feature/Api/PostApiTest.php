<?php

namespace Tests\Feature\Api;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;


class PostApiTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp() {
        parent::setUp();
        factory('App\Models\Category', 1)->create();
        factory('App\Models\Product', 1)->create();
        factory('App\Models\User', 1)->create();
        factory('App\Models\UserInfo',1)->create([
            'user_id' => 2,
        ]);
        factory('App\Models\Post', 10)->states('rating')->create();
        factory('App\Models\Comment', 10)->create();
    }

    /**
     * Test status code
     *
     * @return void
     */
    public function testStatusCodeForComments()
    {
        $response = $this->json('GET', '/api/products/1/posts');
        $response->assertStatus(200);
    }

    /**
     * Return structure of json.
     *
     * @return array
     */
    public function listStructureTest()
    {
    	return [
            [
                'url' => '/api/products/1/posts',
                'structure' => [
                    'result' => [
                        'paginator' => [
                            'current_page',
                            'first_page_url',
                            'from',
                            'last_page',
                            'last_page_url',
                            'next_page_url',
                            'path',
                            'per_page',
                            'prev_page_url',
                            'to',
                            'total'
                        ],
                        'data' => [
                            [

                                "id",
                                "product_id",
                                "user_id",
                                "type",
                                "content",
                                "rating",
                                "status",
                                "diff_time",
                                "image_path",
                                "created_at",
                                "updated_at",
                                "deleted_at",
                                "user" => [
                                    "id",
                                    "username",
                                    "email",
                                    "is_active",
                                    "role",
                                    "last_logined_at",
                                    "created_at",
                                    "updated_at",
                                    "deleted_at",
                                    "user_info" => [
                                        "id",
                                        "user_id",
                                        "full_name",
                                        "avatar",
                                        "gender",
                                        "dob",
                                        "address",
                                        "phone",
                                        "identity_card",
                                        "created_at",
                                        "updated_at"
                                    ]
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
     * Test api structure
     *
     * @dataProvider listStructureTest
     *
     * @return void
     */
    public function testJsonStructure($url, $structure)
    {
        $response = $this->json('GET', $url);
        $response->assertJsonStructure($structure);
    }

    /**
     * Test paginate
     *
     * @return void
     */
    public function testJsonPaginate()
    {
        $dataTest = [
            'perpage' => 3,
            'page' => 2
        ];
        $response = $this->json('GET', '/api/products/1/posts?perpage=' . $dataTest['perpage'] . '&page=' . $dataTest['page'] . '');
        $data = json_decode($response->getContent());
        $this->assertEquals($data->result->paginator->per_page, $dataTest['perpage']);
        $this->assertEquals($data->result->paginator->current_page, $dataTest['page']);
    }

    /**
     * Test get data
     *
     * @return void
     */
    public function testJsonData()
    {
        $productId = 1;
        $response = $this->json('GET', '/api/products/' . $productId . '/posts');
        $data = json_decode($response->getContent());

        foreach ($data->result->data as $post) {
            $this->assertEquals($post->product_id, $productId);
            $this->assertEquals($post->user_id, $post->user->id);
            $this->assertEquals($post->user->id, $post->user->user_info->user_id);
        }
    }

    /**
     * Test get posts by status
     *
     * @return void
     */
    public function testJsonGetPostByStatus()
    {
        $status = 1;
        $productId = 1;
        $response = $this->json('GET', '/api/products/' . $productId . '/posts?status=' . $status . '');
        $data = json_decode($response->getContent());

        foreach ($data->result->data as $post) {
            $this->assertEquals($post->product_id, $productId);
            $this->assertEquals($post->status, $status);
        }
    }
}
