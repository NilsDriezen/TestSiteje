<div>
    {{-- filter section: artist or title, genre, max price and records per page --}}
    <div class="grid grid-cols-10 gap-4">
        <div class="col-span-10 md:col-span-5 lg:col-span-3">
            {{--<x-label for="search" value="Filter"/>
            <div
                class="relative">
                <x-input id="search" type="text"
                         wire:model.live.debounce.500ms="search"
                         class="block mt-1 w-full"
                         placeholder="Filter op Naam/Recepttag"/>
                <button
                    @click="$wire.set('search', '')"
                    class="w-5 absolute right-4 top-3">
                    <x-phosphor-x/>
                </button>
            </div>--}}
            <x-label for="search" value="Filter" class="mt-1"/>
            <div
                class="relative">
            <x-input id="search" type="text" placeholder="Filter op gerecht"
                     class="w-full shadow-md placeholder-gray-300"
                     wire:model="search"
                     wire:model.live="search"
                     wire:model.live.debounce.500ms="search"
            />
            @if(!empty($search))
                <button
                    @click="$wire.set('search', '')"
                    class="w-5 absolute right-4 top-3 bg-gray-100 hover:bg-green-50">
                    <x-phosphor-x/>
                </button>
            @endif
        </div>
        </div>
        <div class="col-span-5 md:col-span-2 lg:col-span-2">
            <x-label for="typeGang" value="Type gang"/>
            <x-tmk.form.select id="typeGang" wire:model.live="typeGang" class="block mt-1 w-full">
                <option value="%">Alle</option>
                @foreach($recipe_tags as $g)
                    <option value="{{ $g->id }}">{{ $g->type }}</option>
                @endforeach
            </x-tmk.form.select>
            {{--<x-tmk.form.select id="search"
                               class="block mt-1 w-full">
                <option value="%">Alle</option>
            </x-tmk.form.select>--}}
            {{--<x-tmk.form.select
                id="search"
                wire:model.live="search"
                class="block mt-1 w-full">
                <option value="%">Alle</option>
                @foreach($recipe_tags as $g)
                    <option value="{{ $g->type }}">
                        {{ $g->type }}
                    </option>
                @endforeach
            </x-tmk.form.select>--}}
        </div>
        <div class="col-span-5 md:col-span-3 lg:col-span-2 sm:w-full">
            <x-label for="perPage" value="Gerechten per pagina"/>
            <x-tmk.form.select id="perPage"
                                 wire:model.live="perPage"
                               class="block mt-1 w-full">
                @foreach ([5, 10, 15, 20, 25] as $value)
                    <option value="{{ $value }}">{{ $value }}</option>
                @endforeach
            </x-tmk.form.select>

        </div>
        <!--w-3/4-->
        <div class="col-span-10 md:col-span-10 lg:col-span-3 items-center sm:justify-end lg:justify-end justify-self-end mt-4 lg:w-full h-2/3 md:w-2/6 sm:w-1/3">

            <button wire:click="newDish()" id="newdish" type="submit" class="w-full px-4 py-3 mt-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                Nieuw Gerecht
            </button>

        </div>


        {{--calorie filter--}}
        <div class="col-span-10 lg:col-span-3">
            <x-label for="calorie">Calorieën &le;
                <output id="caloriefilter" name="caloriefilter">{{ $calorieFilter }}</output>
            </x-label>
            <x-input type="range" id="calorie" name="calorie"
                     wire:model.live="calorieFilter"
                     min="0"
                     max="1000"
                     {{--min="{{ $calorieMin }}"
                     max="{{ $calorieMax }}"--}}
                     oninput="caloriefilter.value = caloriefilter.value"
                     class="block mt-4 w-full h-2 bg-indigo-100 accent-indigo-600 appearance-none"/>
        </div>
        {{--end price filter--}}
        {{--preparation_time--}}
        <div class="col-span-10 lg:col-span-3">
            <x-label for="preparation_time">Bereidingstijd &le;
                <output id="preparation_timefilter" name="preparation_timefilter">{{ $preparation_timeFilter }}</output>
            </x-label>
            <x-input type="range" id="preparation_time" name="preparation_time"
                     wire:model.live="preparation_timeFilter"
                     min="{{ $preparation_timeMin }}"
                     max="{{ $preparation_timeMax }}"
                     oninput="preparation_timefilter.value = preparation_time.value"
                     class="block mt-4 w-full h-2 bg-indigo-100 accent-indigo-600 appearance-none"/>
        </div>
    </div>
    {{--<div>


    </div>--}}
    <x-tmk.section class="py-0">
        <table class="text-center w-full bt-0 border-gray-300">
            <colgroup>
                <col style="width: 5%" class="hidden">
                <col style="width: 10%">
                <col style="width: 10%">
                <col style="width: 10%">
                <col style="width: 10%">
                <col style="width: 10%">
                <col style="width: 10%">
                <col style="width: 10%">
                <col style="width: 10%">
            </colgroup>
            <thead>
            <tr class="bg-gray-100 text-gray-700">
                {{--<th wire:click="resort('id')">
                    <span
                        data-tippy-content="Sorteer op id">#</span><x-heroicon-s-chevron-up
                        class="w-5 text-slate-400
                             {{$orderAsc ?: 'rotate-180'}}
                             {{$orderBy === 'id' ? 'inline-block' : 'hidden'}}"/></th>--}}
                {{--<th class="hidden">#</th>--}}
                {{--<th>Naam</th>--}}
                <th wire:click="resort('name')">
                    <span
                        data-tippy-content="Sorteer op naam">Naam</span><x-heroicon-s-chevron-up
                        class="w-5 text-slate-400
                             {{$orderAsc ?: 'rotate-180'}}
                             {{$orderBy === 'name' ? 'inline-block' : 'hidden'}}"/></th>
                <th>Foto</th>
                {{--<th>Type gang</th>--}}
                <th wire:click="resort('recipe_tag')">
                    <span
                        data-tippy-content="Sorteer op type gang">Type gang</span><x-heroicon-s-chevron-up
                        class="w-5 text-slate-400
                             {{$orderAsc ?: 'rotate-180'}}
                             {{$orderBy === 'recipe_tag' ? 'inline-block' : 'hidden'}}"/></th>
                {{--<th>Calorieën</th>--}}
                <th wire:click="resort('calorie')">
                    <span
                        data-tippy-content="Sorteer op calorieën">Calorieën</span><x-heroicon-s-chevron-up
                        class="w-5 text-slate-400
                             {{$orderAsc ?: 'rotate-180'}}
                             {{$orderBy === 'calorie' ? 'inline-block' : 'hidden'}}"/></th>
                {{--<th>Bereidingstijd</th>--}}
                {{--<th>Bereidingstijd(in minuten)</th>--}}
                <th wire:click="resort('preparation_time')">
                    <span
                        data-tippy-content="Sorteer op bereidingstijd">Bereidingstijd</span><x-heroicon-s-chevron-up
                        class="w-5 text-slate-400
                             {{$orderAsc ?: 'rotate-180'}}
                             {{$orderBy === 'preparation_time' ? 'inline-block' : 'hidden'}}"/></th>
                <th>Bereidingswijze</th>
                <th>Actief</th>
                <th></th>

            </tr>
            </thead>
            <tbody>
            @foreach ($dishes as $line)
                <tr wire:key="{{ $line->id }}" class="border-t border-gray-300">
                    {{--<td class="hidden">{{ $line->id }}</td>--}}
                    <td>{{ $line->name }}</td>
                    <td class="flex justify-center py-2">
                        <a data-tippy-content="Wijzig foto" href="{{ route('admin.gerechtenpictures', $line->id ) }}">
                            @php
                                $imagePath = $line->path ? str_replace('public/', '', $line->path) : 'storage/dishpictures/no-photo.png';
                            @endphp
                            <img src="{{ asset($imagePath) }}" alt="{{ $line->name }}" class="w-20 h-20 object-cover rounded-md">
                        </a>
                    </td>


                    {{--<td class="flex justify-center">
                        <a data-tippy-content="Wijzig foto" href="{{ route('admin.gerechtenpictures', $line->id ) }}">
                        <img src="{{ asset($line->path) }}" alt="{{ $line->name }}" class="w-20 h-20 object-cover">
                        </a>
                    </td>--}}
                    <td>{{ $line->recipe_tag }}</td>
                    <td>{{ $line->calorie }}</td>
                    <td>{{ $line->preparation_time }}</td>
                    <td>
                        <button
                            class="text-gray-400 hover:text-sky-100 hover:bg-sky-500 transition"
                            wire:click="showInstructions({{ $line->id }})">
                            <x-heroicon-o-clipboard-document-list class="inline-block w-5 h-5"/>
                        </button>
                    </td>
                    <td>
                        <input type="checkbox" class="rounded" wire:change="toggleActive({{ $line }})" {{ $line->active ? 'checked' : '' }}/>
                    </td>
                    <td>
                        <div class="border border-gray-300 rounded-md overflow-hidden m-2 grid grid-cols-2 h-10">
                            <button
                                class="text-gray-400 hover:text-sky-100 hover:bg-sky-500 transition border-r border-gray-300"
                                wire:click="editDish({{ $line->id }})

                                ">

                                <x-phosphor-pencil-line-duotone class="inline-block w-5 h-5"/>
                            </button>
                            {{--<a href="{{ url('admin.gerechten', $line->id)}}">hh</a>--}}
                            {{--<button
                                class="text-gray-400 hover:text-red-100 hover:bg-red-500 transition"
                                wire:click="delete({{ $line->id }})">
                                <x-phosphor-trash-duotone class="inline-block w-5 h-5"/>
                            </button>--}}
                            <button @click="$dispatch('swal:confirm', {
                                    title: 'Verwijder {{ $line->name }}?',
                                    cancelButtonText: 'NEE!',
                                    confirmButtonText: 'JA, VERWIJDER DIT GERECHT',
                                    next: {
                                        event: 'delete-dish',
                                        params: {
                                            id: {{ $line->id }}
                                        }
                                    }
                                })"
                                    class="text-gray-400 hover:text-red-100 hover:bg-red-500 transition">
                                <x-phosphor-trash-duotone class="inline-block w-5 h-5"/>
                            </button>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
            {{-- No records found --}}
            @if($dishes->isEmpty())
                <x-tmk.alert type="danger" class="w-full">
                    Niets gevonden!
                </x-tmk.alert>
            @endif

            <div class="my-4">
                {{ $dishes->links() }} {{-- Pagination Links --}}
            </div>

        </table>
    </x-tmk.section>

    {{-- Modal for add and update record --}}
    <x-dialog-modal id="dishModal"
                    wire:model.live="showModal">
        <x-slot name="title">
            {{ is_null($form->id) ? 'Nieuw gerecht' : 'Wijzig gerecht'}}
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
                    <x-label for="recepttag">Recepttag</x-label>
                    {{--<x-input id="recepttag"
                             type="text"
                             wire:model="form.recipe_tag"
                             class="w-full"/>--}}
                    <x-tmk.form.select id="recepttag"
                                       wire:model="form.recipe_tag"
                                       class="block mt-1 w-full">
                        <option value="%">Alle</option>
                        @foreach($recipe_tags as $g)
                            <option value="{{ $g->type }}">
                                {{ $g->type }}
                            </option>
                        @endforeach
                    </x-tmk.form.select>
                    <x-label for="bereidingstijd">Bereidingstijd</x-label>
                    <x-input type="number" id="bereidingstijd"
                             wire:model="form.preparation_time"
                             class="w-full"/>
                    <x-label for="kooktijd">Kooktijd</x-label>
                    <x-input type="number" id="kooktijd"
                                         wire:model="form.cooking_time"
                                         class="w-full"/>
                    <x-label for="calorie">Calorieën</x-label>
                    <x-input type="number" id="calorie"
                             wire:model="form.calorie"
                             class="w-full"/>
                    <x-label for="serving">Porties</x-label>
                    <x-input type="number" id="serving"
                             wire:model="form.serving"
                             class="w-full"/>
                    {{--<x-label for="photo">Foto</x-label>
                    <x-input id="photo"
                             type="text"
                             wire:model="form.path"
                             class="w-full"/>--}}

                    <x-label for="opmerkingen">Opmerkingen</x-label>
                    <x-input id="opmerkingen"
                             type="text"
                             wire:model="form.comment"
                             class="w-full"/>
                    <x-label for="type_gang">Type gang</x-label>
                    <x-tmk.form.select id="course_id"
                                       wire:model="form.course_id"
                                       class="block mt-1 w-full">
                        <option value="%">Alle</option>
                        @foreach($recipe_tags as $g)
                            <option value="{{ $g->id }}">
                                 {{ $g->type }}
                            </option>
                        @endforeach
                    </x-tmk.form.select>
                    <x-label for="instructions">Instructies</x-label>
                    <x-tmk.form.textarea id="instructions"
                                         wire:model="form.instructions"
                                         class="w-full"/>

                        {{--this is better than above--}}
                    <div class="max-h-32 overflow-y-auto mt-5 mb-5">
                        <table>
                            <thead>
                            <tr>
                                <th>Naam</th>
                                <th>Prijs</th>
                                <th>Hoeveelheid</th>
                                <th>Eenheid</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($allIngredients as $ingredient)
                                <tr>
                                    <td>
                                        <div class="space-y-2">
                                            <input type="checkbox" id="ingredient{{ $ingredient->id }}" class="rounded"
                                                   wire:model="selectedIngredients.{{ $ingredient->id }}.selected"
                                                   value="{{ $ingredient->id }}"
                                                   @if(isset($selectedIngredients[$ingredient->id]['selected']) && $selectedIngredients[$ingredient->id]['selected']) checked @endif>
                                            <label for="ingredient{{ $ingredient->id }}">{{ $ingredient->name }}</label>
                                        </div>
                                    </td>
                                    <td>€ {{ $ingredient->price }}</td>

                                    <td>
                                        <input type="number"
                                                   class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                                   id="quantity{{ $ingredient->id }}"
                                                   wire:model="selectedIngredients.{{ $ingredient->id }}.quantity"
                                                   value="{{ $selectedIngredients[$ingredient->id]['quantity'] ?? 0 }}">
                                    </td>
                                    <td>
                                        <input type="text" id="measurement_unit{{ $ingredient->id }}"
                                               class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                                   wire:model="selectedIngredients.{{ $ingredient->id }}.measurement_unit"
                                                   value="{{ $selectedIngredients[$ingredient->id]['measurement_unit'] ?? '' }}">
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                    <x-label for="active">Actief</x-label>
                    {{--<input id="active" type="checkbox" wire:model="form.active" class="form-checkbox h-5 w-5 text-sky-600" {{ $form->active ? 'checked' : '' }} />--}}
                    {{--<input type="checkbox" {{ $line->active === 1 ? 'checked' : '' }} />--}}
                    @if($form->active === 1)
                        <input type="checkbox" checked wire:model="form.active" class="form-checkbox h-5 w-5 text-sky-600 rounded" >
                    @else
                        <input type="checkbox" id="active" wire:model="form.active" class="form-checkbox h-5 w-5 text-sky-600 rounded">

                    @endif
                    {{--<label for="active" class="ml-2 block text-sm text-gray-900">{{ $form->active }}</label>
                    <x-label for="active">{{ $line->active }}</x-label>--}}
                </div>
            </div>

        </x-slot>
        <x-slot name="footer">
            <x-secondary-button @click="$wire.showModal = false">Annuleer</x-secondary-button>
            @if(is_null($form->id))
            <x-tmk.form.button color="success"

                               wire:click="createDish()"
                               class="ml-2">Opslaan</x-tmk.form.button>
            @else
                <x-tmk.form.button color="info"
                                   wire:click="updateDish({{ $form->id }})"
                                   class="ml-2">Opslaan
                </x-tmk.form.button>
            @endif

        </x-slot>
    </x-dialog-modal>

    {{-- instructions modal--}}
    <x-dialog-modal id="instructionsModal"
                    wire:model.live="showInstructionsModal">
        <x-slot name="title">
            Instructies
        </x-slot>
        <x-slot name="content">
                <div class="flex flex-row gap-4 mt-4">
                    <div class="flex-1 flex-col gap-2">
                        {{--<img src="/assets/images/{{ $form->path }}" alt="{{ $form->path }}" class="w-40 h-40 object-cover">--}}
                        <img src="{{ asset($form->path) . "?v=" . time() }}" alt="{{ $form->path }}" class="w-40 h-40 object-cover">
                        <hr class="mt-5 mb-5">
                        @if($editInstructionsAttr === false)
                            <button
                                class="text-gray-400 hover:text-sky-100 hover:bg-sky-500 transition pr-4"
                                wire:click="editInstructions({{ $form->id }})">
                                <x-si-ckeditor4 class="inline-block w-5 h-5 m-5"/>Klik hier om de instructies te wijzigen
                            </button>
                            {{--<p>{{ $form->instruction }}</p>--}}
                            <x-form.textarea id="instruction"
                                             wire:model="form.instruction"
                                             class="w-full min-h-80"
                                             disabled/>
                        @else
                            <x-tmk.form.textarea id="instruction"
                                                 wire:model="form.instruction"
                                                 class="w-full min-h-80"/>
                        @endif
                    </div>
                </div>
            </x-slot>
            <x-slot name="footer">
                @if($editInstructionsAttr === false)
                    <x-secondary-button @click="$wire.showInstructionsModal = false">Sluiten</x-secondary-button>
                @else
                    <x-secondary-button @click="$wire.showInstructionsModal = false">Annuleer</x-secondary-button>
                    <x-tmk.form.button color="success"
                                       wire:click="updateInstructions({{ $form->id }})"
                                       class="ml-2">Opslaan
                    </x-tmk.form.button>
                @endif
            </x-slot>
    </x-dialog-modal>


    {{--          logger--}}
{{--    <x-tmk.livewire-log :lines="$dishes"/>--}}
</div>





{{-- </div>--}}
{{-- <div class="max-h-32 overflow-y-auto mt-5 mb-5">
     <h3 class="font-semibold mb-2">Selecteer ingrediënten:</h3>
     <div class="space-y-2">
         @foreach($ingredients as $ingredient)
             <div>
                 <input type="checkbox" id="{{ $ingredient['id'] }}" wire:model="ingredients" value="{{ $ingredient->id }}">
                 <label for="{{ $ingredient['id'] }}">{{ $ingredient->name }}</label>
             </div>
         @endforeach
     </div>
 </div>--}}



{{--<x-dialog-modal id="ingredientsModal" wire:model.live="showIngredientsModal">
    <x-slot name="title">
        Ingrediënten toevoegen
    </x-slot>
    <x-slot name="content">
        <div>
            --}}{{-- Form or inputs for adding ingredients --}}{{--
        </div>
    </x-slot>
    <x-slot name="footer">
        <x-secondary-button @click="$wire.showIngredientsModal = false">Annuleren</x-secondary-button>
        <x-tmk.form.button color="success" wire:click="saveIngredients">Opslaan</x-tmk.form.button>
    </x-slot>
</x-dialog-modal>
--}}
