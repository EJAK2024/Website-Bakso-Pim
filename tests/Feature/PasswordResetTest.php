<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Tests\TestCase;

class PasswordResetTest extends TestCase
{
    use RefreshDatabase;

    public function test_forgot_password_page_is_accessible(): void
    {
        $response = $this->get('/forgot-password');
        $response->assertStatus(200);
        $response->assertSee('Lupa Password');
    }

    public function test_forgot_password_requires_email(): void
    {
        $response = $this->post('/forgot-password', []);
        $response->assertSessionHasErrors('email');
    }

    public function test_forgot_password_requires_valid_email(): void
    {
        $response = $this->post('/forgot-password', [
            'email' => 'notanemail',
        ]);
        $response->assertSessionHasErrors('email');
    }

    public function test_forgot_password_sends_reset_link(): void
    {
        User::factory()->create(['email' => 'admin@test.com']);

        $response = $this->post('/forgot-password', [
            'email' => 'admin@test.com',
        ]);

        $response->assertSessionHas('status');
    }

    public function test_forgot_password_honeypot_blocks_bot(): void
    {
        User::factory()->create(['email' => 'admin@test.com']);

        $response = $this->post('/forgot-password', [
            'email' => 'admin@test.com',
            'website' => 'http://spam.com',
        ]);

        $response->assertStatus(403);
    }

    public function test_reset_password_page_is_accessible(): void
    {
        $response = $this->get('/reset-password/fake-token');
        $response->assertStatus(200);
        $response->assertSee('Reset Password');
    }
}
