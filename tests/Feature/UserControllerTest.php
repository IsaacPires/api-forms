<?php

namespace Tests\Feature;


use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;


class UserControllerTest extends TestCase
{

    use RefreshDatabase;

    /**
     * @dataProvider userDataProvider
     */
    public function test_salvar_user_no_banco($userData)
    {
        $response = $this->postJson('/api/user', $userData);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'user' => [
                    'id',
                    'name',
                    'email',
                    'created_at',
                    'updated_at',
                ],
                'token',
            ]);

        $this->assertDatabaseHas('user', [
            'email' => 'test@example.com',
            'name'  => "TestUser"
        ]);
    }

    public function test_envia_requisicao_sem_infos()
    {   

        $userData = [];

        $response = $this->postJson('/api/user', $userData);

        $response->assertStatus(400);
    }

    /**
     * @dataProvider userDataProvider
     */

    public function test_criacao_e_autenticacao_token($userData)
    {
        
        $response = $this->postJson('/api/user', $userData);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'user' => [
                    'id',
                    'name',
                    'email',
                    'created_at',
                    'updated_at',
                ],
                'token',
            ]);

        $token = $response->json('token');

        $authResponse = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get('/api/forms');

        $authResponse->assertStatus(200);
    }

    public static function userDataProvider()
    {
        return [
            [[
            'name' => 'TestUser',
            'email' => 'test@example.com',
            'password' => 'password123',
            ]]
        ];
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutExceptionHandling();
    }

}