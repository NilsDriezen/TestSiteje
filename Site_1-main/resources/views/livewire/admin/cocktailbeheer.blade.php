<div>
    <x-tmk.section class="mb-4 flex gap-2">
    {{-- Begin filtersectie --}}

        {{-- naamfilter --}}
        <div class="flex-1 relative">
            <x-input id="search" type="text" placeholder="Filter op naam of beschrijving"
                     wire:model.live.debounce.300ms="name"
                     class="w-full shadow-md placeholder-gray-300"/>
            <button
                @click="$wire.set('name', '')"
                class="w-5 absolute right-4 top-3">
                <x-phosphor-x/>
            </button>
        </div>

        {{-- filter voor gepubliceerde cocktails --}}
        <div>
            <x-tmk.form.switch id="published"
                               wire:model.live="published"
                               text-off="Enkel gepubliceerde"
                               color-off="bg-gray-100 before:line-through"
                               text-on="Enkel gepubliceerde"
                               color-on="text-white bg-lime-600"
                               class="w-36 h-full"/>
        </div>

        {{-- prijsfilter --}}
        <div>
            <x-label for="price">Price &le;
                <output id="pricefilter" name="pricefilter">{{ $price }}</output>
            </x-label>
            <x-input type="range" id="price" name="price"
                     wire:model.live="price"
                     min="{{ $priceMin }}"
                     max="{{ $priceMax }}"
                     oninput="pricefilter.value = price.value"
                     class=""/>
        </div>

        {{-- Reset filters knop --}}
        <x-button wire:click="resetFilters">
            Reset Filters
        </x-button>
    {{-- Einde filtersectie --}}

        <x-button wire:click="newCocktail()">
            Nieuwe cocktail
        </x-button>
    </x-tmk.section>

    {{-- Tabel van cocktails --}}
    <x-tmk.section>
        {{-- Hoofding --}}
        <div class="my-4">{{ $cocktails->links() }}</div>
        <table class="text-center w-full border border-gray-300">
            <colgroup>
                <col class="w-24">
                <col class="w-60">
                <col class="w-20">
                <col class="w-max">
                <col class="w-20">
                <col class="w-24">
                <col class="w-24">
            </colgroup>
            <thead>
            <tr class="bg-gray-100 text-gray-700 [&>th]:p-2">
                <th>Foto</th>
                <th>Naam</th>
                <th>Prijs</th>
                <th>Beschrijving</th>
                <th>Publiceren</th>
                <th>Recept</th>
                <th>
                    <x-tmk.form.select id="perPage"
                                       wire:model.live="perPage"
                                       class="block mt-1 w-full">
                        <option value="5">5</option>
                        <option value="10">10</option>
                        <option value="15">15</option>
                        <option value="20">20</option>
                    </x-tmk.form.select>
                </th>
            </tr>
            </thead>

            {{-- Lijst van cocktails --}}
            <tbody>
            @forelse($cocktails as $cocktail)
                <tr
                    wire:key="{{ $cocktail->id }}"
                    class="border-t border-gray-300">
                    <td>
                        <img src="{{ asset($cocktail->photo) }}"
                             alt="{{ $cocktail->name }}"
                             class="my-2 border object-cover">
                    </td>
                    <td>{{ $cocktail->name }}</td>
                    <td>{{ $cocktail->price }}</td>
                    <td>{{ $cocktail->description }}</td>
                    <td>
                        @if(is_null($cocktail->date))
                            -
                        @else
                            {{ Carbon\Carbon::parse($cocktail->date)->translatedFormat('F Y', 'nl-NL') }}
                        @endif
                    </td>
                    <td>
                        @if($cocktail->dish_id == 1)
                            <button class="underline hover:text-gray-400">
                                <a href="{{ route('admin.gerechten', ['showModal' => true]) }}" title="Maak nieuw recept">{{ $cocktail->dish_id }}</a>
                            </button>
                        @else
                            <button class="underline hover:text-gray-400">
                                <a href="{{ route('admin.gerechten', ['search' => $cocktail->dish->name]) }}" title="Bekijk recept">{{ $cocktail->dish_id }}</a>
                            </button>
                        @endif
                    </td>
                    <td>
                        <div class="border border-gray-300 rounded-md overflow-hidden m-2 grid grid-cols-2 h-10">
                            <button
                                wire:click="editCocktail({{ $cocktail->id }})"
                                class="text-gray-400 hover:text-sky-100 hover:bg-sky-500 transition border-r border-gray-300">
                                <x-phosphor-pencil-line-duotone class="inline-block w-5 h-5"/>
                            </button>
                            <button
                                wire:click="deleteCocktail({{ $cocktail->id }})"
                                wire:confirm="Ben je zeker dat je deze cocktail wil verwijderen?"
                                class="text-gray-400 hover:text-red-100 hover:bg-red-500 transition">
                                <x-phosphor-trash-duotone class="inline-block w-5 h-5"/>
                            </button>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="border-t border-gray-300 p-4 text-center text-gray-500">
                        <div class="font-bold italic text-sky-800">Geen cocktails gevonden</div>
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
        <div class="my-4">{{ $cocktails->links() }}</div>
    </x-tmk.section>

    {{-- Formulier voor nieuwe cocktail of aanpassen --}}
    <x-dialog-modal id="cocktailModal"
                    wire:model.live="showModal">
        <x-slot name="title">
            <h2>{{ is_null($form->id) ? 'Nieuwe cocktail' : 'Wijzig cocktail' }}</h2>
        </x-slot>
        <x-slot name="content">
            {{-- error messages --}}
            @if ($errors->any())
                <x-tmk.alert type="danger">
                    <x-tmk.list>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </x-tmk.list>
                </x-tmk.alert>
            @endif
            <div class="flex flex-row gap-4 mt-4">
                <div class="flex-1 flex-col gap-2">
                    <x-label for="name">Naam</x-label>
                    <x-input id="name"
                             type="text"
                             wire:model="form.name"
                             class="w-full"/>
                    <x-label for="price">Prijs</x-label>
                    <x-input id="price"
                             type="number"
                             wire:model="form.price"
                             class="w-full"/>
                    <x-label for="description">Beschrijving</x-label>
                    <x-tmk.form.textarea id="description"
                                         wire:model="form.description"
                                         class="w-full"/>
                    <x-label for="dishId">Recept</x-label>
                    <x-tmk.form.select id="recept"
                                       type="number"
                                       wire:model="form.dish_id"
                                       class="w-full">
                        @foreach ($dishes as $dish)
                            <option value="{{ $dish->id }}">{{ $dish->id }} - {{ $dish->name }}</option>
                        @endforeach
                    </x-tmk.form.select>
                    <x-label for="date">Wanneer publiceren?</x-label>
                    <x-input id="date"
                             type="month"
                             wire:model="form.date"
                             class="w-full"/>
                    <div>
                        <x-label for="photo">Foto</x-label>
                        <x-input id="photo"
                                 type="file"
                                 wire:model="form.newPhoto"
                                 class="w-full
                                       file:mr-4 file:py-2 file:px-4
                                       file:rounded-full file:border-0
                                       file:text-sm file:font-semibold
                                       file:bg-violet-50 file:text-violet-700
                                       hover:file:bg-violet-100
                                 "/>
                        <x-label for="photo" class="mt-2">Preview</x-label>
                        <div class="flex border w-24 h-24">
                            <img src="{{ $form->newPhoto ? $form->newPhoto->temporaryUrl(): asset($form->photo) }}" class="object-cover" alt="$form.name">
                        </div>
                    </div>
                </div>
            </div>
        </x-slot>
        <x-slot name="footer">
            <x-secondary-button @click="$wire.showModal = false">Annuleer</x-secondary-button>
            @if(is_null($form->id))
                <x-tmk.form.button color="success"
                                   wire:click="createCocktail()"
                                   class="ml-2">Opslaan
                </x-tmk.form.button>
            @else
                <x-tmk.form.button color="info"
                                   wire:click="updateCocktail({{ $form->id }})"
                                   class="ml-2">Wijziging opslaan
                </x-tmk.form.button>
            @endif
        </x-slot>
    </x-dialog-modal>
{{--    <x-tmk.livewire-log :cocktails="$cocktails" :dishes="$dishes"/>--}}
</div>
