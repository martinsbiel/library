<?php

namespace Tests\Feature;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_be_created()
    {
        Sanctum::actingAs(
            Admin::factory()->create(),
            ['*']
        );

        $data = [
            'name' => 'Gabriel',
            'email' => 'gabriel@email.com'
        ];

        $response = $this->postJson(route('users.store'), $data);
        $response->assertStatus(201);
        $response->assertJson($data);
    }

    public function test_users_can_be_listed()
    {
        Sanctum::actingAs(
            Admin::factory()->create(),
            ['*']
        );

        $users = User::factory(10)->create();

        $response = $this->getJson(route('users.index'));
        $response->assertStatus(200);
        $response->assertJsonStructure([
            [
                'id',
                'name',
                'email',
                'loans',
                'created_at',
                'updated_at',
                'deleted_at'
            ]
        ]);
    }

    public function test_user_can_be_selected()
    {
        Sanctum::actingAs(
            Admin::factory()->create(),
            ['*']
        );

        $user = User::factory()->create();

        $response = $this->getJson(route('users.show', ['user' => $user->id]));
        $response->assertStatus(200);
        $response->assertJsonStructure([
            [
                'id',
                'name',
                'email',
                'loans',
                'created_at',
                'updated_at',
                'deleted_at'
            ]
        ]);
    }

    public function test_user_can_be_deleted()
    {
        Sanctum::actingAs(
            Admin::factory()->create(),
            ['*']
        );

        $user = User::factory()->create();

        $response = $this->deleteJson(route('users.destroy', ['user' => $user->id]));
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success'
        ]);
    }

    public function test_user_can_be_updated()
    {
        Sanctum::actingAs(
            Admin::factory()->create(),
            ['*']
        );
        
        $user = User::factory()->create();

        $response = $this->patchJson(route('users.update', ['user' => $user->id]), ['name' => 'Gabriel']);
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'id',
            'name',
            'email',
            'created_at',
            'updated_at',
            'deleted_at'
        ]);
    }
}
