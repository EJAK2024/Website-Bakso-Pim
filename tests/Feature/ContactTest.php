<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContactTest extends TestCase
{
    use RefreshDatabase;

    public function test_contact_form_submits_successfully(): void
    {
        $response = $this->post('/kontak', [
            'name' => 'Test User',
            'email' => 'user@test.com',
            'message' => 'This is a test message',
        ]);

        $response->assertRedirect('/#contact');
        $this->assertDatabaseHas('messages', [
            'name' => 'Test User',
            'email' => 'user@test.com',
            'message' => 'This is a test message',
        ]);
    }

    public function test_contact_requires_name(): void
    {
        $response = $this->post('/kontak', [
            'email' => 'user@test.com',
            'message' => 'Test message',
        ]);

        $response->assertSessionHasErrors('name');
    }

    public function test_contact_requires_email(): void
    {
        $response = $this->post('/kontak', [
            'name' => 'Test User',
            'message' => 'Test message',
        ]);

        $response->assertSessionHasErrors('email');
    }

    public function test_contact_requires_message(): void
    {
        $response = $this->post('/kontak', [
            'name' => 'Test User',
            'email' => 'user@test.com',
        ]);

        $response->assertSessionHasErrors('message');
    }

    public function test_contact_sanitizes_input(): void
    {
        $response = $this->post('/kontak', [
            'name' => '<script>alert("xss")</script>Test User',
            'email' => 'user@test.com',
            'message' => '<img src=x onerror=alert(1)>Hello',
        ]);

        $this->assertDatabaseHas('messages', [
            'email' => 'user@test.com',
            'message' => 'Hello',
        ]);
    }

    public function test_contact_honeypot_blocks_bot(): void
    {
        $response = $this->post('/kontak', [
            'name' => 'Bot',
            'email' => 'bot@test.com',
            'message' => 'Spam',
            'website' => 'http://spam.com',
        ]);

        $response->assertStatus(403);
    }

    public function test_message_max_length(): void
    {
        $response = $this->post('/kontak', [
            'name' => 'Test User',
            'email' => 'user@test.com',
            'message' => str_repeat('a', 1001),
        ]);

        $response->assertSessionHasErrors('message');
    }
}
