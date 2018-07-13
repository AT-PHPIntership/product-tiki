<?php

namespace Tests\Feature\Api;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Support\Facades\Hash;

class ResetPasswordTest extends TestCase
{
    
    use DatabaseMigrations;
    use SendsPasswordResetEmails;

    /**
     * Set up
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
    }

    /**
     * Test status code
     *
     * @return void
     */
    public function testStatusCode()
    {
        $email = $this->user->email;
        $this->json('POST', 'api/password/reset', ['email' => $email])
            ->assertStatus(200);
        
        $token = $this->broker()->createToken($this->user);
        $reset = [
            'email' => $email,
            'token' => $token,
            'password' => '123456',
            'password_confirmation' => '123456',
            '_method' => 'PUT'
        ];
        $this->json('POST', 'api/password/reset', $reset)
            ->assertStatus(200);
    }

    /**
     * Return structure of json.
     *
     * @return array
     */
    public function jsonStructure()
    {
        return [
            "result" => [
                "message",
            ],
            "code"
        ];
    }

    /**
     * Test structure code
     *
     * @return void
     */
    public function testStructerCode()
    {
        $email = $this->user->email;
        $this->json('POST', 'api/password/reset', ['email' => $email])
            ->assertJsonStructure($this->jsonStructure());
        
        $token = $this->broker()->createToken($this->user);
        $reset = [
            'email' => $email,
            'token' => $token,
            'password' => '123456',
            'password_confirmation' => '123456',
            '_method' => 'PUT'
        ];
        $this->json('POST', 'api/password/reset', $reset)
            ->assertJsonStructure($this->jsonStructure());
    }

    /**
     * List case for test validate
     *
     * @return array
     */
    public function listCaseTestValidate()
    {
        return [
            ['email', ''],
            ['email', '    '],
            ['email', 'admin'],
            ['email', 'admin@'],
            ['email', '@test.co'],
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
            "errors" => [],
            "code",
            "request" => []
        ];
    }

    /**
     * Test validate send email
     * 
     * @param string $email   email for validate
     * @param string $content content
     *
     * @dataProvider listCaseTestValidate
     * 
     * @return void
     */
    public function testValidate($name, $content)
    {
        $this->json('POST', 'api/password/reset', [$name => $content])
            ->assertJsonStructure($this->jsonStructureValidate());
        
        $token = $this->broker()->createToken($this->user);
        $reset = [
            $name => $content,
            'token' => $token,
            'password' => '123456',
            'password_confirmation' => '123456',
            '_method' => 'PUT'
        ];
        $this->json('POST', 'api/password/reset', $reset)
            ->assertJsonStructure($this->jsonStructureValidate());
    }

    /**
     * Return structure of json.
     *
     * @return array
     */
    public function jsonStructureErrorNotFound()
    {
        return [
            "error" => [
                "message",
                "request" => []
            ],
            "code"
        ];
    }

    /**
     * Test validate send email
     * 
     * @return void
     */
    public function testCanNotFindEmail()
    {
        $email = $this->user->email;
        $this->json('POST', 'api/password/reset', ['email' => $email . 'm'])
            ->assertJsonStructure($this->jsonStructureErrorNotFound());
        
        $token = $this->broker()->createToken($this->user);
        $reset = [
            'email' => $email . 'm',
            'token' => $token,
            'password' => '123456',
            'password_confirmation' => '123456',
            '_method' => 'PUT'
        ];
        $this->json('POST', 'api/password/reset', $reset)
            ->assertJsonStructure($this->jsonStructureErrorNotFound());
    }

    /**
     * Test vaidate password confirm
     *
     * @return void
     */
    public function testValidatePasswordConfirm()
    {
        $email = $this->user->email;
        $token = $this->broker()->createToken($this->user);
        $reset = [
            'email' => $email,
            'token' => $token,
            'password' => '123456',
            'password_confirmation' => '1234561',
            '_method' => 'PUT'
        ];
        $this->json('POST', 'api/password/reset', $reset)
            ->assertJsonStructure($this->jsonStructureValidate());
    }

    /**
     * Test vaidate token
     *
     * @return void
     */
    public function testValidateToken()
    {
        $email = $this->user->email;
        $token = $this->broker()->createToken($this->user);
        $reset = [
            'email' => $email,
            'token' => $token . 'a',
            'password' => '123456',
            'password_confirmation' => '123456',
            '_method' => 'PUT'
        ];
        $this->json('POST', 'api/password/reset', $reset)
            ->assertJsonStructure($this->jsonStructureErrorNotFound());
    }

    /**
     * Test reset password success and login.
     *
     * @return void
     */
    public function testResetSuccessAndLogin()
    {
        $email = $this->user->email;
        $token = $this->broker()->createToken($this->user);
        $reset = [
            'email' => $email,
            'token' => $token,
            'password' => '123456',
            'password_confirmation' => '123456',
            '_method' => 'PUT'
        ];
        $this->json('POST', 'api/password/reset', $reset);

        $login = [
            'email' => $email,
            'password' => '123456'
        ];
        $this->json('POST', '/api/login', $login, ['Accept' => 'application/json'])
            ->assertStatus(200);
    }
}
