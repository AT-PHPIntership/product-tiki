<?php

namespace Tests\Feature\Api;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CreateCommentTest extends TestCase
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
        $product = factory('App\Models\Product')->create([
            'category_id' => $category->id
        ]);
        $post = factory('App\Models\Post')->create([
            'product_id' => $product->id,
            'user_id' => $this->user->id
        ]);
        $comment = factory('App\Models\Comment')->create([
            'post_id' => $post->id,
            'user_id' => $this->user->id
        ]);
    }

    /**
     * Return structure of json.
     *
     * @return array
     */
    public function jsonStructureCreateComment()
    {
        return [
          "result" => [
              "content",
              "user_id",
              "post_id",
              "updated_at",
              "created_at",
              "id",
              "user" => [
                  "id",
                  "username",
                  "email",
                  "old_password",
                  "is_active",
                  "role",
                  "last_logined_at",
                  "created_at",
                  "updated_at",
                  "deleted_at",
                  "userinfo" => []
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
                "content" => []
            ],
            "code",
            "request" => []
        ];
    }

    /**
     * Test status code
     *
     * @return void
     */
    public function testStatusCode()
    {
        $content = 'Inserted';
        $data = [
            'content' => $content,
        ];
        $this->jsonUser('POST', '/api/posts/1/comments', $data)
            ->assertStatus(200);
    }

    /**
     * Test structure code
     *
     * @return void
     */
    public function testStuctureCode()
    {
        $content = 'Inserted';
        $data = [
            'content' => $content,
        ];
        $this->jsonUser('POST', '/api/posts/1/comments', $data)
            ->assertJsonStructure($this->jsonStructureCreateComment());
    }

    /**
     * Test structure code
     *
     * @return void
     */
    public function testStuctureValidate()
    {
        $this->jsonUser('POST', '/api/posts/1/comments')
            ->assertJsonStructure($this->jsonStructureValidate());
    }

    /**
     * Test check some object compare database.
     *
     * @return void
     */
    public function testCompareDatabase()
    {
        $content = 'Inserted';
        $data = [
            'content' => $content,
        ];
        $response = $this->jsonUser('POST', '/api/posts/1/comments', $data);

        $data = json_decode($response->getContent())->result;
        $arrayPost = [
            'id' => $data->id,
            'post_id' => $data->post_id,
            'user_id' => $data->user_id,
            'content' => $data->content
        ];
        $this->assertDatabaseHas('comments', $arrayPost);
    }

}
