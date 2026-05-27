<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         DB::table('courses')->insert([
             ['type' => 'Voorgerecht'],
             ['type' => 'Tussengerecht'],
             ['type' => 'Hoofdgerecht'],
             ['type' => 'Dessert'],
             ['type' => 'Cocktail'],
             ['type' => 'Koekje'],
             ['type' => 'Geen Recept'],
         ]);
    }
}
