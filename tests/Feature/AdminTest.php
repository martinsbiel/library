<?php

namespace Tests\Feature;

use App\Models\Admin;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class AdminTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_be_created(): void
    {
        Sanctum::actingAs(
            Admin::factory()->create(),
            ['*']
        );

        $data = [
            'name' => 'Gabriel',
            'email' => 'gabriel@email.com',
            'password' => 'secret'
        ];

        $response = $this->postJson(route('admins.store'), $data);
        $response->assertStatus(201);
        $response->assertJsonStructure([
            'id',
            'name',
            'email',
            'password'
        ]);
    }

    public function test_admins_can_be_listed(): void
    {
        Sanctum::actingAs(
            Admin::factory()->create(),
            ['*']
        );

        $admins = Admin::factory(10)->create();

        $response = $this->getJson(route('admins.index'));
        $response->assertStatus(200);
        $response->assertJsonStructure([
            [
                'id',
                'name',
                'email',
                'password',
                'created_at',
                'updated_at',
                'deleted_at'
            ]
        ]);
    }

    public function test_admin_can_be_selected(): void
    {
        Sanctum::actingAs(
            Admin::factory()->create(),
            ['*']
        );
        
        $admin = Admin::factory()->create();

        $response = $this->getJson(route('admins.show', ['admin' => $admin->id]));
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'id',
            'name',
            'email',
            'password',
            'created_at',
            'updated_at',
            'deleted_at'
        ]);
    }

    public function test_admin_can_be_deleted(): void
    {
        Sanctum::actingAs(
            Admin::factory()->create(),
            ['*']
        );

        $admin = Admin::factory()->create();

        $response = $this->deleteJson(route('admins.destroy', ['admin' => $admin->id]));
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success'
        ]);
    }

    public function test_admin_can_be_updated(): void
    {
        Sanctum::actingAs(
            Admin::factory()->create(),
            ['*']
        );
        
        $admin = Admin::factory()->create();

        $response = $this->patchJson(route('admins.update', ['admin' => $admin->id]), ['name' => 'Gabriel']);
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'id',
            'name',
            'email',
            'password',
            'created_at',
            'updated_at',
            'deleted_at'
        ]);
    }

    public function test_admin_can_change_password(): void
    {
        Sanctum::actingAs(
            Admin::factory()->create(),
            ['*']
        );
        
        $admin = Admin::factory()->create([
            'password' => Hash::make('secret')
        ]);

        $data = [
            'password' => 'secret',
            'new_password' => 'newsecret',
            'new_password_confirmation' => 'newsecret'
        ];

        $response = $this->patchJson(route('admin.change-password', ['id' => $admin->id]), $data);
        $response->assertStatus(200);
        $response->assertJsonStructure(['success']);
    }
}
