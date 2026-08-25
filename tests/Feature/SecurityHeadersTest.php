<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SecurityHeadersTest extends TestCase
{
    use RefreshDatabase;

    public function test_security_headers_are_set(): void
    {
        $response = $this->get('/');

        $response->assertHeader('X-Content-Type-Options', 'nosniff');
        $response->assertHeader('X-Frame-Options', 'DENY');
        $response->assertHeader('X-XSS-Protection', '1; mode=block');
        $response->assertHeader('Referrer-Policy', 'strict-origin-when-cross-origin');
        $response->assertHeader('Permissions-Policy', 'camera=(), microphone=(), geolocation=()');
        $response->assertHeader('Strict-Transport-Security', 'max-age=31536000; includeSubDomains');
        $response->assertHeader('Cross-Origin-Embedder-Policy', 'require-corp');
        $response->assertHeader('Cross-Origin-Opener-Policy', 'same-origin');
        $response->assertHeader('Cross-Origin-Resource-Policy', 'same-origin');
        $response->assertHeader('X-Permitted-Cross-Domain-Policies', 'none');
    }

    public function test_csp_header_is_set(): void
    {
        $response = $this->get('/');

        $response->assertHeader('Content-Security-Policy');
        $csp = $response->headers->get('Content-Security-Policy');
        $this->assertStringContainsString("default-src 'self'", $csp);
    }

    public function test_upload_proof_requires_signed_url(): void
    {
        $admin = User::factory()->create(['status' => 'admin']);
        $order = \App\Models\Order::factory()->create();

        $response = $this->actingAs($admin)->put("/pesan/{$order->id}/upload-proof", [
            'payment_proof' => 'fake-image',
        ]);

        $response->assertStatus(403);
    }
}
