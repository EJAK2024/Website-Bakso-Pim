<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    private array $adminData = [
        'name' => 'Test Admin',
        'email' => 'admin@test.com',
        'phone' => '081234567890',
        'status' => 'admin',
        'password' => 'Password123',
        'password_confirmation' => 'Password123',
    ];

    public function test_admin_can_login(): void
    {
        User::factory()->create([
            'email' => 'admin@test.com',
            'password' => Hash::make('Password123'),
            'status' => 'admin',
        ]);

        $response = $this->post('/login', [
            'email' => 'admin@test.com',
            'password' => 'Password123',
        ]);

        $response->assertRedirect('/admin');
        $this->assertAuthenticated();
    }

    public function test_wrong_password_cannot_login(): void
    {
        User::factory()->create([
            'email' => 'admin@test.com',
            'password' => Hash::make('Password123'),
        ]);

        $response = $this->post('/login', [
            'email' => 'admin@test.com',
            'password' => 'wrongpassword',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_nonexistent_user_cannot_login(): void
    {
        $response = $this->post('/login', [
            'email' => 'notfound@test.com',
            'password' => 'Password123',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_admin_can_logout(): void
    {
        $user = User::factory()->create(['status' => 'admin']);

        $this->actingAs($user);

        $response = $this->post('/logout');

        $response->assertRedirect('/');
        $this->assertGuest();
    }

    public function test_honeypot_blocks_bot_on_login(): void
    {
        $response = $this->post('/login', [
            'email' => 'admin@test.com',
            'password' => 'Password123',
            'dummy_email' => 'bot@example.com',
        ]);

        $response->assertStatus(403);
    }

    public function test_register_requires_admin_auth(): void
    {
        $response = $this->get('/register');
        $response->assertRedirect('/login');
    }

    public function test_admin_can_access_register_form(): void
    {
        $user = User::factory()->create(['status' => 'admin']);

        $response = $this->actingAs($user)->get('/register');

        $response->assertStatus(200);
        $response->assertSee('Tambah Admin Baru');
    }

    public function test_admin_can_register_new_user(): void
    {
        $user = User::factory()->create(['status' => 'admin']);

        $response = $this->actingAs($user)->post('/register', [
            'name' => 'New Admin',
            'email' => 'newadmin@test.com',
            'phone' => '081234567890',
            'status' => 'kasir',
            'password' => 'Password123',
            'password_confirmation' => 'Password123',
        ]);

        $response->assertRedirect('/admin');
        $this->assertDatabaseHas('users', [
            'email' => 'newadmin@test.com',
            'status' => 'kasir',
        ]);
    }

    public function test_register_honeypot_blocks_bot(): void
    {
        $user = User::factory()->create(['status' => 'admin']);

        $response = $this->actingAs($user)->post('/register', [
            'name' => 'Bot User',
            'email' => 'bot@test.com',
            'status' => 'admin',
            'password' => 'Password123',
            'password_confirmation' => 'Password123',
            'website' => 'http://spam.com',
        ]);

        $response->assertStatus(403);
    }

    public function test_login_rate_limiting(): void
    {
        User::factory()->create([
            'email' => 'admin@test.com',
            'password' => Hash::make('Password123'),
        ]);

        for ($i = 0; $i < 6; $i++) {
            $this->post('/login', [
                'email' => 'admin@test.com',
                'password' => 'wrongpassword',
            ]);
        }

        $response = $this->post('/login', [
            'email' => 'admin@test.com',
            'password' => 'wrongpassword',
        ]);

        $response->assertStatus(429);
    }
}
