<?php

namespace Tests\Feature;

use App\Models\Admin;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_login()
    {
        $admin = Admin::factory()->create();

        $data = [
            'email' => $admin->email,
            'password' => 'secret'
        ];

        $response = $this->postJson(route('auth.login'), $data);
        $response->assertStatus(200);
        $response->assertJsonStructure(['token']);
    }

    public function test_admin_can_logout()
    {
        Sanctum::actingAs(
            Admin::factory()->create(),
            ['*']
        );

        $response = $this->postJson(route('auth.logout'));
        $response->assertStatus(200);
        $response->assertJsonStructure(['success']);
    }
}
