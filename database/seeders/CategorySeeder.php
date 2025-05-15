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
            'Technology & IT',
            'Healthcare & Life Sciences',
            'Finance & Business',
            'Education & Non-Profit',
            'Engineering & Industry',
            'Retail & Consumer Services',
            'Media & Design',
            'Environment & Infrastructure',
            'Logistics & Transportation',
            'Sports & Recreation'
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
