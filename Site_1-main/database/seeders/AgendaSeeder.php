<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class AgendaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('agendas')->insert([
            ['id' => 1,
            'date_exception' => null,
            'day_of_week' => 'Monday',
            'time_start' => '16:00:00',
            'time_end' => '17:00:00',
            'closed' => false,
                'type' => 'koekjes'
            ],
            ['id' => 2,
            'date_exception' => null,
            'day_of_week' => 'Tuesday',
            'time_start' => '16:00:00',
            'time_end' => '17:00:00',
            'closed' => false,
                'type' => 'koekjes'
            ],
            ['id' => 3,
            'date_exception' => null,
            'day_of_week' => 'Wednesday',
            'time_start' => '12:00:00',
            'time_end' => '14:00:00',
            'closed' => false,
                'type' => 'reservaties'
            ],
            ['id' => 4,
            'date_exception' => null,
            'day_of_week' => 'Friday',
            'time_start' => '18:00:00',
            'time_end' => '20:00:00',
            'closed' => false,
                'type' => 'reservaties'

            ],
            ['id' => 5,
            'date_exception' => null,
            'day_of_week' => 'Friday',
            'time_start' => '20:00:00',
            'time_end' => '22:00:00',
            'closed' => false,
                'type' => 'reservaties'
            ],
            ['id' => 6,
            'date_exception' => null,
            'day_of_week' => 'Saturday',
            'time_start' => '18:00:00',
            'time_end' => '20:00:00',
            'closed' => false,
                'type' => 'reservaties'
            ],
            ['id' => 7,
                'date_exception' => null,
                'day_of_week' => 'Saturday',
                'time_start' => '20:00:00',
                'time_end' => '22:00:00',
                'closed' => false,
                'type' => 'reservaties'
            ],
            ['id' => 8,
                'date_exception' => '2024-06-06',
                'day_of_week' => null,
                'time_start' => '20:00:00',
                'time_end' => '22:00:00',
                'closed' => false,
                'type' => 'reservaties'
                ],
            ['id' => 9,
                'date_exception' => null,
                'day_of_week' => 'Friday',
                'time_start' => '09:00',
                'time_end' => '10:00',
                'closed' => false,
                'type' => 'koekjes'
            ],
            ['id' => 10,
                'date_exception' => null,
                'day_of_week' => 'Monday',
                'time_start' => '10:00:00',
                'time_end' => '11:00:00',
                'closed' => false,
                'type' => 'koekjes'
            ],
        ]);
    }
}
