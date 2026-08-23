<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $password = Str::random(12);

        User::create([
            'name' => 'Admin Bakso Pim',
            'email' => 'admin@baksopim.com',
            'phone' => '081234567890',
            'status' => 'admin',
            'password' => Hash::make($password),
        ]);

        $this->command->info('Admin created successfully!');
        $this->command->info('Email: admin@baksopim.com');
        $this->command->info('Password: ' . $password);
        $this->command->warn('SAVE THIS PASSWORD! It will not be shown again.');

        $this->call(MenuSeeder::class);
    }
}
