<div class="flex flex-col border shadow-xl h-full
{{--            hover:scale-125 hover:duration-300 hover:bg-white--}}
            ">
    @if ($nextMonthMenu->isNotEmpty())
        @foreach($nextMonthMenu as $menu)
            <h2 class="menu-h2 mt-10">
                {{ $menu->name }}
            </h2>
            <div class="p-4 text-center">
                <h3 class="font-bold mt-10 mb-2">
                    Voorgerecht
                </h3>
                {{ $menu->voorgerechtDish() ? $menu->voorgerechtDish()->name: '-' }}
                <h3 class="font-bold mt-16 mb-2">
                    Tussengerecht*
                </h3>
                {{ $menu->tussengerechtDish() ? $menu->tussengerechtDish()->name: '-' }}
                <h3 class="font-bold mt-16 mb-2">
                    Hoofdgerecht
                </h3>
                {{ $menu->hoofdgerechtDish() ? $menu->hoofdgerechtDish()->name: '-' }}
                <h3 class="font-bold mt-16 mb-2">
                    Dessert
                </h3>
                {{ $menu->dessertDish() ? $menu->dessertDish()->name: '-' }}
            </div>
            <div class="p-2 font-bold text-left mt-10 mb-2">
                &#8364 {{ $menu->price_3_course }} / {{ $menu->price_4_course }}*
            </div>
        @endforeach
            {{--        Indien geen menu gepubliceerd voor deze maand.--}}
    @else
        <h2 class="menu-h2 mt-10">
            Menutitel
        </h2>
        <div class="p-4 text-center">
            <h3 class="font-bold mt-10 mb-2">
                Voorgerecht
            </h3>
            -
            <h3 class="font-bold mt-16 mb-2">
                Tussengerecht*
            </h3>
            -
            <h3 class="font-bold mt-16 mb-2">
                Hoofdgerecht
            </h3>
            -
            <h3 class="font-bold mt-16 mb-2">
                Dessert
            </h3>
            -
        </div>
        <div class="p-2 font-bold text-left mt-10 mb-2">
            &#8364 Prijs 3-gangen / Prijs 4-gangen*
        </div>
    @endif
</div>



