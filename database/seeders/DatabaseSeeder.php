<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call([
            UserSeeder::class,
            AgendaSeeder::class,
            CourseSeeder::class,
            DishSeeder::class,
            CocktailSeeder::class,
            MenuSeeder::class,
            ReservationSeeder::class,
            ReservationMenuSeeder::class,
            IngredientSeeder::class,
            CookieSeeder::class,
            CookieOrderSeeder::class,
            DishIngredientSeeder::class,
            EmailMessageSeeder::class,
            MenuDishSeeder::class,
            ReviewSeeder::class,
            TemplateWebpageSeeder::class,
            CookieOrderLineSeeder::class,
        ]);
    }
}
