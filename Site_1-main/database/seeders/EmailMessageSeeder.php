<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmailMessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('email_messages')->insert([
            ['id' => 1, 'type' => 'order_confirmation', 'email_subject' => 'Bevestiging van uw koekjesbestelling', 'email_content_admin' => 'Kom ook eens langs in ons restaurant en geniet van onze gerechten!',  'email_signature' => 'Met vriendelijke groeten, het koekjes team'],
            ['id' => 2, 'type' => 'contact_confirmation','email_subject' => 'Huiskamer - Contactformulier', 'email_content_admin' => 'Het is wat drukker dan normaal, het kan even duren vooraleer u een antwoord ontvangt',  'email_signature' => 'Met vriendelijke groeten, het koekjes team'  ],
         ]);
    }
}
