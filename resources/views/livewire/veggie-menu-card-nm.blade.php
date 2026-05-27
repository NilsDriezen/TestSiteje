<div class="flex flex-col border shadow-xl h-full relative
{{--            hover:scale-125 hover:duration-300 hover:bg-white--}}
            ">
    @if ($nextMonthVeggieMenu->isNotEmpty())
        @foreach($nextMonthVeggieMenu as $vmenu)
            <h2 class="menu-h2 mt-10">
                {{ $vmenu->name }}
            </h2>
            <i class="fas fa-leaf menu-leaf absolute right-0 text-2xl
                    md:right-2
                    md:text-4xl
                    xl:right-2
                    xl:text-6xl
                    " style="color: green;">
            </i>
            <div class="p-4 text-center">
                <h3 class="font-bold mt-10 mb-2">
                    Voorgerecht
                </h3>
                {{ $vmenu->voorgerechtDish() ? $vmenu->voorgerechtDish()->name: '-' }}
                <h3 class="font-bold mt-16 mb-2">
                    Tussengerecht*
                </h3>
                {{ $vmenu->tussengerechtDish() ? $vmenu->tussengerechtDish()->name: '-' }}
                <h3 class="font-bold mt-16 mb-2">
                    Hoofdgerecht
                </h3>
                {{ $vmenu->hoofdgerechtDish() ? $vmenu->hoofdgerechtDish()->name: '-' }}
                <h3 class="font-bold mt-16 mb-2">
                    Dessert
                </h3>
                {{ $vmenu->dessertDish() ? $vmenu->dessertDish()->name: '-' }}
            </div>
            <div class="p-2 font-bold text-left mt-10 mb-2">
                &#8364 {{ $vmenu->price_3_course }} / {{ $vmenu->price_4_course }}*
            </div>
        @endforeach
            {{--        Indien geen vegetarische menu gepubliceerd voor deze maand.--}}
    @else
        <h2 class="menu-h2 relative mt-10">
            Menutitel
        </h2>
        <i class="fas fa-leaf menu-leaf absolute right-0 text-2xl
                md:right-2
                md:text-4xl
                xl:right-2
                xl:text-6xl
                " style="color: green;">
        </i>
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




