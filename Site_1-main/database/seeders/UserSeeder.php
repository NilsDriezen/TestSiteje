<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Data van de gebruikers gebaseerd op de data van prototype
        DB::table('users')->insert([
            ['id' => 1, 'first_name' => 'Sofie', 'last_name' => 'Van Geel', 'phone_number' => '0478123123', 'active' => 1, 'password' => Hash::make('password'), 'admin' => 0, 'email' => 's.vangeel@mail.com'],
            ['id' => 2, 'first_name' => 'Marie', 'last_name' => 'Van Dessel', 'phone_number' => '0489345345', 'active' => 0, 'password' => Hash::make('password'), 'admin' => 1, 'email' => 'm.vandessel@mail.com'],
            ['id' => 3, 'first_name' => 'Hans', 'last_name' => 'Van Balen', 'phone_number' => '0468456456', 'active' => 1, 'password' => Hash::make('password'), 'admin' => 1, 'email' => 'h.vanbalen@mail.com'],
            ['id' => 4, 'first_name' => 'Tim', 'last_name' => 'Timmers', 'phone_number' => '0432484749', 'active' => 0, 'password' => Hash::make('password'), 'admin' => 0, 'email' => 't.timmers@mail.com'],
            ['id' => 5, 'first_name' => 'John', 'last_name' => 'Doe', 'phone_number' => '0432484740', 'active' => 1, 'password' => Hash::make('admin1234'), 'admin' => 1, 'email' => 'john.doe@example.com'],
            // echte user voor de demo
            ['id' => 6, 'first_name' => 'Halim', 'last_name' => 'Haidari', 'phone_number' => '0432484740', 'active' => 1, 'password' => Hash::make('admin1234'), 'admin' => 1, 'email' => 'r0766583@student.thomasmore.be'],
        ]);
    }
}


//        $faker = Faker::create('nl_NL'); // Create a Dutch faker
//
//        for ($i = 0; $i < 10; $i++) { // Create 10 users
//            DB::table('users')->insert([
//                'first_name' => $faker->firstName,
//                'last_name' => $faker->lastName,
//                'phone_number' => $faker->phoneNumber,
//                'active' => $faker->boolean,
//                'password' => Hash::make('password'),
//                'admin' => $faker->boolean,
//                'email' => $faker->unique()->safeEmail,
//            ]);
//        }
