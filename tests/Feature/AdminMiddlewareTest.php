<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminMiddlewareTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_access_admin_dashboard(): void
    {
        $response = $this->get('/admin');
        $response->assertRedirect('/login');
    }

    public function test_non_admin_cannot_access_admin_dashboard(): void
    {
        $kasir = User::factory()->create(['status' => 'kasir']);
        $staff = User::factory()->create(['status' => 'staff']);

        $response = $this->actingAs($kasir)->get('/admin');
        $response->assertStatus(403);

        $response = $this->actingAs($staff)->get('/admin');
        $response->assertStatus(403);
    }

    public function test_admin_can_access_admin_dashboard(): void
    {
        $admin = User::factory()->create(['status' => 'admin']);

        $response = $this->actingAs($admin)->get('/admin');
        $response->assertStatus(200);
        $response->assertSee('Dashboard');
    }

    public function test_guest_cannot_access_menu_crud(): void
    {
        $routes = ['/admin/menu', '/admin/menu/create'];

        foreach ($routes as $route) {
            $response = $this->get($route);
            $response->assertRedirect('/login');
        }
    }

    public function test_non_admin_cannot_access_menu_crud(): void
    {
        $kasir = User::factory()->create(['status' => 'kasir']);

        $response = $this->actingAs($kasir)->get('/admin/menu');
        $response->assertStatus(403);
    }

    public function test_guest_cannot_access_orders(): void
    {
        $response = $this->get('/admin/orders');
        $response->assertRedirect('/login');
    }

    public function test_guest_cannot_access_messages(): void
    {
        $response = $this->get('/admin/messages');
        $response->assertRedirect('/login');
    }

    public function test_guest_cannot_access_register(): void
    {
        $response = $this->get('/register');
        $response->assertRedirect('/login');
    }

    public function test_guest_cannot_access_qrcode(): void
    {
        $response = $this->get('/admin/qrcode');
        $response->assertRedirect('/login');
    }

    public function test_password_reset_page_accessible(): void
    {
        $response = $this->get('/forgot-password');
        $response->assertStatus(200);
        $response->assertSee('Lupa Password');
    }

    public function test_email_verification_page_accessible(): void
    {
        $user = User::factory()->unverified()->create();
        $this->actingAs($user);

        $response = $this->get('/email/verify');
        $response->assertStatus(200);
    }
}
