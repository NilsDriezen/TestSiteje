<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CookieOrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $today = date('Y-m-d', strtotime('2024-06-07'));
        $yesterday = now()->subDay()->format('Y-m-d');

        DB::table('cookie_orders')->insert([
            ['id' => 1, 'date_pick_up' => '2024-06-07', 'time_slot' => '14:00 - 15:00', 'comment' => 'suikervrij aub', 'customer_name' => 'Stijn Koekskes', 'customer_phone_number' => '0483/123456', 'customer_email' => 'stijn@beuck.be', 'active' => false, 'total_price' => 10, 'is_new' => false],
            ['id' => 2, 'date_pick_up' => date('Y-m-d', strtotime($today . ' + ' . rand(0,20) . ' days')), 'time_slot' => '14:00 - 15:00', 'comment' => 'geen verpakking aub', 'customer_name' => 'Jef Potvis', 'customer_phone_number' => '0483/123456', 'customer_email' => 'jef@potvis.be', 'active' => true, 'total_price' => 20, 'is_new' => true],
            ['id' => 3, 'date_pick_up' => date('Y-m-d', strtotime($today . ' + ' . rand(0,20) . ' days')), 'time_slot' => '18:00 - 19:00', 'comment' => 'glutenvrij aub', 'customer_name' => 'Familie Wuyts', 'customer_phone_number' => '0473/123456', 'customer_email' => 'fam.wuyts@email.be', 'active' => true, 'total_price' => 30, 'is_new' => true],
            ['id' => 4, 'date_pick_up' => '2024-03-27', 'time_slot' => '18:00 - 19:00', 'comment' => 'geen verpakking aub', 'customer_name' => 'Familie Wuyts', 'customer_phone_number' => '0473/123456', 'customer_email' => 'test@test.be', 'active'=> false, 'total_price' => 40, 'is_new' => false],
            ['id' => 5, 'date_pick_up' => $today, 'time_slot' => '18:00 - 19:00', 'comment' => 'geen verpakking aub', 'customer_name' => 'Familie Wuyts', 'customer_phone_number' => '0473/123456', 'customer_email' => 'test@test.be', 'active'=> true, 'total_price' => 40, 'is_new' => false],
            ['id' => 6, 'date_pick_up' => $yesterday, 'time_slot' => '18:00 - 19:00', 'comment' => 'ik kom toch niet af', 'customer_name' => 'Familie Doefkes', 'customer_phone_number' => '0473/123456', 'customer_email' => 'test@test.be', 'active'=> true, 'total_price' => 40, 'is_new' => false],
            ['id' => 7, 'date_pick_up' => '2024-06-07', 'time_slot' => '10:00 - 11:00', 'comment' => 'extra chocolade', 'customer_name' => 'Jan Janssen', 'customer_phone_number' => '0483/123456', 'customer_email' => 'jan@janssen.be', 'active' => true, 'total_price' => 15, 'is_new' => false],
            ['id' => 8, 'date_pick_up' => '2024-06-06', 'time_slot' => '15:00 - 16:00', 'comment' => 'geen noten', 'customer_name' => 'Piet Pietersen', 'customer_phone_number' => '0483/123456', 'customer_email' => 'piet@pietersen.be', 'active' => true, 'total_price' => 25, 'is_new' => false],
            ['id' => 9, 'date_pick_up' => '2024-06-08', 'time_slot' => '11:00 - 12:00', 'comment' => 'extra suiker', 'customer_name' => 'Klaas Klaassen', 'customer_phone_number' => '0483/123456', 'customer_email' => 'klaas@klaassen.be', 'active' => true, 'total_price' => 35, 'is_new' => true],
            ['id' => 10, 'date_pick_up' => date('Y-m-d', strtotime($today . ' + ' . rand(0,60) . ' days')), 'time_slot' => '16:00 - 17:00', 'comment' => 'geen gluten', 'customer_name' => 'Bart Bartelsen', 'customer_phone_number' => '0483/123456', 'customer_email' => 'bart@bartelsen.be', 'active' => true, 'total_price' => 45, 'is_new' => true],
            ['id' => 11, 'date_pick_up' => date('Y-m-d', strtotime($today . ' + ' . rand(0,60) . ' days')), 'time_slot' => '12:00 - 13:00', 'comment' => 'extra vanille', 'customer_name' => 'Hans Hansen', 'customer_phone_number' => '0483/123456', 'customer_email' => 'hans@hansen.be', 'active' => true, 'total_price' => 55, 'is_new' => true],
        ]);
    }
}
