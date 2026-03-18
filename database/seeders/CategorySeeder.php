<?php
//This section is to make it dynamic and to add more categories in the future without changing the code
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Breakfast',
                'description' => 'Start your day right with these delicious breakfast recipes',
                'icon' => '🍳'
            ],
            [
                'name' => 'Lunch',
                'description' => 'Quick and satisfying lunch ideas for your midday meal',
                'icon' => '🥪'
            ],
            [
                'name' => 'Dinner',
                'description' => 'Hearty and delicious dinner recipes for the whole family',
                'icon' => '🍽️'
            ],
            [
                'name' => 'Dessert',
                'description' => 'Sweet treats and desserts to satisfy your cravings',
                'icon' => '🍰'
            ],
            [
                'name' => 'Drinks',
                'description' => 'Refreshing beverages, smoothies, and cocktails',
                'icon' => '🥤'
            ],
            [
                'name' => 'Quick & Easy',
                'description' => 'Recipes ready in 30 minutes or less',
                'icon' => '⚡'
            ],
            [
                'name' => 'Vegan',
                'description' => 'Plant-based recipes free from animal products',
                'icon' => '🌱'
            ],
            [
                'name' => 'Seafood',
                'description' => 'Fresh fish and seafood recipes',
                'icon' => '🐟'
            ],
            [
                'name' => 'Baking',
                'description' => 'Breads, pastries, and baked goods',
                'icon' => '🥐'
            ],
            [
                'name' => 'Cakes & Cupcakes',
                'description' => 'Sweet cakes for every celebration',
                'icon' => '🧁'
            ],
            [
                'name' => 'Cookies',
                'description' => 'Homemade cookies and bars',
                'icon' => '🍪'
            ],
            // NEW CATEGORY: Soups
            [
                'name' => 'Soups',
                'description' => 'Warm and comforting soups from around the world',
                'icon' => '🥣'
            ],
        ];

        foreach ($categories as $categoryData) {
            Category::updateOrCreate(
                ['name' => $categoryData['name']],
                [
                    'slug' => Str::slug($categoryData['name']),
                    'description' => $categoryData['description'] ?? null,
                    'icon' => $categoryData['icon'] ?? null
                ]
            );
        }

        $this->command->info('✅ ' . count($categories) . ' categories seeded successfully!');
    }
}