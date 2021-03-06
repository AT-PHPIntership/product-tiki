<?php
namespace Tests\Feature\Api;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use App\Models\User;

class CreatePostsTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * Set up product
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        factory('App\Models\Category')->create();
        factory('App\Models\Product')->create();
    }

    /**
     * Return structure of json.
     *
     * @return array
     */
    public function jsonStructureCreatePostsSuccess()
    {
        return [
          "result" => [
              "type",
              "content",
              "rating",
              "user_id",
              "product_id",
              "updated_at",
              "created_at",
              "id"
          ],
          "code"
      ];
    }

    /**
     * Return structure of json.
     *
     * @return array
     */
    public function jsonStructureCreatePostsFailValidation()
    {
        return [
          "message",
          "errors" => [],
          "code",
          "request" => []
      ];
    }

    /**
     * Test status code
     *
     * @return void
     */
    public function testCreatePostsSuccess()
    {
        $posts = [
            'type' => 1,
            'content' => 'testing Content',
            'rating' => 3
        ];

        $response = $this->jsonUser('POST', 'api/products/1/posts', $posts)
            ->assertStatus(200)
            ->assertJsonStructure($this->jsonStructureCreatePostsSuccess());
        $data = json_decode($response->getContent())->result;
        $compareDb = [
            'id' => $data->id,
            'type' => 1,
            'content' => 'testing Content',
            'rating' => 3,
            'user_id' => $this->user->id
        ];
        $this->assertDatabaseHas('posts', $compareDb);
    }

    /**
     * Test create post fail
     *
     * @return void
     */
    public function testCreatePostsFail()
    {
        $this->jsonUser('POST', 'api/products/1/posts')
            ->assertStatus(422)
            ->assertJsonStructure($this->jsonStructureCreatePostsFailValidation());
    }
}
