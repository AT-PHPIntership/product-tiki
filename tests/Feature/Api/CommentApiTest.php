<?php

namespace Tests\Feature\Api;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Models\Comment;

class CommentApiTest extends TestCase
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
        factory('App\Models\Post', 1)->states('rating')->create();
        factory('App\Models\Comment', 10)->create();
    }

    /**
     * Test status code
     *
     * @return void
     */
    public function testStatusCodeForComments()
    {
        $response = $this->json('GET', '/api/posts/1/comments');
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
                'url' => '/api/posts/1/comments',
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
                                'id',
                                'user_id',
                                'post_id',
                                'content',
                                'created_at',
                                'updated_at',
                                'deleted_at',
                                'user' => [
                                    'id',
                                    'username',
                                    'email',
                                    'old_password',
                                    'is_active',
                                    'role',
                                    'last_logined_at',
                                    'created_at',
                                    'updated_at',
                                    'deleted_at',
                                    'user_info' => [
                                        'id',
                                        'user_id',
                                        'full_name',
                                        'avatar',
                                        'gender',
                                        'dob',
                                        'address',
                                        'phone',
                                        'identity_card',
                                        'created_at',
                                        'updated_at'
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
        $response = $this->json('GET', '/api/posts/1/comments?perpage=' . $dataTest['perpage'] . '&page=' . $dataTest['page'] . '');
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
        $postId = 1;
        $response = $this->json('GET', '/api/posts/' . $postId . '/comments');
        $data = json_decode($response->getContent());

        foreach ($data->result->data as $comment) {
            $this->assertEquals($comment->post_id, $postId);
            $this->assertEquals($comment->user_id, $comment->user->id);
            $this->assertEquals($comment->user->id, $comment->user->user_info->user_id);
        }
    }
}
