<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin Bakso Pim',
            'email' => 'admin@baksopim.com',
            'phone' => '081234567890',
            'status' => 'admin',
            'password' => bcrypt('admin123'),
        ]);

        $this->call(MenuSeeder::class);
    }
}
