<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuDishSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('menu_dishes')->insert([
            ['menu_id' => 1, 'dish_id' => 2],
            ['menu_id' => 1, 'dish_id' => 3],
            ['menu_id' => 1, 'dish_id' => 4],
            ['menu_id' => 1, 'dish_id' => 5],
            ['menu_id' => 2, 'dish_id' => 6],
            ['menu_id' => 2, 'dish_id' => 7],
            ['menu_id' => 2, 'dish_id' => 8],
            ['menu_id' => 2, 'dish_id' => 9],
            ['menu_id' => 3, 'dish_id' => 10],
            ['menu_id' => 3, 'dish_id' => 11],
            ['menu_id' => 3, 'dish_id' => 12],
            ['menu_id' => 3, 'dish_id' => 13],
            ['menu_id' => 4, 'dish_id' => 14],
            ['menu_id' => 4, 'dish_id' => 18],
            ['menu_id' => 4, 'dish_id' => 19],
            ['menu_id' => 4, 'dish_id' => 20],
            ['menu_id' => 5, 'dish_id' => 2],
            ['menu_id' => 5, 'dish_id' => 7],
            ['menu_id' => 5, 'dish_id' => 4],
            ['menu_id' => 5, 'dish_id' => 9],
            ['menu_id' => 6, 'dish_id' => 10],
            ['menu_id' => 6, 'dish_id' => 18],
            ['menu_id' => 6, 'dish_id' => 12],
            ['menu_id' => 6, 'dish_id' => 20],
        ]);
    }
}
