<?php

namespace Tests\Feature;

use App\Models\Menu;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminCrudTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->create(['status' => 'admin']);
    }

    public function test_admin_can_see_dashboard(): void
    {
        $response = $this->actingAs($this->admin)->get('/admin');
        $response->assertStatus(200);
        $response->assertSee('Dashboard');
        $response->assertSee('Selamat datang');
    }

    public function test_admin_can_see_menu_index(): void
    {
        Menu::factory()->count(3)->create();

        $response = $this->actingAs($this->admin)->get('/admin/menu');
        $response->assertStatus(200);
    }

    public function test_admin_can_create_menu(): void
    {
        $response = $this->actingAs($this->admin)->post('/admin/menu', [
            'name' => 'Bakso Special',
            'category' => 'makanan',
            'description' => 'Bakso dengan kuah spesial',
            'price' => 25000,
        ]);

        $this->assertDatabaseHas('menus', [
            'name' => 'Bakso Special',
            'category' => 'makanan',
            'price' => 25000,
        ]);
    }

    public function test_admin_can_update_menu(): void
    {
        $menu = Menu::factory()->create(['name' => 'Old Name']);

        $response = $this->actingAs($this->admin)->put("/admin/menu/{$menu->id}", [
            'name' => 'New Name',
            'category' => $menu->category,
            'price' => $menu->price,
        ]);

        $this->assertDatabaseHas('menus', [
            'id' => $menu->id,
            'name' => 'New Name',
        ]);
    }

    public function test_admin_can_delete_menu(): void
    {
        $menu = Menu::factory()->create();

        $response = $this->actingAs($this->admin)->delete("/admin/menu/{$menu->id}");

        $this->assertDatabaseMissing('menus', ['id' => $menu->id]);
    }

    public function test_admin_can_see_orders(): void
    {
        $response = $this->actingAs($this->admin)->get('/admin/orders');
        $response->assertStatus(200);
    }

    public function test_admin_can_see_messages(): void
    {
        $response = $this->actingAs($this->admin)->get('/admin/messages');
        $response->assertStatus(200);
    }

    public function test_admin_can_access_qrcode(): void
    {
        $response = $this->actingAs($this->admin)->get('/admin/qrcode');
        $response->assertStatus(200);
        $response->assertSee('QR Code');
    }

    public function test_non_admin_cannot_access_crud(): void
    {
        $kasir = User::factory()->create(['status' => 'kasir']);

        $routes = ['/admin', '/admin/menu', '/admin/orders', '/admin/messages', '/admin/qrcode'];

        foreach ($routes as $route) {
            $response = $this->actingAs($kasir)->get($route);
            $response->assertStatus(403);
        }
    }
}
