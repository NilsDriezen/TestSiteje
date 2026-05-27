<div>
    <x-tmk.section class="mb-4 flex gap-2">
    {{-- Begin filtersectie --}}

        {{-- Naamfilter --}}
        <div class="flex-1 relative">
            <x-input id="search" type="text" placeholder="Filter op naam of gerecht"
                     wire:model.live.debounce.300ms="name"
                     class="w-full shadow-md placeholder-gray-300"/>
            <button
                @click="$wire.set('name', '')"
                class="w-5 absolute right-4 top-3">
                <x-phosphor-x/>
            </button>
        </div>

        {{-- veggie filter --}}
        <div class="flex-1 relative">
            <x-label for="is_veggie"/>
            <x-tmk.form.select id="is_veggie"
                               wire:model.live="is_veggie"
                               class="w-full">
                <option value="">Alle</option>
                <option value="1">Vegetarisch</option>
                <option value="0">Niet vegetarisch</option>
            </x-tmk.form.select>
        </div>

        {{-- filter voor gepubliceerde menus --}}
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
            <x-label for="price_3_course">Price 3 course &le;
                <output  id="pricefilter" name="pricefilter">{{ $price_3_course }}</output>
            </x-label>
            <x-input type="range" id="price_3_course" name="price_3_course"
                     wire:model.live="price_3_course"
                     min="{{ $price_3_courseMin }}"
                     max="{{ $price_3_courseMax }}"
                     oninput="pricefilter.value = price_3_course.value"
                     class=""/>
        </div>

        {{-- Reset Filters knop --}}
        <x-button wire:click="resetFilters">
            Reset Filters
        </x-button>
    {{--Einde Filtersectie--}}

        <x-button wire:click="newMenu()">
            Nieuwe menu
        </x-button>
    </x-tmk.section>

    {{-- Tabel van menus --}}

        {{-- Klein scherm versie --}}
        <x-tmk.section class="block xl:hidden">
            <x-tmk.form.select id="perPage"
                               wire:model.live="perPage"
                               class="mb-5 block mt-1 w-full">
                <option value="1">1</option>
                <option value="5">5</option>
                <option value="10">10</option>
                <option value="15">15</option>
                <option value="20">20</option>
            </x-tmk.form.select>
            <table class="menu-table text-center w-full">
                @forelse($menus as $menu)
                    <tr class="bg-gray-100 text-gray-700 [&>th]:p-2">
                        <th>Naam</th>
                        <td>{{ $menu->name }}</td>
                    <tr class="bg-gray-200 text-gray-700 [&>th]:p-2">
                        <th>Vegetarisch</th>
                        <td>
                            @if($menu->is_veggie)
                                <x-checkbox checked disabled>{{$menu->is_veggie}}</x-checkbox>
                            @else
                                <x-checkbox disabled>{{$menu->is_veggie}}</x-checkbox>
                            @endif
                        </td>
                    <tr class="bg-gray-100 text-gray-700 [&>th]:p-2">
                        <th>Voorgerecht</th>
                        <td>{{ $menu->voorgerechtDish() ? $menu->voorgerechtDish()->name : '-' }}</td>
                    <tr class="bg-gray-200 text-gray-700 [&>th]:p-2">
                        <th>Tussengerecht</th>
                        <td>{{ $menu->tussengerechtDish() ? $menu->tussengerechtDish()->name : '-' }}</td>
                    <tr class="bg-gray-100 text-gray-700 [&>th]:p-2">
                        <th>Hoofdgerecht</th>
                        <td>{{ $menu->hoofdgerechtDish() ? $menu->hoofdgerechtDish()->name : '-' }}</td>
                    <tr class="bg-gray-200 text-gray-700 [&>th]:p-2">
                        <th>Dessert</th>
                        <td>{{ $menu->dessertDish() ? $menu->dessertDish()->name : '-' }}</td>
                    <tr class="bg-gray-100 text-gray-700 [&>th]:p-2">
                        <th>Prijs 3-gangen</th>
                        <td>&#8364 {{ $menu->price_3_course }}</td>
                    <tr class="bg-gray-200 text-gray-700 [&>th]:p-2">
                        <th>Prijs 4-gangen</th>
                        <td>&#8364 {{ $menu->price_4_course }}</td>
                    <tr class="bg-gray-100 text-gray-700 [&>th]:p-2">
                        <th>Publiceren</th>
                        <td>{{ $menu->date }}</td>
                    </tr>
                    <tr class="text-gray-700 [&>th]:p-2bg-gray-200">
                        <td>
                            <div class="border border-gray-300 rounded-md overflow-hidden m-2 grid grid-cols-2 h-10">
                                <button
                                    wire:click="editMenu({{ $menu->id }})"
                                    class="text-gray-400 hover:text-sky-100 hover:bg-sky-500 transition border-r border-gray-300">
                                    <x-phosphor-pencil-line-duotone class="inline-block w-5 h-5"/>
                                </button>
                                <button
                                    wire:click="deleteMenu({{ $menu->id }})"
                                    wire:confirm="Ben je zeker dat je deze menu wil verwijderen?"
                                    class="text-gray-400 hover:text-red-100 hover:bg-red-500 transition">
                                    <x-phosphor-trash-duotone class="inline-block w-5 h-5"/>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="border-none">
                            <div class="mt-3"></div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="border-t border-gray-300 p-4 text-center text-gray-500">
                            <div class="font-bold italic text-sky-800">Geen menu's gevonden</div>
                        </td>
                    </tr>
                @endforelse
            </table>
        </x-tmk.section>

        {{-- Groot scherm versie --}}
        <x-tmk.section class="hidden xl:block">
            <table class="text-center w-full border border-gray-300">
            {{-- Hoofding --}}
                <colgroup>
                    <col class="w-40">
                    <col class="w-14">
                    {{--gerechten--}}
                    <col class="w-40">
                    <col class="w-40">
                    <col class="w-64">
                    <col class="w-40">
                    {{--einde gerechten--}}
                    <col class="w-16">
                    <col class="w-16">
                    <col class="w-28">
                    <col class="w-24">
                </colgroup>
                <thead>
                    <th>Naam</th>
                    <th>Vegetarisch</th>
                    <th>Voorgerecht</th>
                    <th>Tussengerecht</th>
                    <th>Hoofdgerecht</th>
                    <th>Dessert</th>
                    <th>Prijs 3-gangen</th>
                    <th>Prijs 4-gangen</th>
                    <th>Publiceren</th>
                    <th>
                        <x-tmk.form.select id="perPage"
                                           wire:model.live="perPage"
                                           class="
                                           block mt-1 w-full
                                           md:order-10
                                           ">
                            <option value="1">1</option>
                            <option value="5">5</option>
                            <option value="10">10</option>
                            <option value="15">15</option>
                            <option value="20">20</option>
                        </x-tmk.form.select>
                    </th>
                </thead>

            {{-- Lijst van menus --}}
                <tbody>
                @forelse($menus as $menu)
                    <tr
                        wire:key="{{ $menu->id }}"
                        class="border-t border-gray-300">
                        <td>{{ $menu->name }}</td>
                        <td>
                            @if($menu->is_veggie)
                                <x-checkbox checked disabled>{{$menu->is_veggie}}</x-checkbox>
                            @else
                                <x-checkbox disabled>{{$menu->is_veggie}}</x-checkbox>
                            @endif
                        </td>
                        <td>{{ $menu->voorgerechtDish() ? $menu->voorgerechtDish()->name : '-' }}</td>
                        <td>{{ $menu->tussengerechtDish() ? $menu->tussengerechtDish()->name : '-' }}</td>
                        <td>{{ $menu->hoofdgerechtDish() ? $menu->hoofdgerechtDish()->name : '-' }}</td>
                        <td>{{ $menu->dessertDish() ? $menu->dessertDish()->name : '-' }}</td>
                        <td>&#8364 {{ $menu->price_3_course }}</td>
                        <td>&#8364 {{ $menu->price_4_course }}</td>
                        <td>@if(is_null($menu->date))
                                -
                            @else
                                {{ Carbon\Carbon::parse($menu->date)->translatedFormat('F Y', 'nl-NL') }}
                            @endif
                        </td>
                        <td>
                            <div class="border border-gray-300 rounded-md overflow-hidden m-2 grid grid-cols-2 h-10">
                                <button
                                    wire:click="editMenu({{ $menu->id }})"
                                    class="text-gray-400 hover:text-sky-100 hover:bg-sky-500 transition border-r border-gray-300">
                                    <x-phosphor-pencil-line-duotone class="inline-block w-5 h-5"/>
                                </button>
                                <button
                                    wire:click="deleteMenu({{ $menu->id }})"
                                    wire:confirm="Ben je zeker dat je deze menu wil verwijderen?"
                                    class="text-gray-400 hover:text-red-100 hover:bg-red-500 transition">
                                    <x-phosphor-trash-duotone class="inline-block w-5 h-5"/>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="border-t border-gray-300 p-4 text-center text-gray-500">
                            <div class="font-bold italic text-sky-800">Geen menu's gevonden</div>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </x-tmk.section>
        <div class="my-4">{{ $menus->links() }}</div>

        {{-- Formulier voor nieuwe menu of aanpassen --}}
        <x-dialog-modal id="menuModal"
                        wire:model.live="showModal">
            <x-slot name="title">
                <h2>{{ is_null($form->id) ? 'Nieuwe menu' : 'Wijzig menu' }}</h2>
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
                {{-- invulvelden --}}
                <div class="flex flex-row gap-4 mt-4">
                    <div class="flex-1 flex-col gap-2">
                        <x-label for="name">Naam</x-label>
                        <x-input id="name"
                                 type="text"
                                 wire:model="form.name"
                                 class="w-full mb-2"/>
                        <x-label for="voorgerecht">Voorgerecht</x-label>
                        <x-tmk.form.select id="voorgerecht"
                                           wire:model="form.voorgerecht"
                                           class="w-full mb-2">
                            <option value="">Kies een voorgerecht</option>
                            @foreach($voorgerechten as $voorgerecht)
                                <option value="{{ $voorgerecht->id }}">{{ $voorgerecht->id }} - {{ $voorgerecht->name }}</option>
                            @endforeach
                        </x-tmk.form.select>
                        <x-label for="tussengerecht">Tussengerecht</x-label>
                        <x-tmk.form.select id="tussengerecht"
                                           wire:model="form.tussengerecht"
                                           class="w-full mb-2">
                            <option value="">Kies een tussengerecht</option>
                            @foreach($tussengerechten as $tussengerecht)
                                <option value="{{ $tussengerecht->id }}">{{ $tussengerecht->id }} - {{ $tussengerecht->name }}</option>
                            @endforeach
                        </x-tmk.form.select>
                        <x-label for="hoofdgerecht">Hoofdgerecht</x-label>
                        <x-tmk.form.select id="hoofdgerecht"
                                           wire:model="form.hoofdgerecht"
                                           class="w-full mb-2">
                            <option value="">Kies een hoofdgerecht</option>
                            @foreach($hoofdgerechten as $hoofdgerecht)
                                <option value="{{ $hoofdgerecht->id }}">{{ $hoofdgerecht->id }} - {{ $hoofdgerecht->name }}</option>
                            @endforeach
                        </x-tmk.form.select>
                        <x-label for="dessert">Dessert</x-label>
                        <x-tmk.form.select id="dessert"
                                           wire:model="form.dessert"
                                           class="w-full mb-2">
                            <option value="">Kies een dessert</option>
                            @foreach($desserts as $dessert)
                                <option value="{{ $dessert->id }}">{{ $dessert->id }} - {{ $dessert->name }}</option>
                            @endforeach
                        </x-tmk.form.select>
                        <x-label for="price_3_course">Prijs 3-gangen</x-label>
                        <x-input id="price_3_course"
                                 type="number"
                                 wire:model="form.price_3_course"
                                 class="w-full mb-2"/>
                        <x-label for="price_4_course">Prijs 4-gangen</x-label>
                        <x-input id="price_4_course"
                                 type="number"
                                 wire:model="form.price_4_course"
                                 class="w-full mb-2"/>
                        <x-label for="date">Wanneer publiceren?</x-label>
                        <x-input id="date"
                                 type="month"
                                 wire:model="form.date"
                                 class="w-full mb-2"/>
                        <x-label for="is_veggie">Vegetarisch</x-label>
                        <x-input id="is_veggie"
                                 type="checkbox"
                                 wire:model="form.is_veggie"
                                 class=""/>
                    </div>
                </div>
            </x-slot>
            {{-- Formulier knoppen --}}
            <x-slot name="footer">
                <x-secondary-button @click="$wire.showModal = false">Annuleer</x-secondary-button>
                @if(is_null($form->id))
                    <x-tmk.form.button color="success"
                                       wire:click="createMenu()"
                                       class="ml-2">Opslaan
                    </x-tmk.form.button>
                @else
                    <x-tmk.form.button color="info"
                                       wire:click="updateMenu({{ $form->id }})"
                                       class="ml-2">Wijziging opslaan
                    </x-tmk.form.button>
                @endif
            </x-slot>
        </x-dialog-modal>
{{--    <x-tmk.livewire-log :menus="$menus"/>--}}
</div>

