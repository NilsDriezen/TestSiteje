<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CookieOrderLineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('cookie_order_lines')->insert([
            ['id' => 1, 'cookie_order_id' => 1, 'cookie_id' => 1, 'number_of_packs' => 2, 'price' => 10.00  ],
            ['id' => 2, 'cookie_order_id' => 1, 'cookie_id' => 4, 'number_of_packs' => 1, 'price' => 5.00],
            ['id' => 3, 'cookie_order_id' => 2, 'cookie_id' => 2, 'number_of_packs' => 3, 'price' => 6.00],
            ['id' => 4, 'cookie_order_id' => 3, 'cookie_id' => 1, 'number_of_packs' => 1,  'price' => 2.50],
            ['id' => 5, 'cookie_order_id' => 4, 'cookie_id' => 2, 'number_of_packs' => 2, 'price' => 6.00],
            ['id' => 6, 'cookie_order_id' => 4, 'cookie_id' => 3, 'number_of_packs' => 1, 'price' => 6.00],
            ['id' => 7, 'cookie_order_id' => 5, 'cookie_id' => 1, 'number_of_packs' => 4, 'price' => 5.00],
            ['id' => 8, 'cookie_order_id' => 5, 'cookie_id' => 2, 'number_of_packs' => 1, 'price' => 6.00],
            ['id' => 9, 'cookie_order_id' => 5, 'cookie_id' => 3, 'number_of_packs' => 2, 'price' => 6.00],
            ['id' => 10, 'cookie_order_id' => 5, 'cookie_id' => 4, 'number_of_packs' => 1, 'price' => 6.00],
            ['id' => 11, 'cookie_order_id' => 6, 'cookie_id' => 1, 'number_of_packs' => 3, 'price' => 7.50],
            ['id' => 12, 'cookie_order_id' => 7, 'cookie_id' => 2, 'number_of_packs' => 2, 'price' => 8.00],
            ['id' => 13, 'cookie_order_id' => 8, 'cookie_id' => 3, 'number_of_packs' => 1, 'price' => 9.00],
            ['id' => 14, 'cookie_order_id' => 9, 'cookie_id' => 4, 'number_of_packs' => 2, 'price' => 10.00],
            ['id' => 15, 'cookie_order_id' => 10, 'cookie_id' => 1, 'number_of_packs' => 3, 'price' => 11.00],
            ['id' => 16, 'cookie_order_id' => 11, 'cookie_id' => 2, 'number_of_packs' => 1, 'price' => 12.00],
            ['id' => 17, 'cookie_order_id' => 6, 'cookie_id' => 2, 'number_of_packs' => 2, 'price' => 8.00],
            ['id' => 18, 'cookie_order_id' => 7, 'cookie_id' => 3, 'number_of_packs' => 3, 'price' => 9.00],
            ['id' => 19, 'cookie_order_id' => 8, 'cookie_id' => 4, 'number_of_packs' => 1, 'price' => 10.00],
            ['id' => 20, 'cookie_order_id' => 9, 'cookie_id' => 1, 'number_of_packs' => 2, 'price' => 11.00],
            ['id' => 21, 'cookie_order_id' => 10, 'cookie_id' => 2, 'number_of_packs' => 3, 'price' => 12.00],
            ['id' => 22, 'cookie_order_id' => 11, 'cookie_id' => 3, 'number_of_packs' => 1, 'price' => 13.00],
        ]);
    }
}
