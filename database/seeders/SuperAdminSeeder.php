<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    public function run()
    {
        if (User::where('role', 'superadmin')->exists()) {
            $this->command->info('Superadmin already exists. Skipping...');
            return;
        }

        User::create([
            'name' => env('SUPERADMIN_NAME'),
            'category_id' => 1,
            'email' => env('SUPERADMIN_EMAIL'),
            'password' => Hash::make(env('SUPERADMIN_PASSWORD')),
            'role' => 'superadmin',
            'logo' => '/resources/images/avatar.webp'
        ]);

        $this->command->info('Superadmin created successfully.');
    }
}
