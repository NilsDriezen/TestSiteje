<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('reviews')->insert([
            ['id' => 1, 'name' => 'Jaak', 'message' => 'Het eten was enorm lekker', 'is_approved' => 1, 'date' => '2021-10-01', 'is_new' => 0],
            ['id' => 2, 'name' => 'Anoniem', 'message' => 'Het vlees was zeer zacht en smolt op de tong.', 'is_approved' => 1, 'date' => '2021-10-02', 'is_new' => 0],
            ['id' => 3, 'name' => 'Marie', 'message' => 'Wij komen zeker nog eens langs!', 'is_approved' => 1, 'date' => '2021-10-03', 'is_new' => 0],
            ['id' => 4, 'name' => 'Michel', 'message' => 'Doen we zeker opnieuw!', 'is_approved' => 1, 'date' => '2021-10-04', 'is_new' => 0],
            ['id' => 5, 'name' => 'Anoniem', 'message' => 'Ik had gerust wel meer kunnen eten.', 'is_approved' => 1, 'date' => '2021-10-05', 'is_new' => 0],
            ['id' => 6, 'name' => 'Nieuw', 'message' => 'Is new status uitproberen', 'is_approved' => 0, 'date' => '2021-10-05', 'is_new' => 1],
        ]);
    }
}
