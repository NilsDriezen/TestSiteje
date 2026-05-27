<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DishSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('dishes')->insert([
            ['name' => 'Tomatensoep met balletjes', 'instruction' => 'Kook de tomaten en voeg de balletjes toe',
                'preparation_time' => 10, 'serving' => 4, 'recipe_tag' => 'Soep', 'comment' => 'Lekker', 'calorie' => 200,
                'active' => true, 'course_id' => 1, 'path' => 'tomatensoep.jpg', 'cooking_time' => 20,
            ],
            ['name' => 'Tomaat Crevette', 'instruction' => 'Kook de tomaten en voeg de garnalen toe',
                'preparation_time' => 10, 'serving' => 4, 'recipe_tag' => 'Voorgerecht', 'comment' => 'Lekker', 'calorie' => 200,
                'active' => true, 'course_id' => 1, 'path' => 'tomatencrevette.jpg', 'cooking_time' => 20,
            ],
            ['name' => 'Vol-au-vent met luchtig gebakje en krieaardappeltjes', 'instruction' => 'Kook de kip en voeg de groenten toe',
                'preparation_time' => 10, 'serving' => 4, 'recipe_tag' => 'Hoofdgerecht', 'comment' => 'Lekker', 'calorie' => 200,
                'active' => true, 'course_id' => 3, 'path' => 'volauvent.jpg', 'cooking_time' => 20,
            ],
            ['name' => 'Vlaamse tiramisu met speculaas', 'instruction' => 'Maak de tiramisu en voeg de speculaas toe',
                'preparation_time' => 10, 'serving' => 4, 'recipe_tag' => 'Dessert', 'comment' => 'Lekker', 'calorie' => 200,
                'active' => true, 'course_id' => 4, 'path' => 'vlaamsetiramisu.jpg', 'cooking_time' => 20,
            ],
        ]);
    }
}
