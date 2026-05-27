<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TemplateWebpageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('template_webpages')->insert([
            [
                'id' => 1,
                'type' => 'home',
                'content' => "Stap binnen in mijn betoverende huiskamerrestaurant, waar huiselijke warmte samensmelt met gastronomische verfijning.\n \nGelegen in de omhelzing van mijn eigen huis, verwelkomt mijn woonkamer gasten voor een intieme culinaire ervaring. Het moment dat je binnenkomt, omhult een onmiskenbare charme je zintuigen. Zachte verlichting en zachte muziek creëren een sfeer van rust, terwijl de geuren van vers bereide gerechten je tegemoet komen. Elke maaltijd die ik serveer, is doordrenkt met mijn passie voor koken en mijn toewijding aan het gebruik van de beste ingrediënten.\n \nElk gerecht is een symfonie van smaken, bereid met liefdevolle aandacht voor detail. Maar mijn huiskamerrestaurant is meer dan alleen eten; het is een reis naar verbinding, een kans om te genieten van de eenvoudige geneugten van het leven. Als gastheer/gastvrouw sta ik klaar om elke gast te verwelkomen met een glimlach en om hen te begeleiden op een culinaire ontdekkingsreis.\n\nDus, of je nu op zoek bent naar een intiem diner, een feestelijke bijeenkomst of gewoon een moment van rust en verwennerij, mijn huiskamerrestaurant verwelkomt je met open armen. Laat je onderdompelen in de magie van huiselijkheid en gastronomisch genot, en laat je meevoeren op een reis die al je zintuigen zal betoveren.",
                'picture_1' => 'websitepictures/Home1.png',
                'picture_2' => 'websitepictures/Home2.png'
            ],

            [
                'id' => 2,
                'type' => 'contact',
                'content' => "Vergeet niet onze koekjespagina te bezoeken!",
                'picture_1' => null,
                'picture_2' => null],

            ['id' => 3, 'type' => 'reservation', 'content' => 'Hier kan u een reservatie maken. Indien dit niet lukt, aarzel niet om ons telefonisch te contacteren.', 'picture_1' => null, 'picture_2' => null],
            ['id' => 4, 'type' => 'cookie', 'content' => 'Geniet van de verrukkelijke smaak van huisgemaakte koekjes, ambachtelijk met liefde en zorg bereid. Onze heerlijke creaties zijn exclusief beschikbaar voor afhaling, waardoor je de authentieke ervaring van versgebakken lekkernijen kunt beleven. Bestel vandaag nog en haal je verrukkelijke traktaties op om thuis te genieten!', 'picture_1' => null, 'picture_2' => null],
            ['id' => 5, 'type' => 'menu', 'content' => 'Bij ons huiskamerrestaurant bieden we een maandelijks wisselend menu aan, samengesteld met zorg en aandacht voor seizoensgebonden ingrediënten en culinaire creativiteit. Onze menu\'s, bestaande uit 3 tot 4 gangen, beloven een smaakvolle reis door diverse smaken en texturen. Wat ons uniek maakt, is dat we voor elk menu zowel een vlees- als vegetarische optie aanbieden, zodat al onze gasten kunnen genieten van een passende culinaire ervaring, ongeacht hun dieetvoorkeuren. Elke maand streven we ernaar om onze gasten te verrassen met nieuwe gerechten, geïnspireerd door de smaken van het seizoen en onze eigen creatieve impulsen. Of je nu komt voor een intiem diner voor twee, een feestelijke gelegenheid met vrienden of familie, of gewoon een moment van culinaire verwennerij voor jezelf, ons maandelijkse menu belooft een onvergetelijke ervaring voor alle zintuigen.', 'picture_1' => null, 'picture_2' => null],
        ]);
    }
}
