<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HoneypotTest extends TestCase
{
    use RefreshDatabase;

    public function test_contact_honeypot_blocks_bot(): void
    {
        $response = $this->post('/kontak', [
            'name' => 'Bot',
            'email' => 'bot@test.com',
            'message' => 'Spam message',
            'website' => 'http://spam.com',
        ]);

        $response->assertStatus(403);
    }

    public function test_contact_honeypot_allows_human(): void
    {
        $response = $this->post('/kontak', [
            'name' => 'Real User',
            'email' => 'user@test.com',
            'message' => 'Hello, I have a question',
        ]);

        $response->assertRedirect('/#contact');
        $this->assertDatabaseHas('messages', [
            'email' => 'user@test.com',
            'name' => 'Real User',
        ]);
    }

    public function test_order_honeypot_blocks_bot(): void
    {
        $response = $this->post('/pesan', [
            'customer_name' => 'Bot',
            'phone' => '081234567890',
            'address' => 'Bot Address',
            'menu_ids' => [1],
            'quantities' => [1],
            'payment_method' => 'kasir',
            'website' => 'http://spam.com',
        ]);

        $response->assertStatus(403);
    }

    public function test_login_honeypot_blocks_bot(): void
    {
        $response = $this->post('/login', [
            'email' => 'admin@test.com',
            'password' => 'password',
            'dummy_email' => 'bot@example.com',
        ]);

        $response->assertStatus(403);
    }

    public function test_register_honeypot_blocks_bot(): void
    {
        $admin = \App\Models\User::factory()->create(['status' => 'admin']);

        $response = $this->actingAs($admin)->post('/register', [
            'name' => 'Bot',
            'email' => 'bot@test.com',
            'password' => 'Password123',
            'password_confirmation' => 'Password123',
            'website' => 'http://spam.com',
        ]);

        $response->assertStatus(403);
    }
}
