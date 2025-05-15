<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Superadmin',
            'email' => 'superadmin@job-platform.com',
            'password' => bcrypt('asdasd'),
            'logo' => 'https://picsum.photos/200?random=' . rand(1, 1000),
            'role' => 'superadmin',
        ]);

        $this->call([
            CategorySeeder::class,
            JobSeeder::class
        ]);
    }
}
