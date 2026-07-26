<?php

namespace Database\Seeders;

use App\Models\Menu;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    public function run(): void
    {
        $menus = [
            ['name' => 'Bakso Biasa', 'category' => 'makanan', 'description' => 'Bakso dengan ukuran sedang, sempurna untuk semua kalangan', 'price' => 15000],
            ['name' => 'Bakso Urat', 'category' => 'makanan', 'description' => 'Bakso urat dengan tekstur kenyal dan rasa gurih', 'price' => 20000],
            ['name' => 'Bakso Besar', 'category' => 'makanan', 'description' => 'Bakso super untuk pecinta bakso sejati, ukuran besar lebih puas', 'price' => 25000],
            ['name' => 'Bakso Spesial', 'category' => 'makanan', 'description' => 'Paket spesial dengan tambahan Bakso Super dan Urat serta topping lengkap', 'price' => 35000],
            ['name' => 'Paket Keluarga', 'category' => 'makanan', 'description' => 'Paket komplit untuk keluarga dengan berbagai macam bakso', 'price' => 100000],
            ['name' => 'Es Teh Manis', 'category' => 'minuman', 'description' => 'Teh manis segar dengan es batu, pelepas dahaga', 'price' => 5000],
            ['name' => 'Es Jeruk', 'category' => 'minuman', 'description' => 'Perasan jeruk segar asli, nikmat dan kaya vitamin', 'price' => 7000],
            ['name' => 'Kopi Hitam', 'category' => 'minuman', 'description' => 'Kopi pilihan dengan rasa kuat dan aroma khas', 'price' => 8000],
            ['name' => 'Air Mineral', 'category' => 'minuman', 'description' => 'Air mineral murni dari sumber mata air pegunungan', 'price' => 3000],
        ];

        foreach ($menus as $menu) {
            Menu::create($menu);
        }
    }
}
