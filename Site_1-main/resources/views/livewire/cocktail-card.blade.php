<div class="flex flex-col border shadow-xl h-full">
    @if ($thisMonthCocktail->isNotEmpty())
        @foreach($thisMonthCocktail as $cocktail)
            <h2 class="menu-h2 mt-10">
                {{ $cocktail->name }}
            </h2>
            <div class="flex flex-col max-h-64 ml-5 mr-5
                        md:max-h-80">
                <img src="{{ $cocktail->photo ?? @asset('/storage/cocktailphotos/no-photo.jpg') }}" alt="Cocktailfoto"
                     class="m-5 flex overflow-auto object-contain">
            </div>
            <div class="ml-5 mr-5">
                <p class="grow mt-5 text-center font-bold">
                    Beschrijving
                </p>
            </div>
            <div class="flex justify-center ml-5 mr-5">
                <p class="max-w-72 text-center mt-5
                           md:max-w-80
                           ">
                    {{ $cocktail->description }}
                </p>
            </div>
            <div class="row-span-2 p-2 mt-10 grow flex items-end font-bold mb-2">
                &#8364 {{ $cocktail->price }}
            </div>
        @endforeach
            {{--        Indien geen cocktail gepubliceerd voor deze maand.--}}
    @else
        <h2 class="menu-h2 mt-10">
            Cocktailnaam
        </h2>
        <div class="flex flex-col ml-5 mr-5">
            <img src="storage/cocktailphotos/no-photo.jpg" alt="Cocktailfoto" class="m-5 flex overflow-auto object-contain md:max-h-80">
        </div>
        <div class="ml-5 mr-5">
            <p class="grow mt-5 text-center font-bold">
                Beschrijving
            </p>
        </div>
        <div class="row-span-2 p-2 mt-10 grow flex items-end font-bold text-left mb-2">
            &#8364 Prijs
        </div>
    @endif
</div>

