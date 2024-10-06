<?php

namespace Tests\Feature;

use App\Models\Admin;
use App\Notifications\PasswordResetLink;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Password;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_login(): void
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

    public function test_admin_can_logout(): void
    {
        Sanctum::actingAs(
            Admin::factory()->create(),
            ['*']
        );

        $response = $this->postJson(route('auth.logout'));
        $response->assertStatus(200);
        $response->assertJsonStructure(['success']);
    }

    public function test_admin_can_send_password_reset_link(): void
    {
        $admin = Admin::factory()->create();

        Notification::fake();

        $response = $this->postJson(route('auth.send-password-reset-link'), ['email' => $admin->email]);
        $response->assertStatus(200);
        Notification::assertSentTo($admin, PasswordResetLink::class);
    }

    public function test_admin_can_reset_they_password(): void
    {
        $admin = Admin::factory()->create();
        $token = Password::createToken($admin);

        Event::fake();

        $data = [
            'email' => $admin->email,
            'password' => 'newpassword',
            'password_confirmation' => 'newpassword',
            'token' => $token
        ];

        $response = $this->postJson(route('auth.reset-password'), $data);
        $response->assertStatus(200);
        $this->assertTrue(Hash::check('newpassword', Admin::first()->password));
        Event::assertDispatched(PasswordReset::class);
    }
}
