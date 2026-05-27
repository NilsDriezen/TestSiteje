{{--<x-tmk.cookie-card>--}}
@props([
    'src',
    'alt' => $src,
    'name',
    'description',
   'price',
   'stock',
    'id',
    ])
<div class="bg-white p-4 rounded-lg shadow-md relative flex flex-col h-full">
    <div class="relative mb-4">
        <img

                src="{{ asset(Storage::disk('public')->exists('cookiepictures/' . $src) ?
             'storage/cookiepictures/' . $src . "?v=" . time() :
             'storage/cookiepictures/placeholder.png') }}"
                alt="{{ $alt }}"
        {{ $attributes->merge(['class' => "w-full h-48 object-cover rounded-lg transition duration-300 transform hover:scale-101 hover:brightness-110 hover:drop-shadow-lg"])}}>
   @if($stock == '0')
       <p class="absolute bottom-1 right-0 font-extrabold text-white bg-red-600 rounded-md p-1" style="transform: rotate(350deg); margin: 10px;">UITVERKOCHT</p>
   @endif
</div>

    <div class="flex flex-row justify-between ">
        @auth()
            @if (auth()->user()->admin)
                <a href="{{ route('admin.koekjesbeheer', ['id' => $id]) }}"
                   class="text-gray-400 hover:text-red-700  transition m-2"
                   target="_blank"
                >
                    <x-phosphor-pencil-line-duotone class="inline-block w-5 h-5 absolute top-0 right-0"/>
                </a>
            @endif
        @endauth

        <h3  {{$attributes->merge(['class'=>"text-xl font-bold mb-2"])}}>
            {{ $name }}

        </h3>



    <div class="flex justify-between items-center mb-2 ">
        <div class="flex items-center">
            <p
               {{$attributes->merge(['class'=>"text-gray-700 mr-2"])}}
            >€{{ $price }}</p>
            @if($stock == '0')
                <x-icon
                    name="fas-exclamation-circle"
                    class="h-4 w-4 text-red-600 mr-1"
                    data-tippy-content="Niet beschikbaar"
                    data-tippy-theme="material"
                >
                </x-icon>
            @else
                @if($stock < '2')
                    <x-icon
                        name="fas-exclamation-circle"
                        class="h-4 w-4 text-orange-400 mr-1"
                        data-tippy-content="Lage voorraad: {{ $stock }}">
                        data-tippy-theme="material"
                    </x-icon>

                @else
                    <x-icon
                        name="fas-check-circle"
                        class="h-4 w-4 text-green-600  mr-1"
                        data-tippy-content="In voorraad: {{ $stock }}"
                        data-tippy-theme="material"
                    >
                    </x-icon>

                @endif
            @endif
        </div>
        <button class="w-6 hover:text-red-900"
                        wire:click="showItemDetails({{ $id }})"
                        data-tippy-content="Meer info">
            <x-phosphor-info-light

                class="outline-0"
            />
        </button>
        <button class="w-6 hover:text-red-900"
                wire:click="addToBasket({{ $id }})"
                data-tippy-content="Voeg toe aan mandje">
            <x-phosphor-shopping-bag-light
                class="outline-0"
            />
        </button>


    </div>
</div>
</div>

