<?php

namespace Tests\Feature;

use Database\Seeders\PessoasTableSeeder;
use Database\Seeders\UserSeeder;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */

    public function testeCamposObrigatoriosParaRegistro()
    {
        $this->json('POST', 'api/register', ['Accept' => 'application/json'])
            ->assertStatus(422)
            ->assertJsonStructure([
                "error" => [
                    "name",
                    "email",
                    "password",
                    "confirmPassword",
                ],
                "message"
            ]);
    }

    public function testSenhaRepetida()
    {
        $userData = [
            "name" => "John Doe",
            "email" => "doe@example.com",
            "password" => "demo12345",
            "confirmPassword" => "demo123456"
        ];

        $this->json('POST', 'api/register', $userData, ['Accept' => 'application/json'])
            ->assertStatus(422)
            ->assertJson([
                "message" => "Os dados estão invalidos",
                "error" => [
                    "confirmPassword" => ["The confirm password and password must match."]
                ]
            ]);
    }

    public function testeDeRegistroCompleto()
    {
        $this->seed();
        $userData = [
            "name" => "John Doe",
            "email" => "doe@example.com",
            "password" => "demo12345",
            "confirmPassword" => "demo12345"
        ];

        $this->json('POST', 'api/register', $userData, ['Accept' => 'application/json'])
            ->assertStatus(201)
            ->assertJsonStructure([
                "data" => [
                    'id',
                    'name',
                    'email',
                    'created_at',
                    'updated_at',
                ],
                "message"
            ]);
    }

    public function testeDeveTerEmailEPassword()
    {
        $this->json('POST', 'api/login')
            ->assertStatus(422)
            ->assertJson([
                "message" => "Os dados estao invalidos",
                "error" => [
                    'email' => ["The email field is required."],
                    'password' => ["The password field is required."],
                ]
            ]);
    }

    public function testSuccessfulLogin()
    {
        $user = User::create([
        	'name' => '',
        	'email' => 'sample@test.com',
        	'password' => bcrypt('sample123')
        ]);

        $loginData = ['email' => 'sample@test.com', 'password' => 'sample123'];

        $this->json('POST', 'api/login', $loginData, ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonStructure([
                "success",
                "token"
            ]);

        $this->assertAuthenticated();
    }

    protected $seeder = PessoasTableSeeder::class;
}
