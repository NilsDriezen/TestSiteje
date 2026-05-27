<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CocktailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('cocktails')->insert([
            ['id' => 1,
            'name' => 'Mojito',
            'photo' => '/storage/cocktailphotos/mojito.jpg',
            'description' => 'De Mojito is een frisse, Cubaanse cocktail met rum, limoen en munt. Hemelse combinatie van zoet en zuur.',
            'price' => 7.50,
            'year' => Carbon::createFromDate(2021, null, null),
            'month' => Carbon::createFromDate(null, 7, null),
            ],
            [
                'id' => 2,
                'name'=>'Sex on the Beach',
                'photo' =>'/storage/cocktailphotos/sex_on_the_beach.jpg',
                'description' => 'De Sex on the Beach is het ultieme vakantiegevoel in een cocktailglas. Heerlijk op een zwoele zomeravond.',
                'price' => 7.50,
                'year' => Carbon::createFromDate(2021, null, null),
                'month' => Carbon::createFromDate(null, 7, null),
            ],
            [
                'id' => 3,
                'name' => 'Pina Colada',
                'photo' => '/storage/cocktailphotos/pina_colada.jpg',
                'description' => 'De Pina Colada is een tropische cocktail gemaakt met rum, ananassap en kokosmelk. Een romige zoetigheid.',
                'price' => 7.50,
                'year' =>  Carbon::createFromDate(2006, null, null),
                'month' => Carbon::createFromDate(null, 8, null),
            ],
            [
                'id' => 4,
                'name' => 'Pornstar Martini',
                'photo' => '/storage/cocktailphotos/pornstar_martini.jpg',
                'description' => 'De Pornstar Martini of Martini Pornstar is de Pornstar onder de cocktails. Het is een sexy martini cocktail met passievrucht en vanille vodka. Smaakt zacht als zijde.',
                'price' => 7.50,
                'year' => Carbon::createFromDate(1997, null, null),
                'month' => Carbon::createFromDate(null, 2, null),
            ],
            [
                'id' => 5,
                'name' => 'Moscow Mule',
                'photo' => '/storage/cocktailphotos/moscow_mule.jpg',
                'description' => 'De Moscow Mule is een frisse en kruidige cocktail met vodka, gemberbier, limoen en munt. Lekker pittig!',
                'price' => 7.50,
                'year' => Carbon::createFromDate(2022, null, null),
                'month' => Carbon::createFromDate(null, 11, null)
            ],
            [
                'id' => 6,
                'name' => 'Dark \'n Stormy',
                'photo' => '/storage/cocktailphotos/dark_n_stormy.jpg',
                'description' => 'De Dark ’n Stormy is een stoere, kruidige cocktail met donkere rum en ginger beer. Een storm van smaak!',
                'price' => 7.50,
                'year' => Carbon::createFromDate(2021, null, null),
                'month' => Carbon::createFromDate(null, 1, null)
            ],
            [
                'id' => 7,
                'name' => 'Margarita',
                'photo' => '/storage/cocktailphotos/margarita.jpg',
                'description' => 'De Margarita wordt gemaakt met tequila en limoen. Met een zoutrandje aan het glas is dit een echte klassieker.',
                'price' => 7.50,
                'year' => Carbon::createFromDate(2024, null, null),
                'month' => Carbon::createFromDate(null, 9, null),
            ],
        ]);
    }
}
