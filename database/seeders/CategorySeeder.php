<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Category::factory()->count(50)->create();

        $categories = [
            [
                'name' => 'Matcha Drink',
                'description' => 'Refreshing beverages made with premium green tea.Enjoy hot or iced options crafted to perfection.',
                'image' => 'default.png',
            ],
            [
                'name' => 'Matcha Dessert',
                'description' => 'Sweet treats infused with rich green tea flavor.Taste delicious cakes, pastries, and ice cream.',
                'image' => 'default.png', 
            ],
            [
                'name' => 'Matcha Powder',
                'description' => 'High-quality green tea powder for your daily brewing.Choose from ceremonial or culinary grades.',
                'image' => 'default.png',
            ],
            [
                'name' => 'Accessories',
                'description' => 'Esssential tools to prepare your favorite tea. Find bamboo whisks, bowls, and scoops.'
            ],
        ];

        foreach ($categories as $category) {
            Category::firstOrCreate(
                ['name' => $category['name']],
                $category
            );
        }
    }
}
