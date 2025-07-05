<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Technology and IT',
            'Healthcare and Life Sciences',
            'Finance and Business',
            'Education and Non-Profit',
            'Engineering and Industry',
            'Retail and Consumer Services',
            'Media and Design',
            'Environment and Infrastructure',
            'Logistics and Transportation',
            'Sports and Recreation'
        ];

        foreach ($categories as $category) {
            DB::table('categories')->insert([
                'name' => $category,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}
