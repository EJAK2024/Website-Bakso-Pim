<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class TwoFactorAuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_2fa_setup_page_requires_auth(): void
    {
        $response = $this->get('/admin/2fa/setup');
        $response->assertRedirect('/login');
    }

    public function test_admin_can_access_2fa_setup(): void
    {
        $admin = User::factory()->create(['status' => 'admin']);

        $response = $this->actingAs($admin)->get('/admin/2fa/setup');
        $response->assertStatus(200);
        $response->assertSee('Two-Factor Auth');
    }

    public function test_2fa_verify_page_requires_session(): void
    {
        $response = $this->get('/admin/2fa/verify');
        $response->assertRedirect('/login');
    }

    public function test_2fa_disable_requires_password(): void
    {
        $admin = User::factory()->create([
            'status' => 'admin',
            'two_factor_secret' => 'test-secret',
        ]);

        $response = $this->actingAs($admin)->post('/admin/2fa/disable', [
            'password' => 'wrongpassword',
        ]);

        $response->assertSessionHasErrors('password');
    }

    public function test_2fa_disabled_by_default(): void
    {
        $admin = User::factory()->create(['status' => 'admin']);

        $this->assertNull($admin->two_factor_secret);
        $this->assertNull($admin->two_factor_recovery_codes);
    }
}
