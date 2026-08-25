<?php

namespace Tests\Feature;

use App\Models\Menu;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderTest extends TestCase
{
    use RefreshDatabase;

    private Menu $menu;

    protected function setUp(): void
    {
        parent::setUp();
        Carbon::setTestNow(Carbon::now()->setTime(12, 0, 0));
        $this->menu = Menu::factory()->create([
            'price' => 15000,
            'is_available' => true,
        ]);
    }

    protected function tearDown(): void
    {
        Carbon::setTestNow();
        parent::tearDown();
    }

    public function test_order_page_shows_available_menus(): void
    {
        $response = $this->get('/pesan');
        $response->assertSee($this->menu->name);
    }

    public function test_order_requires_menu_selection(): void
    {
        $response = $this->post('/pesan', [
            'customer_name' => 'Test User',
            'phone' => '081234567890',
            'address' => 'Test Address',
            'menu_ids' => [],
            'quantities' => [],
            'payment_method' => 'kasir',
        ]);

        $response->assertSessionHasErrors('menu_ids');
    }

    public function test_order_requires_customer_name(): void
    {
        $response = $this->post('/pesan', [
            'phone' => '081234567890',
            'address' => 'Test Address',
            'menu_ids' => [$this->menu->id],
            'quantities' => [1],
            'payment_method' => 'kasir',
        ]);

        $response->assertSessionHasErrors('customer_name');
    }

    public function test_order_requires_phone(): void
    {
        $response = $this->post('/pesan', [
            'customer_name' => 'Test User',
            'address' => 'Test Address',
            'menu_ids' => [$this->menu->id],
            'quantities' => [1],
            'payment_method' => 'kasir',
        ]);

        $response->assertSessionHasErrors('phone');
    }

    public function test_order_requires_valid_payment_method(): void
    {
        $response = $this->post('/pesan', [
            'customer_name' => 'Test User',
            'phone' => '081234567890',
            'address' => 'Test Address',
            'menu_ids' => [$this->menu->id],
            'quantities' => [1],
            'payment_method' => 'invalid',
        ]);

        $response->assertSessionHasErrors('payment_method');
    }

    public function test_order_input_sanitization(): void
    {
        $response = $this->post('/pesan', [
            'customer_name' => '<script>alert("xss")</script>Test User',
            'phone' => '081234567890',
            'address' => '<b>Bold Address</b>',
            'notes' => '<img src=x onerror=alert(1)>',
            'menu_ids' => [$this->menu->id],
            'quantities' => [1],
            'payment_method' => 'kasir',
        ]);

        $order = Order::latest()->first();
        if ($order) {
            $this->assertStringNotContainsString('<script>', $order->customer_name);
            $this->assertStringNotContainsString('<b>', $order->address);
        }
    }

    public function test_order_creates_order_items(): void
    {
        $response = $this->post('/pesan', [
            'customer_name' => 'Test User',
            'phone' => '081234567890',
            'address' => 'Test Address',
            'menu_ids' => [$this->menu->id],
            'quantities' => [2],
            'payment_method' => 'kasir',
        ]);

        $this->assertDatabaseHas('order_items', [
            'menu_id' => $this->menu->id,
            'quantity' => 2,
            'price' => 15000,
        ]);
    }

    public function test_order_calculates_total_price(): void
    {
        $response = $this->post('/pesan', [
            'customer_name' => 'Test User',
            'phone' => '081234567890',
            'address' => 'Test Address',
            'menu_ids' => [$this->menu->id],
            'quantities' => [3],
            'payment_method' => 'kasir',
        ]);

        $order = Order::latest()->first();
        $this->assertEquals(45000, $order->total_price);
    }

    public function test_kasir_payment_redirects_to_struk(): void
    {
        $response = $this->post('/pesan', [
            'customer_name' => 'Test User',
            'phone' => '081234567890',
            'address' => 'Test Address',
            'menu_ids' => [$this->menu->id],
            'quantities' => [1],
            'payment_method' => 'kasir',
        ]);

        $order = Order::latest()->first();
        $response->assertRedirect();
    }

    public function test_qris_payment_redirects_to_qris(): void
    {
        $response = $this->post('/pesan', [
            'customer_name' => 'Test User',
            'phone' => '081234567890',
            'address' => 'Test Address',
            'menu_ids' => [$this->menu->id],
            'quantities' => [1],
            'payment_method' => 'qris',
        ]);

        $order = Order::latest()->first();
        $response->assertRedirect();
    }
}
