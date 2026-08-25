<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_page_returns_200(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    public function test_home_page_contains_menu_section(): void
    {
        $response = $this->get('/');
        $response->assertSee('Bakso Pim');
    }

    public function test_order_page_returns_200(): void
    {
        $response = $this->get('/pesan');
        $response->assertStatus(200);
    }

    public function test_order_page_contains_order_form(): void
    {
        $response = $this->get('/pesan');
        $response->assertSee('Form Pemesanan');
        $response->assertSee('payment_method');
    }

    public function test_login_page_returns_200(): void
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
    }

    public function test_login_page_contains_login_form(): void
    {
        $response = $this->get('/login');
        $response->assertSee('Masuk Admin');
        $response->assertSee('dummy_email');
    }

    public function test_contact_form_exists_on_homepage(): void
    {
        $response = $this->get('/');
        $response->assertSee('Kirim Pesan');
        $response->assertSee('/kontak');
    }

    public function test_kritik_saran_section_exists(): void
    {
        $response = $this->get('/');
        $response->assertSee('kritik-saran');
        $response->assertSeeText('Kritik');
        $response->assertSeeText('Saran');
    }
}
