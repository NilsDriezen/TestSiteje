<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CookieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('cookies')->insert([
            ['id' => 1, 'name' => 'Amandelkoekjes', 'description' => 'Geniet van de rijke smaak van deze boterkoekjes met amandelen. Elke hap biedt een heerlijke mix van boterigheid en knapperige amandelstukjes. Verpakt in handige zakjes van 250 gram.', 'picture_path' => 'cookie_1.jpg', 'price' => '6', 'stock' => 4, 'active' => true, 'dish_id' => 15],
            ['id' => 2, 'name' => 'Gemberkoekjes', 'description' => 'Laat je smaakpapillen verrassen door deze zandkoekjes met een vleugje geconfijte gember. De subtiele scherpte van gember vermengt zich perfect met de zoete kruimels van de koekjes. Verpakt per 250 gram.', 'picture_path' => 'cookie_2.jpg', 'price' => '6', 'stock' => 4, 'active' => true, 'dish_id' => 17],
            ['id' => 3, 'name' => 'Geelse handjes', 'description' => 'Ontdek een lokale favoriet met deze Geelse handjes. Deze zandkoekjes zijn liefdevol gevormd in handjes en bedekt met een decadente laag chocolade. Perfect om te delen of gewoon voor jezelf te houden. Verpakt in handige 250 gram zakken.', 'picture_path' => 'cookie_3.jpg', 'price' => '6', 'stock' => 1, 'active' => true, 'dish_id' => 16],
            ['id' => 4, 'name' => 'Bokkepoten', 'description' => 'Proef de traditie met onze bokkepoten. Deze heerlijke koekjes zijn gemaakt volgens een eeuwenoud recept en hebben een knapperige textuur die smelt in je mond. Verpakt in porties van 250 gram.', 'picture_path' => 'cookie_4.jpg', 'price' => '6', 'stock' => 0, 'active' => true, 'dish_id' => 1],
        ]);

    }
}
