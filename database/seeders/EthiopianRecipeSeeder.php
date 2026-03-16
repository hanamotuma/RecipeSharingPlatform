<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Recipe;
use App\Models\User;
use App\Models\Category;

class EthiopianRecipeSeeder extends Seeder
{
    public function run(): void
    {
       
        $user = User::first();
        if (!$user) {
            $user = User::create([
                'name' => 'Ethiopian Chef',
                'email' => 'ethiopian@example.com',
                'password' => bcrypt('password'),
            ]);
        }

       
        $dinnerCategory = Category::where('name', 'Dinner')->first();
        $lunchCategory = Category::where('name', 'Lunch')->first();
        $breakfastCategory = Category::where('name', 'Breakfast')->first();

        
        if (!$dinnerCategory) {
            $dinnerCategory = Category::create(['name' => 'Dinner']);
        }
        if (!$lunchCategory) {
            $lunchCategory = Category::create(['name' => 'Lunch']);
        }
        if (!$breakfastCategory) {
            $breakfastCategory = Category::create(['name' => 'Breakfast']);
        }

        // 6 Famous Ethiopian Recipes
        $ethiopianRecipes = [
            [
                'title' => 'Doro Wat - ዶሮ ወጥ (Spicy Ethiopian Chicken Stew)',
                'description' => 'The crown jewel of Ethiopian cuisine! Doro Wat is a spicy, flavorful chicken stew slow-cooked with berbere spice, niter kibbeh (spiced butter), and hard-boiled eggs. This iconic dish is traditionally served during holidays and special celebrations.',
                'ingredients' => "• 1 whole chicken, cut into pieces\n• 2 large onions, finely chopped\n• 1/2 cup niter kibbeh (Ethiopian spiced butter)\n• 1/4 cup berbere spice\n• 4 cloves garlic, minced\n• 1 tbsp ginger, grated\n• 1 cup chicken broth\n• 6 hard-boiled eggs, peeled\n• Juice of 2 lemons\n• Salt to taste",
                'instructions' => "1. Clean chicken pieces with lemon juice and salt, rinse well.\n2. In a large pot, cook onions without oil over medium heat until they release moisture (about 10 minutes).\n3. Add niter kibbeh and continue cooking until onions are golden.\n4. Stir in berbere, garlic, and ginger. Cook for 5 minutes until fragrant.\n5. Add chicken pieces and coat well with the spice mixture.\n6. Pour in chicken broth, bring to boil, then reduce heat.\n7. Cover and simmer for 45 minutes, stirring occasionally.\n8. Add hard-boiled eggs and cook for another 15 minutes.\n9. Adjust salt to taste.\n10. Serve hot with injera or rice.",
                'cooking_time' => 90,
                'difficulty' => 'hard',
                'category_id' => $dinnerCategory->id,
            ],
            [
                'title' => 'Kitfo - ክትፎ (Ethiopian Minced Beef)',
                'description' => 'A beloved Ethiopian delicacy of minced raw beef seasoned with mitmita spice and niter kibbeh. This dish is often served with ayib (Ethiopian cottage cheese) and greens. For those who prefer cooked meat, it can also be served lightly cooked (leb leb).',
                'ingredients' => "• 500g lean beef, minced very fine\n• 1/4 cup niter kibbeh (spiced butter)\n• 2 tbsp mitmita spice\n• 1 tsp cardamom powder\n• Salt to taste\n\nFor Serving:\n• Ayib (Ethiopian cottage cheese)\n• Gomen (cooked collard greens)\n• Fresh injera",
                'instructions' => "1. Start with the freshest beef possible.\n2. Mince the beef very finely or have it ground twice.\n3. In a pan, melt niter kibbeh over low heat.\n4. Add mitmita and cardamom, stir for 1 minute.\n5. For traditional kitfo (raw): Pour the spiced butter over the raw meat and mix well.\n6. For leb leb (rare): Add meat to the pan and cook for 1-2 minutes.\n7. Season with salt.\n8. Serve immediately with ayib, gomen, and injera.",
                'cooking_time' => 20,
                'difficulty' => 'medium',
                'category_id' => $dinnerCategory->id,
            ],
            [
                'title' => 'Shiro Wat - ሽሮ ወጥ (Ethiopian Chickpea Stew)',
                'description' => 'A staple in Ethiopian households, this hearty stew is made from ground chickpeas simmered with onions, garlic, and berbere spice. It\'s vegan-friendly, protein-rich, and absolutely delicious. Perfect for fasting days!',
                'ingredients' => "• 1 cup shiro powder (ground chickpeas with spices)\n• 1 large onion, finely chopped\n• 1/4 cup vegetable oil or niter kibbeh\n• 3 tbsp berbere spice\n• 4 cloves garlic, minced\n• 1 tbsp ginger, grated\n• 4 cups water\n• Salt to taste\n• 2 tbsp tomato paste (optional)",
                'instructions' => "1. In a large pot, sauté onions in oil until soft and golden (about 10 minutes).\n2. Add berbere, garlic, and ginger. Cook for 3-4 minutes.\n3. Gradually add water while stirring to prevent lumps.\n4. Slowly whisk in shiro powder, making sure no lumps form.\n5. Bring to a simmer and cook for 20-25 minutes, stirring frequently.\n6. Add tomato paste if using.\n7. Season with salt.\n8. Simmer for another 5 minutes.\n9. Serve hot with fresh injera.",
                'cooking_time' => 40,
                'difficulty' => 'easy',
                'category_id' => $lunchCategory->id,
            ],
            [
                'title' => 'Tibs - ጥብስ (Sizzling Ethiopian Meat Sauté)',
                'description' => 'A sizzling Ethiopian favorite! Cubed meat (beef or lamb) is sautéed with onions, peppers, and aromatic spices. Served on a hot platter, this dish is perfect for sharing. The sizzling sound as it arrives at your table is music to any food lover\'s ears!',
                'ingredients' => "• 500g beef sirloin or lamb, cut into cubes\n• 2 large onions, sliced\n• 3 tomatoes, diced\n• 2 green peppers, sliced\n• 4 cloves garlic, minced\n• 1 tbsp ginger, grated\n• 2 tbsp niter kibbeh or oil\n• 2 tbsp berbere spice\n• 1 tsp rosemary (optional)\n• Salt and pepper to taste",
                'instructions' => "1. Season meat with salt and let sit for 15 minutes.\n2. Heat niter kibbeh in a large pan over high heat.\n3. Add meat and sear until browned on all sides.\n4. Remove meat and set aside.\n5. In the same pan, sauté onions until translucent.\n6. Add garlic, ginger, and berbere. Cook for 2 minutes.\n7. Return meat to pan, add tomatoes and peppers.\n8. Cook for 5-7 minutes until vegetables are tender.\n9. Add rosemary if using.\n10. Serve sizzling hot with injera.",
                'cooking_time' => 35,
                'difficulty' => 'medium',
                'category_id' => $dinnerCategory->id,
            ],
            [
                'title' => 'Misir Wat - ምስር ወጥ (Ethiopian Red Lentil Stew)',
                'description' => 'A comforting red lentil stew that\'s a cornerstone of Ethiopian cuisine. Slowly simmered with berbere spice and aromatics, this vegan dish is rich, satisfying, and packed with protein. It\'s a must-try for anyone exploring Ethiopian food!',
                'ingredients' => "• 2 cups red lentils, rinsed\n• 1 large onion, finely chopped\n• 1/4 cup vegetable oil\n• 3 tbsp berbere spice\n• 4 cloves garlic, minced\n• 1 tbsp ginger, grated\n• 1 tbsp tomato paste\n• 4 cups water\n• Salt to taste",
                'instructions' => "1. Rinse lentils until water runs clear.\n2. In a large pot, sauté onions in oil until very soft (about 10 minutes).\n3. Add berbere, garlic, and ginger. Cook for 3-4 minutes.\n4. Stir in tomato paste and cook for 1 minute.\n5. Add lentils and water, bring to a boil.\n6. Reduce heat and simmer for 30-40 minutes, stirring occasionally.\n7. Season with salt.\n8. Serve hot with injera.",
                'cooking_time' => 50,
                'difficulty' => 'easy',
                'category_id' => $lunchCategory->id,
            ],
            [
                'title' => 'Firfir - ፍርፍር (Ethiopian Spiced Injera Breakfast)',
                'description' => 'A delicious breakfast or brunch dish made from torn pieces of injera mixed with spicy berbere sauce. Often made with leftover injera, this dish is also popular as a quick meal. Some versions include meat for extra protein.',
                'ingredients' => "For the Sauce:\n• 2 large onions, chopped\n• 1/4 cup niter kibbeh or oil\n• 3 tbsp berbere spice\n• 2 tomatoes, blended\n• 1 cup water\n• Salt to taste\n\nFor the Dish:\n• 4-5 pieces of injera, torn into pieces\n• 2 hard-boiled eggs (optional)\n• 1/2 cup yogurt (optional)",
                'instructions' => "1. In a large pan, sauté onions in niter kibbeh until golden.\n2. Add berbere and cook for 3 minutes.\n3. Pour in blended tomatoes and water, simmer for 10 minutes.\n4. Season sauce with salt.\n5. Add torn injera pieces to the sauce.\n6. Mix well until injera absorbs the sauce and becomes soft.\n7. Cook for 2-3 minutes, stirring constantly.\n8. Serve hot, topped with hard-boiled eggs and yogurt.\n9. Enjoy for breakfast!",
                'cooking_time' => 25,
                'difficulty' => 'easy',
                'category_id' => $breakfastCategory->id,
            ]
        ];

        foreach ($ethiopianRecipes as $recipeData) {
            Recipe::create(array_merge($recipeData, [
                'user_id' => $user->id,
            ]));
        }

        $this->command->info('✅ 6 Famous Ethiopian recipes added successfully!');
        $this->command->info('🇪🇹 እንኳን ደህና መጣችሁ! (Welcome!)');
    }
}