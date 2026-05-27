<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('menus')->insert([
            ['id' => 1, 'name' => 'Klassiekers', 'is_veggie' => 0, 'price_3_course' => 45.00, 'price_4_course' => 52.00, 'date' => Carbon::createFromDate(2024, 5, 1)],
            ['id' => 2, 'name' => 'Smaakmakers menu', 'is_veggie' => 0, 'price_3_course' => 42.00, 'price_4_course' => 48.00, 'date' => Carbon::createFromDate(2024, 5, 1)->addMonth()],
            ['id' => 3, 'name' => 'Belgische trots', 'is_veggie' => 1, 'price_3_course' => 38.00, 'price_4_course' => 44.00, 'date' => Carbon::createFromDate(2024, 5, 2)],
            ['id' => 4, 'name' => 'Zin in zomer', 'is_veggie' => 1, 'price_3_course' => 39.00, 'price_4_course' => 45.00, 'date' => Carbon::createFromDate(2024, 5, 2)->addMonth()],
            ['id' => 5, 'name' => 'Bourgond', 'is_veggie' => 0, 'price_3_course' => 46.00, 'price_4_course' =>55.00, 'date' => null],
            ['id' => 6, 'name' => 'Cheese lover', 'is_veggie' => 1, 'price_3_course' => 40.00, 'price_4_course' => 46.00, 'date' => null],
        ]);
    }
}
