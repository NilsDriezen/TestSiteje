<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IngredientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('ingredients')->insert([
            ['id' => 1, 'name' => 'Boter', 'price' => 7.50],
            ['id' => 2, 'name' => 'Parmezaanse kaas', 'price' => 1.00],
            ['id' => 3, 'name' => 'Bloem', 'price' => 10.75],
            ['id' => 4, 'name' => 'Volle melk', 'price' => 1.25],
            ['id' => 5, 'name' => 'Olijfolie', 'price' => 0.75],
            ['id' => 6, 'name' => 'Nootmuskaat', 'price' => 0.25],
        ]);
    }
}
