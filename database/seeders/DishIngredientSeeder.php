<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DishIngredientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('dish_ingredients')->insert([
            ['id' => 1, 'dish_id' => 1, 'ingredient_id' => 1, 'quantity' => 2, 'measurement_unit' => 'eetlepels'],
            ['id' => 2, 'dish_id' => 1, 'ingredient_id' => 2, 'quantity' => 3, 'measurement_unit' => 'kop'],
            ['id' => 3, 'dish_id' => 1, 'ingredient_id' => 3, 'quantity' => 0.3, 'measurement_unit' => 'teen'],
            ['id' => 4, 'dish_id' => 1, 'ingredient_id' => 4, 'quantity' => 1, 'measurement_unit' => 'kop'],
            ['id' => 5, 'dish_id' => 1, 'ingredient_id' => 5, 'quantity' => 3, 'measurement_unit' => 'theelepel'],
            ['id' => 6, 'dish_id' => 1, 'ingredient_id' => 6, 'quantity' => 4.5, 'measurement_unit' => 'snuif'],

            ['id' => 7, 'dish_id' => 2, 'ingredient_id' => 1, 'quantity' => 2, 'measurement_unit' => 'eetlepels'],
            ['id' => 8, 'dish_id' => 2, 'ingredient_id' => 2, 'quantity' => 3, 'measurement_unit' => 'kop'],
            ['id' => 9, 'dish_id' => 2, 'ingredient_id' => 3, 'quantity' => 0.3, 'measurement_unit' => 'teen'],
            ['id' => 10, 'dish_id' => 2, 'ingredient_id' => 4, 'quantity' => 1, 'measurement_unit' => 'kop'],
            ['id' => 11, 'dish_id' => 2, 'ingredient_id' => 5, 'quantity' => 3, 'measurement_unit' => 'theelepel'],
            ['id' => 12, 'dish_id' => 2, 'ingredient_id' => 6, 'quantity' => 4.5, 'measurement_unit' => 'snuif'],

            ['id' => 13, 'dish_id' => 3, 'ingredient_id' => 1, 'quantity' => 2, 'measurement_unit' => 'eetlepels'],
            ['id' => 14, 'dish_id' => 3, 'ingredient_id' => 2, 'quantity' => 3, 'measurement_unit' => 'kop'],
            ['id' => 15, 'dish_id' => 3, 'ingredient_id' => 3, 'quantity' => 0.3, 'measurement_unit' => 'teen'],
            ['id' => 16, 'dish_id' => 3, 'ingredient_id' => 4, 'quantity' => 1, 'measurement_unit' => 'kop'],
            ['id' => 17, 'dish_id' => 3, 'ingredient_id' => 5, 'quantity' => 3, 'measurement_unit' => 'theelepel'],
            ['id' => 18, 'dish_id' => 3, 'ingredient_id' => 6, 'quantity' => 4.5, 'measurement_unit' => 'snuif'],

            ['id' => 19, 'dish_id' => 4, 'ingredient_id' => 1, 'quantity' => 2, 'measurement_unit' => 'eetlepels'],
            ['id' => 20, 'dish_id' => 4, 'ingredient_id' => 2, 'quantity' => 3, 'measurement_unit' => 'kop'],
            ['id' => 21, 'dish_id' => 4, 'ingredient_id' => 3, 'quantity' => 0.3, 'measurement_unit' => 'teen'],
            ['id' => 22, 'dish_id' => 4, 'ingredient_id' => 4, 'quantity' => 1, 'measurement_unit' => 'kop'],
            ['id' => 23, 'dish_id' => 4, 'ingredient_id' => 5, 'quantity' => 3, 'measurement_unit' => 'theelepel'],
            ['id' => 24, 'dish_id' => 4, 'ingredient_id' => 6, 'quantity' => 4.5, 'measurement_unit' => 'snuif'],
        ]);
    }
}
