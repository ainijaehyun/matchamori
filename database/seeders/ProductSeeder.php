<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Product::factory()->count(50)->create();

        $products = [
          [  
            'category_id' => 'Matcha Powder',
            'name' => 'Matcha Ceremonial Grade',
            'price' => 75000,
            'stock' => 25,
            'description' => 'Ceremonial Grade MatchaMade from the finest young green tea leaves.Has a bright green color and a smooth, naturally sweet taste.Designed for traditional tea drinking with just hot water.',
            'image' => 'default.png'
          ],
          [
            'category_id' => 'Matcha Powder',
            'name' => 'Matcha Culinary Grade',
            'price' => 65000,
            'stock' => 50,
            'description' => 'Culinary Grade MatchaMade from older tea leaves lower on the plant.Features a strong, slightly bitter flavor that stands out in recipes.Ideal for baking cakes, making smoothies, or mixing with rich ingredients.',
            'image' => 'default.png'
          ],
          [
            'category_id' => 'Matcha Drink',
            'name' => 'Bottled Matcha Latte',
            'price' => 25000,
            'stock' => 70,
            'description' => 'Bottled Matcha LatteA ready-to-drink beverage made of matcha, milk, and sweetener.Served cold in a portable bottle for easy drinking anywhere.Offers a sweet, creamy flavor with no preparation required.',
            'image' => 'default.png'
          ],
          [
            'category_id' => 'Accessories',
            'name' => 'Chasen',
            'price' => 105000,
            'stock' => 19,
            'description' => 'ChasenA traditional whisk carved from a single piece of bamboo.Features fine prongs designed to mix matcha powder smoothly.Used to blend tea and water until a light, creamy foam forms on top.',
            'image' => 'default.png'
          ],
        ];

        foreach ($products as $product) {
            $category = Category::where('name', $product['category'])->first();

            Product::firstOrCreate(
                ['name' => $product['name']],
                [
                    'category_id' => $category->id,
                    'description' => $product['description'],
                    'price' => $product['price'],
                    'stock' => $product['stock'],
                    'image' => 'default.png',
                ]
            );
        }
    }
}
