<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DishSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('dishes')->insert([
            [
                'id' => 1,
                'name' => 'Geen recept beschikbaar',
                'instruction' => 'Te gebruiken als placeholder voor gerechten zonder recept.',
                'preparation_time' => 1,
                'serving' => 1,
                'recipe_tag' => 'Geen recept',
                'comment' => 'Te gebruiken als placeholder voor gerechten zonder recept.',
                'calorie' => 10,
                'active' => true,
                'course_id' => 7,
                'path' => '/storage/dishpictures/no-photo.png',
                'cooking_time' => 1,
            ],
            [
                'id' => 2,
                'name' => 'Tomatensoep met balletjes',
                'instruction' => 'Bereid de gehaktballetjes voor:

Meng het gehakt met paneermeel, ei, gehakte peterselie (optioneel), zout en peper. Rol kleine balletjes van het gehaktmengsel.
Bak de gehaktballetjes:

Verhit wat olijfolie in een grote pan op middelhoog vuur. Bak de gehaktballetjes tot ze bruin zijn aan de buitenkant. Haal ze uit de pan en zet opzij.
Bereid de soep:

Voeg een beetje meer olijfolie toe aan dezelfde pan. Fruit de ui, knoflook, wortelen en bleekselderij tot ze zacht zijn.
Voeg tomaten en kruiden toe:

Voeg de tomatenblokjes toe aan de groenten in de pan. Roer goed door. Voeg dan de gedroogde oregano en basilicum toe. Breng op smaak met zout en peper.
Kook de soep:

Giet de groentebouillon in de pan en breng aan de kook. Zet het vuur laag en laat de soep sudderen voor ongeveer 15-20 minuten, zodat de groenten zacht worden en de smaken goed mengen.
Voeg de gehaktballetjes toe:

Voeg de gebakken gehaktballetjes toe aan de soep en laat nog 5-10 minuten sudderen, of tot de gehaktballetjes gaar zijn.
',
                'preparation_time' => 10,
                'serving' => 4,
                'recipe_tag' => 'Voorgerecht',
                'comment' => 'Eventueel wat room toevoegen voor een romige tomatensoep.',
                'calorie' => 200,
                'active' => true,
                'course_id' => 1,
                'path' => '/storage/dishpictures/tomatensoep-balletjes.jpeg',
                'cooking_time' => 20,
            ],
            [
                'id' => 3,
                'name' => 'Tomate crévette',
                'instruction' => 'Bereid de tomaten voor:

Snijd het bovenste gedeelte van elke tomaat af en bewaar het als deksel. Hol voorzichtig de binnenkant van de tomaten uit met een lepel, zodat je een holle tomaat overhoudt om te vullen.
Maak de vulling:

Hak de gepelde garnalen fijn. Meng ze in een kom met mayonaise, citroensap, fijngehakte peterselie, zout en peper naar smaak. De vulling moet smeuïg en goed op smaak zijn.
Vul de tomaten:

Vul elke uitgeholde tomaat royaal met het garnalenmengsel. Druk de vulling lichtjes aan en plaats het bovenste deksel van de tomaat er weer op.',
                'preparation_time' => 15,
                'serving' => 4,
                'recipe_tag' => 'Tussengerecht',
                'comment' => 'Extra kruiden of specerijen toevoegen naar smaak.',
                'calorie' => 385,
                'active' => true,
                'course_id' => 2,
                'path' => '/storage/dishpictures/tomate-crevette.jpeg',
                'cooking_time' => 0,
            ],
            [
                'id' => 4,
                'name' => 'Vol-au-vent met luchtig gebakje en krielaardappeltjes',
                'instruction' => 'Bereid de kippenragout:

Verhit de boter in een grote pan op middelhoog vuur. Voeg de fijngehakte ui toe en bak tot deze zacht en glazig is.
Voeg de kip toe:

Voeg de blokjes kipfilet toe aan de pan. Bak ze tot ze goudbruin zijn aan de buitenkant.
Maak de roux:

Strooi de bloem over de kip en ui in de pan. Roer goed door totdat de bloem de boter absorbeert en een roux vormt.
Voeg vloeistoffen toe:

Voeg geleidelijk de kippenbouillon toe, terwijl je blijft roeren om een gladde saus te vormen. Laat het sudderen tot de saus begint te verdikken.
Voeg room toe:

Giet de room (of melk) in de pan en blijf roeren. Laat de saus sudderen tot hij de gewenste dikte heeft. Breng op smaak met zout, peper en een scheutje citroensap indien gewenst.',
                'preparation_time' => 25,
                'serving' => 4,
                'recipe_tag' => 'Hoofdgerecht',
                'comment' => 'Bladerdeeggebakjes kort opwarmen in de oven voor een extra krokante textuur.',
                'calorie' => 776,
                'active' => true,
                'course_id' => 3,
                'path' => '/storage/dishpictures/vol-au-vent.jpeg',
                'cooking_time' => 45,
            ],
            [
                'id' => 5,
                'name' => 'Vlaamse tiramisu met speculaas',
                'instruction' => 'Klop de mascarpone crème:

Klop de mascarpone samen met de poedersuiker en vanille-extract in een grote kom tot een glad mengsel.
Klop de slagroom:

Klop de slagroom stijf in een andere kom.
Meng de mascarpone en slagroom:

Spatel voorzichtig de opgeklopte slagroom door het mascarpone mengsel tot alles goed gemengd is. Zorg ervoor dat je luchtig blijft mengen voor een lichte textuur.
Doop de speculoos koekjes:

Doop de speculoos koekjes kort in de afgekoelde koffie (eventueel gemengd met een scheutje likeur) en leg ze in een ovenschaal of glazen schaal in een enkele laag.
Laagjes maken:

Verspreid een laag van het mascarpone mengsel over de koekjes.
Strooi een deel van de geraspte of gehakte chocolade over de mascarpone laag.
Herhaal dit proces door nog een laag koekjes, mascarpone mengsel en chocolade toe te voegen totdat al je ingrediënten op zijn. Eindig met een laagje mascarpone.',
                'preparation_time' => 20,
                'serving' => 4,
                'recipe_tag' => 'Dessert',
                'comment' => 'Voor het opdienen, bestuif de bovenkant van de tiramisu met een dun laagje cacaopoeder.',
                'calorie' => 520,
                'active' => true,
                'course_id' => 4,
                'path' => '/storage/dishpictures/vlaamse-tiramisu.jpeg',
                'cooking_time' => 0,
            ],
            [
                'id' => 6,
                'name' => 'Kruidige bloemkoolsoep',
                'instruction' => 'Klop de mascarpone crème:

Klop de mascarpone samen met de poedersuiker en vanille-extract in een grote kom tot een glad mengsel.
Klop de slagroom:

Klop de slagroom stijf in een andere kom.
Meng de mascarpone en slagroom:

Spatel voorzichtig de opgeklopte slagroom door het mascarpone mengsel tot alles goed gemengd is. Zorg ervoor dat je luchtig blijft mengen voor een lichte textuur.
Doop de speculoos koekjes:

Doop de speculoos koekjes kort in de afgekoelde koffie (eventueel gemengd met een scheutje likeur) en leg ze in een ovenschaal of glazen schaal in een enkele laag.
Laagjes maken:

Verspreid een laag van het mascarpone mengsel over de koekjes.
Strooi een deel van de geraspte of gehakte chocolade over de mascarpone laag.
Herhaal dit proces door nog een laag koekjes, mascarpone mengsel en chocolade toe te voegen totdat al je ingrediënten op zijn. Eindig met een laagje mascarpone.
',
                'preparation_time' => 10,
                'serving' => 4,
                'recipe_tag' => 'Voorgerecht',
                'comment' => 'Verdeel de bloemkoolsoep over kommen. Garneer met wat verse fijngehakte peterselie en geroosterde amandelen of hazelnoten voor extra textuur en smaak.',
                'calorie' => 215,
                'active' => true,
                'course_id' => 1,
                'path' => '/storage/dishpictures/bloemkoolsoep.jpeg',
                'cooking_time' => 30,
            ],
            [
                'id' => 7,
                'name' => 'Vleeskroketje met fris slaatje',
                'instruction' => 'Bereid de vleesvulling:

Smelt de boter in een pan op middelhoog vuur. Voeg de fijngehakte ui en knoflook toe en bak tot ze zacht en lichtbruin zijn.
Voeg het fijngehakte gekookte stoofvlees toe aan de pan en bak het kort mee met de ui en knoflook.
Strooi de bloem over het vlees en de groenten in de pan. Roer goed door tot de bloem de boter absorbeert en een roux vormt.
Voeg geleidelijk de runderbouillon toe, terwijl je blijft roeren om een dikke vleesvulling te maken. Laat het sudderen tot het mengsel dikker wordt.
Breng op smaak met nootmuskaat, zout, peper en eventueel wat verse peterselie en een scheutje citroensap. Laat de vleesvulling afkoelen.
Vorm de kroketten:

Neem een eetlepel van de afgekoelde vleesvulling en vorm er langwerpige kroketten van.
Paneer de kroketten:

Rol elke kroket eerst door bloem, dan door losgeklopt ei, en tot slot door paneermeel. Zorg ervoor dat de kroketten volledig bedekt zijn met paneermeel.
Frituren:

Verhit de plantaardige olie in een diepe pan tot 180°C.
Frituur de vleeskroketten in batches gedurende 4-5 minuten, of tot ze goudbruin en knapperig zijn.
Laat de gefrituurde kroketten uitlekken op keukenpapier om overtollig vet te verwijderen.',
                'preparation_time' => 15,
                'serving' => 4,
                'recipe_tag' => 'Tussengerecht',
                'comment' => 'Serveer de vleeskroketten warm als snack of als onderdeel van een maaltijd. Ze zijn heerlijk met mosterd, mayonaise of een frisse salade.',
                'calorie' => 280,
                'active' => true,
                'course_id' => 2,
                'path' => '/storage/dishpictures/vleeskroket.jpeg',
                'cooking_time' => 15,
            ],
            [
                'id' => 8,
                'name' => 'Quiche Lorraine met versgebakke piccollo',
                'instruction' => 'Verwarm de oven voor:
Verwarm de oven voor op 180°C.

Bak de spekreepjes:
Bak de spekreepjes in een droge koekenpan tot ze knapperig zijn. Laat uitlekken op keukenpapier om overtollig vet te verwijderen.

Bereid de vulling:
Klop in een kom de eieren los met de slagroom. Breng op smaak met zout, peper en een snufje nootmuskaat.

Assembleer de quiche:
Verdeel de gebakken spekreepjes en geraspte kaas gelijkmatig over de taartbodem.

Giet het eimengsel:
Giet het eimengsel over de spek en kaas in de taartbodem.

Bak de quiche:
Bak de Quiche Lorraine in de voorverwarmde oven gedurende 30-35 minuten, of tot de bovenkant goudbruin is en de vulling stevig is.',
                'preparation_time' => 15,
                'serving' => 4,
                'recipe_tag' => 'Hoofdgerecht',
                'comment' => 'Laat de quiche een paar minuten afkoelen voordat je hem aansnijdt.',
                'calorie' => 635,
                'active' => true,
                'course_id' => 3,
                'path' => '/storage/dishpictures/quiche-lorraine.jpeg',
                'cooking_time' => 35,
            ],
            [
                'id' => 9,
                'name' => 'Frambozencheesecake',
                'instruction' => 'Voorbereiding:

Verwarm de oven voor op 160°C (heteluchtoven) of 180°C (standaard oven). Vet een ronde springvorm (ca. 23 cm) in met boter en bekleed de bodem met bakpapier.
Maak de koekjeskorst:

Verkruimel de koekjes in een keukenmachine of doe ze in een plastic zak en sla ze fijn met een deegroller. Meng de kruimels met gesmolten boter tot alles goed gemengd is.
Druk het koekjesmengsel stevig op de bodem van de springvorm. Zet de vorm in de koelkast terwijl je de vulling bereidt.
Maak de cheesecakevulling:

In een grote kom, klop de roomkaas en suiker samen tot een glad mengsel.
Voeg de zure room, eieren en vanille-extract toe. Mix tot alles goed gecombineerd is en het mengsel glad is.
Giet het cheesecakemengsel voorzichtig over de koekjeskorst in de springvorm.
Voeg de frambozen toe:

Verdeel de verse frambozen gelijkmatig over het cheesecakemengsel.
Bak de cheesecake:

Bak de cheesecake in de voorverwarmde oven gedurende 50-60 minuten, of tot de randen stevig zijn en het midden nog een beetje wiebelig is.
Haal de cheesecake uit de oven en laat volledig afkoelen op kamertemperatuur. Zet daarna minstens 4 uur (of liever een nacht) in de koelkast om op te stijven.
Maak de frambozensaus:

Doe de frambozen, suiker en water in een steelpan. Verhit op middelhoog vuur en laat sudderen tot de frambozen zacht zijn en de saus iets is ingedikt.
Haal van het vuur en pureer de saus met een staafmixer. Voeg naar smaak een beetje citroensap toe voor een frisse smaak.
',
                'preparation_time' => 10,
                'serving' => 4,
                'recipe_tag' => 'Dessert',
                'comment' => 'Garneer met extra verse frambozen.',
                'calorie' => 530,
                'active' => true,
                'course_id' => 4,
                'path' => '/storage/dishpictures/frambozencheesecake.jpeg',
                'cooking_time' => 10,
            ],
            [
                'id' => 10,
                'name' => 'Aspergeroomsoep met meergranenpistolet',
                'instruction' => "Schil en snijd de asperges:

Schil de asperges grondig en snijd de harde uiteinden eraf. Snijd de asperges vervolgens in stukjes van ongeveer 2-3 cm lang.
Fruit de ui en knoflook:

Verhit de boter in een grote pan op middelhoog vuur. Voeg de fijngehakte ui en knoflook toe en bak ze glazig.
Voeg de asperges toe:

Voeg de stukjes asperges toe aan de pan en bak ze kort mee met de ui en knoflook, ongeveer 5 minuten.
Bouillon toevoegen:

Giet de groentebouillon in de pan en breng aan de kook. Laat het geheel sudderen tot de asperges gaar zijn, dit duurt meestal zo'n 15-20 minuten.
Pureer de soep:

Gebruik een staafmixer of blender om de soep glad te pureren tot een romige consistentie.
Room toevoegen:

Voeg de room toe aan de gepureerde soep en roer goed door. Laat de soep nog een paar minuten sudderen op laag vuur.
Breng op smaak:

Breng de aspergeroomsoep op smaak met zout en peper naar smaak. Proef en voeg indien nodig meer kruiden toe.

    ",
                'preparation_time' => 15,
                'serving' => 4,
                'recipe_tag' => 'Voorgerecht',
                'comment' => 'Garneer eventueel met verse fijngehakte peterselie.',
                'calorie' => 245,
                'active' => true,
                'course_id' => 1,
                'path' => '/storage/dishpictures/aspergesoep.jpeg',
                'cooking_time' => 30,
            ],
            [
                'id' => 11,
                'name' => 'Asperges à la flamande',
                'instruction' => 'Bereid de asperges:

Schil de witte asperges grondig en snijd de harde uiteinden af. Spoel de asperges goed af onder koud water.
Kook de eieren:

Breng een pan water aan de kook en voeg de eieren toe. Kook de eieren in ongeveer 8-10 minuten hard. Laat ze daarna schrikken onder koud water en pel ze. Snijd de eieren in plakjes.
Stoom de asperges:

Leg de geschilde asperges in een stoommandje boven een pan met kokend water. Stoom de asperges gaar in ongeveer 10-15 minuten, afhankelijk van de dikte van de asperges. Prik er met een vork in om te controleren of ze zacht zijn.
Smelt de boter:

Smelt ondertussen de boter in een kleine pan op laag vuur tot het gesmolten is. Voeg eventueel een snufje zout toe aan de gesmolten boter.
Serveer de asperges:

Leg de gestoomde asperges op een serveerschaal. Besprenkel royaal met de gesmolten boter.
Garneer met ei en peterselie:

Leg de plakjes hardgekookt ei bovenop de asperges. Bestrooi vervolgens met verse fijngehakte peterselie.
',
                'preparation_time' => 20,
                'serving' => 4,
                'recipe_tag' => 'Tussengerecht',
                'comment' => 'Voor extra smaak kun je plakjes ham of gerookte zalm bovenop de asperges leggen voordat je de eieren en peterselie toevoegt.',
                'calorie' => 180,
                'active' => true,
                'course_id' => 2,
                'path' => '/storage/dishpictures/asperges-flamande.jpeg',
                'cooking_time' => 20,
            ],
            [
                'id' => 12,
                'name' => 'Gekarameliseerde witloof met kaassaus en potato wedges',
                'instruction' => 'Verwijder de buitenste bladeren van het witloof en snijd de harde kern aan de onderkant van elke stronk weg. Snijd de witloofstronken in de lengte doormidden.
Karameliseren van het witloof:

Smelt de boter in een grote koekenpan op middelhoog vuur. Voeg de kristalsuiker toe en laat het smelten in de boter.
Leg de witloofhelften met de platte kant naar beneden in de pan. Bak ze ongeveer 5 minuten aan elke kant, of tot ze goudbruin beginnen te worden en de suiker is gekarameliseerd.
Breng op smaak met zout en peper.
Bereiden van de kaassaus:

Verwarm de melk in een kleine pan op laag vuur. Zorg ervoor dat de melk niet kookt.
Smelt in een andere pan 2 eetlepels boter op middelhoog vuur. Voeg de bloem toe en roer goed door tot je een gladde roux hebt.
Voeg geleidelijk de warme melk toe aan de roux, terwijl je voortdurend blijft roeren om klontjes te voorkomen. Blijf roeren tot de saus dikker wordt.
Voeg de gemalen kaas toe aan de saus en blijf roeren tot de kaas volledig gesmolten en opgenomen is.
Breng de kaassaus op smaak met zout, peper en een snufje nootmuskaat.
Serveren:

Leg de gekarameliseerde witloofhelften op een serveerschaal. Schep de warme kaassaus over het witloof.
Als je wilt, strooi wat extra gemalen kaas over de bovenkant van het witloof en zet het kort onder de grill tot de kaas gesmolten en goudbruin is.
',
                'preparation_time' => 15,
                'serving' => 4,
                'recipe_tag' => 'Hoofdgerecht',
                'comment' => 'Het is heerlijk met aardappelpuree of stokbrood.',
                'calorie' => 865,
                'active' => true,
                'course_id' => 3,
                'path' => '/storage/dishpictures/witloof-karamel.jpeg',
                'cooking_time' => 35,
            ],
            [
                'id' => 13,
                'name' => 'Moelleux au chocolat',
                'instruction' => 'Voorbereiden:

Verwarm de oven voor op 200°C (heteluchtoven) of 220°C (standaard oven). Vet 4 kleine bakvormpjes of muffinvormpjes in met boter en bestuif ze met bloem.
Smelten van chocolade en boter:

Breek de chocolade in stukjes en smelt deze samen met de boter au bain-marie of voorzichtig in de magnetron. Roer regelmatig tot het mengsel glad en volledig gesmolten is. Laat iets afkoelen.
Bereiden van het beslag:

Klop in een kom de eieren samen met de fijne kristalsuiker tot een luchtig mengsel.
Voeg het afgekoelde chocolade-botermengsel toe aan het ei-suikermengsel en roer goed door.
Zeef de bloem en het snufje zout boven het chocolademengsel en spatel voorzichtig door tot alles goed gemengd is.
Vullen van de vormpjes:

Verdeel het beslag gelijkmatig over de ingevette bakvormpjes.
Bakken:

Plaats de bakvormpjes in de voorverwarmde oven en bak de moelleux au chocolat gedurende 10-12 minuten. De randen moeten stevig zijn, maar het midden moet nog zacht aanvoelen als je er lichtjes op drukt.
',
                'preparation_time' => 15,
                'serving' => 4,
                'recipe_tag' => 'Dessert',
                'comment' => 'Haal de moelleux au chocolat voorzichtig uit de oven en laat ze 1-2 minuten rusten.',
                'calorie' => 650,
                'active' => true,
                'course_id' => 4,
                'path' => '/storage/dishpictures/moelleux.jpeg',
                'cooking_time' => 30,
            ],
            [
                'id' => 14,
                'name' => 'Gazpacho',
                'instruction' => "Voorbereiden van de groenten:

Snijd alle groenten (tomaten, komkommer, paprika's, ui) in grove stukken.
Blenderen van de groenten:

Doe alle gesneden groenten en knoflook in een blender of keukenmachine.
Toevoegen van olie en azijn:

Voeg de extra vierge olijfolie en rode wijnazijn toe aan de blender.
Blenderen tot een gladde massa:

Blend alles tot een gladde puree. Voeg indien nodig wat tomatensap toe om het mixen te vergemakkelijken.
Op smaak brengen:

Breng de gazpacho op smaak met zout, peper en eventueel een snufje cayennepeper voor wat extra pit.
Toevoegen van tomatensap:

Giet het tomatensap bij de gemixte groenten en roer goed door.
Koelen:

Zet de gazpacho minstens 2 uur (of langer) in de koelkast om goed koud te worden en de smaken te laten mengen.
    ",
                'preparation_time' => 20,
                'serving' => 4,
                'recipe_tag' => 'Voorgerecht',
                'comment' => 'Roer de gazpacho nog even door voor het serveren. Schenk de gazpacho in kommen of glazen.
Garneer met wat verse basilicum of peterselie.',
                'calorie' => 170,
                'active' => true,
                'course_id' => 1,
                'path' => '/storage/dishpictures/gazpacho.jpeg',
                'cooking_time' => 20,
            ],
            [
                'id'=>15,
                'name'=>'Amandelkoekjes',
                'instruction'=>'Mix de amandelen,suiker en boter en vorm er koekjes van.Bak ze in de oven tot ze goud bruin zijn.',
                'preparation_time'=>10,
                'serving'=>4,
                'recipe_tag'=>'Koekje',
                'comment'=>'Een heerlijk knapperige traktatie met een vleugje amandel.',
                'calorie'=>200,
                'active'=>true,
                'course_id'=>6,
                'path'=>'/storage/cookiepictures/cookie_1.jpg',
                'cooking_time'=>20,
            ],
            [
                'id'=>16,
                'name'=>'Geelsehandjes',
                'instruction'=>'Vorm de koekjes in de vorm van een handje en bak ze in de oven tot ze lichtbruin zijn.',
                'preparation_time'=>10,
                'serving'=>4,
                'recipe_tag'=>'Koekje',
                'comment'=>'Een traditioneel Belgisch koekje,perfect voor bij de koffie.',
                'calorie'=>200,
                'active'=>true,
                'course_id'=>6,
                'path'=>'/storage/cookiepictures/cookie_3.jpg',
                'cooking_time'=>20,
            ],
            [
                'id'=>17,
                'name'=>'Gemberkoekjes',
                'instruction'=>'Mengbloem,boter,suiker en gehakte gember tot een deeg.Vorm koekjes en bak ze in de oven.',
                'preparation_time'=>10,
                'serving'=>4,
                'recipe_tag'=>'Koekje',
                'comment'=>'Een pittig en zoet koekje met een verrukkelijke gembersmaak.',
                'calorie'=>200,
                'active'=>true,
                'course_id'=>6,
                'path'=>'/storage/cookiepictures/cookie_2.jpg',
                'cooking_time'=>20,
            ],
            [
                'id' => 18,
                'name' => 'Salade geitenkaas met Franse baguette',
                'instruction' => 'Bereid de groenten voor: Was en snijd de gemengde sla, cherrytomaten, komkommer en rode ui zoals aangegeven.

Rooster de walnoten: Verwarm een droge koekenpan op middelhoog vuur. Voeg de walnoten toe en rooster ze lichtjes tot ze beginnen te geuren. Haal van het vuur en laat afkoelen.

Maak de dressing: Meng in een kleine kom 3 eetlepels olijfolie met 1 eetlepel balsamico azijn. Voeg zout en peper toe naar smaak en roer goed door.

Combineer de salade: Doe de gemengde sla, cherrytomaten, komkommer, rode ui en walnoten in een grote kom. Voeg de verkruimelde geitenkaas toe.

Dressing toevoegen: Giet de dressing over de salade en hussel voorzichtig om alles gelijkmatig te verdelen.
',
                'preparation_time' => 20,
                'serving' => 4,
                'recipe_tag' => 'Tussengerecht',
                'comment' => 'Je kunt eventueel nog extra ingrediënten toevoegen zoals gedroogde vruchten (bijvoorbeeld cranberries of rozijnen) voor een zoete touch.',
                'calorie' => 215,
                'active' => true,
                'course_id' => 2,
                'path' => '/storage/dishpictures/salade-geitenkaas.jpeg',
                'cooking_time' => 0,
            ],
            [
                'id' => 19,
                'name' => 'Gegrilde aubergines met zoete aardappelfrietjes',
                'instruction' => 'Voorbereiding:
Verwarm de oven voor op 200°C.
Schil de zoete aardappelen en snijd ze in frietjes van gelijke grootte.
Snijd de aubergines in plakken van ongeveer 1 cm dik.
Zoete aardappelfrietjes:
Leg de zoete aardappelfrietjes op een bakplaat bekleed met bakpapier.
Besprenkel de frietjes met olijfolie en breng op smaak met zout, peper, knoflookpoeder en paprikapoeder (naar smaak).
Hussel de frietjes goed door elkaar zodat ze gelijkmatig bedekt zijn met de olie en kruiden.
Bak de zoete aardappelfrietjes in de voorverwarmde oven gedurende 25-30 minuten, of tot ze goudbruin en knapperig zijn, waarbij je ze halverwege omdraait voor gelijkmatige gaarheid.
Gegrilde aubergines:
Verhit een grillpan of barbecue op middelhoog vuur.
Bestrijk beide kanten van de plakken aubergine lichtjes met olijfolie en bestrooi met zout en peper.
Leg de plakken aubergine op de grillpan en gril ze gedurende 3-4 minuten aan elke kant, of tot ze mooie grillstrepen hebben en zacht zijn.
Als je verse kruiden gebruikt, strooi deze dan over de gegrilde aubergines zodra ze van de grill komen.',
                'preparation_time' => 20,
                'serving' => 4,
                'recipe_tag' => 'Hoofdgerecht',
                'comment' => 'Schik de gegrilde aubergines op een serveerschaal.
Leg de knapperige zoete aardappelfrietjes naast de aubergines.',
                'calorie' => 746,
                'active' => true,
                'course_id' => 3,
                'path' => '/storage/dishpictures/gegrilde-aubergines.jpeg',
                'cooking_time' => 40,
            ],
            [
                'id' => 20,
                'name' => 'Fruitcocktail',
                'instruction' => 'Bereid het fruit voor: Was al het fruit grondig. Snijd het fruit dat moet worden gesneden (zoals aardbeien, kiwi, perzik, ananas) in gelijke stukjes.

Meng het fruit: Doe al het gesneden fruit in een grote kom.

Voeg sinaasappelsap toe: Giet vers geperst sinaasappelsap over het fruit. Begin met ongeveer 1/4 kopje sinaasappelsap en voeg meer toe naar smaak. Het sap voegt zoetheid en een heerlijke citrusaroma toe.

Optioneel: voeg honing toe: Als je van een iets zoetere fruitcocktail houdt, kun je een beetje honing toevoegen aan het fruit en sinaasappelsap. Roer goed door zodat de honing gelijkmatig verdeeld wordt.

Koelen: Zet de fruitcocktail minstens 30 minuten in de koelkast om de smaken te laten mengen en de cocktail goed te koelen.
',
                'preparation_time' => 20,
                'serving' => 4,
                'recipe_tag' => 'Dessert',
                'comment' => 'Verdeel de fruitcocktail over glazen of serveerkommen. Garneer met verse muntblaadjes voor een mooie presentatie en extra frisheid.',
                'calorie' => 215,
                'active' => true,
                'course_id' => 4,
                'path' => '/storage/dishpictures/fruitcocktail.jpeg',
                'cooking_time' => 0,
            ],
            [
                'id'=>21,
                'name'=>'Mojito',
                'instruction'=>'Plaats de muntblaadjes en de partjes limoen in een stevig glas.
Voeg de suiker toe.
Gebruik een muddler of de achterkant van een lepel om voorzichtig de munt en limoen te pletten, zodat de oliën en sappen vrijkomen.
Voeg de witte rum toe en roer goed door om de suiker op te lossen.
Vul het glas met ijsblokjes.
Top af met bruisend water (soda water) tot het glas bijna vol is.
Roer nogmaals voorzichtig om alle ingrediënten te mengen.',
                'preparation_time'=>10,
                'serving'=>1,
                'recipe_tag'=>'Cocktail',
                'comment'=>'Garneer met extra muntblaadjes en een partje limoen.',
                'calorie'=>200,
                'active'=>true,
                'course_id'=>5,
                'path'=>'/storage/cocktailphotos/mojito.jpg',
                'cooking_time'=>0,
            ],
            [
                'id'=>22,
                'name'=>'Sex on the beach',
                'instruction'=>'Vul een cocktailshaker met ijsblokjes.
Voeg de wodka, perziklikeur, cranberrysap en sinaasappelsap toe aan de shaker.
Sluit de shaker goed af en schud krachtig gedurende ongeveer 15 seconden, zodat alles goed gemengd en gekoeld wordt.
Vul een groot glas (bijvoorbeeld een tumbler of een wijnglas) met ijsblokjes.
Giet de inhoud van de shaker door een strainer (zeef) in het glas over de ijsblokjes.',
                'preparation_time'=>10,
                'serving'=>1,
                'recipe_tag'=>'Cocktail',
                'comment'=>'Vul een cocktailshaker met ijsblokjes.
Voeg de wodka, perziklikeur, cranberrysap en sinaasappelsap toe aan de shaker.
Sluit de shaker goed af en schud krachtig gedurende ongeveer 15 seconden, zodat alles goed gemengd en gekoeld wordt.
Vul een groot glas (bijvoorbeeld een tumbler of een wijnglas) met ijsblokjes.
Giet de inhoud van de shaker door een strainer (zeef) in het glas over de ijsblokjes.',
                'calorie'=>200,
                'active'=>true,
                'course_id'=>5,
                'path'=>'/storage/cocktailphotos/sex_on_the_beach.jpg',
                'cooking_time'=>0,
            ],
            [
                'id'=>23,
                'name'=>'Pina Colada',
                'instruction'=>'Voeg alle ingrediënten toe aan een blender: witte rum, ananassap, kokosmelk, vers limoensap en eventueel suiker.
Voeg een flinke hoeveelheid ijsblokjes toe aan de blender.
Blend alles op hoge snelheid tot een gladde en romige consistentie.
Proef de Piña Colada en voeg indien nodig meer suiker toe naar smaak.
Giet de Piña Colada in een groot glas.',
                'preparation_time'=>10,
                'serving'=>1,
                'recipe_tag'=>'Cocktail',
                'comment'=>'Garneer met een stukje ananas en/of een maraschino-kers op een cocktailprikker.',
                'calorie'=>200,
                'active'=>true,
                'course_id'=>5,
                'path'=>'/storage/cocktailphotos/pina_colada.jpg',
                'cooking_time'=>0,
            ],
            [
                'id'=>24,
                'name'=>'Pornstar Martini',
                'instruction'=>'Vul een cocktailshaker met ijsblokjes.
Voeg de vanille-wodka, passievruchtensiroop (of sap), vers limoensap en vanillesiroop toe aan de shaker.
Sluit de shaker goed af en schud krachtig gedurende ongeveer 15 seconden, zodat alles goed gemengd en gekoeld wordt.
Vul een martiniglas met ijsblokjes om het glas te koelen.
Gebruik een fijne zeef om de inhoud van de shaker in het gekoelde martiniglas te schenken.
Halveer de verse passievrucht en schep het vruchtvlees (pulp) met de zaden bovenop de cocktail.',
                'preparation_time'=>10,
                'serving'=>1,
                'recipe_tag'=>'Cocktail',
                'comment'=>'Serveer de Pornstar Martini direct, met een klein lepeltje om de passievruchtpulp te kunnen opscheppen terwijl je van de cocktail geniet.',
                'calorie'=>200,
                'active'=>true,
                'course_id'=>5,
                'path'=>'/storage/cocktailphotos/pornstar_martini.jpg',
                'cooking_time'=>0,
            ],
            [
                'id'=>25,
                'name'=>'Moscow Mule',
                'instruction'=>'Vul een koperen mok (of een ander glas) met ijsblokjes.
Giet de wodka over het ijs.
Voeg vers limoensap toe.
Top af met ginger beer tot het glas bijna vol is.
Roer voorzichtig om alles te mengen.',
                'preparation_time'=>10,
                'serving'=>1,
                'recipe_tag'=>'Cocktail',
                'comment'=>'Garneer met een partje limoen en een takje munt.',
                'calorie'=>200,
                'active'=>true,
                'course_id'=>5,
                'path'=>'/storage/cocktailphotos/moscow_mule.jpg',
                'cooking_time'=>0,
            ],
            [
                'id'=>26,
                'name'=>'Dark n Stormy',
                'instruction'=>'Vul een hoog glas (zoals een Collins glas) met ijsblokjes.
Giet de donkere rum over het ijs.
Voeg vers limoensap toe.
Top af met ginger beer tot het glas bijna vol is.
Roer voorzichtig om alles te mengen.',
                'preparation_time'=>10,
                'serving'=>1,
                'recipe_tag'=>'Cocktail',
                'comment'=>'Garneer met een schijfje limoen op de rand van het glas.',
                'calorie'=>200,
                'active'=>true,
                'course_id'=>5,
                'path'=>'/storage/cocktailphotos/dark_n_stormy.jpg',
                'cooking_time'=>0,
            ],
            [
                'id'=>27,
                'name'=>'Margarita',
                'instruction'=>'Als je de rand van het glas wilt zouten, wrijf dan eerst een limoenschijfje langs de rand van een margaritaglas. Dompel de rand vervolgens in zout dat je op een plat bord hebt gestrooid.
Vul een cocktailshaker met ijsblokjes.
Voeg de tequila, triple sec en vers limoensap toe aan de shaker.
Sluit de shaker goed af en schud krachtig gedurende ongeveer 15 seconden om alles goed te mengen en te koelen.
Vul het margaritaglas met ijsblokjes.
Gebruik een cocktailzeef om de inhoud van de shaker in het glas over de ijsblokjes te gieten.',
                'preparation_time'=>10,
                'serving'=>1,
                'recipe_tag'=>'Cocktail',
                'comment'=>'Garneer met een schijfje limoen op de rand van het glas.',
                'calorie'=>200,
                'active'=>true,
                'course_id'=>5,
                'path'=>'/storage/cocktailphotos/margarita.jpg',
                'cooking_time'=>0,
            ],
        ]);
    }
}
