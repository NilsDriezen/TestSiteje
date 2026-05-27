<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReservationMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('reservation_menus')->insert([
            ['id' => 1, 'reservation_id' => 1, 'menu_id' => 1, 'quantity' => 2],
            ['id' => 2, 'reservation_id' => 1, 'menu_id' => 2, 'quantity' => 5],
            ['id' => 3, 'reservation_id' => 1, 'menu_id' => 3, 'quantity' => 0],
            ['id' => 4, 'reservation_id' => 1, 'menu_id' => 4, 'quantity' => 6],
            ['id' => 5, 'reservation_id' => 2, 'menu_id' => 1, 'quantity' => 2],
            ['id' => 6, 'reservation_id' => 2, 'menu_id' => 2, 'quantity' => 0],
            ['id' => 7, 'reservation_id' => 2, 'menu_id' => 3, 'quantity' => 5],
            ['id' => 8, 'reservation_id' => 3, 'menu_id' => 1, 'quantity' => 0],
            ['id' => 9, 'reservation_id' => 3, 'menu_id' => 2, 'quantity' => 0],
            ['id' => 10, 'reservation_id' => 3, 'menu_id' => 3, 'quantity' => 8],
            ['id' => 11, 'reservation_id' => 3, 'menu_id' => 4, 'quantity' => 1],
            ['id' => 12, 'reservation_id' => 4, 'menu_id' => 1, 'quantity' => 4],
            ['id' => 13, 'reservation_id' => 4, 'menu_id' => 2, 'quantity' => 0],
            ['id' => 14, 'reservation_id' => 4, 'menu_id' => 3, 'quantity' => 0],
            ['id' => 15, 'reservation_id' => 4, 'menu_id' => 4, 'quantity' => 2],
        ]);
    }
}
