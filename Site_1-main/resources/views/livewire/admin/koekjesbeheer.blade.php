<div>
    {{--optie met modal--}}
    <x-dialog-modal wire:model="showModal" maxWidth="2xl">
        <x-slot name="title">
        </x-slot>

        <x-slot name="content">
            <div>
                @props(['columns', 'editing', 'textareaColumns','hiddenColumns' => ['id'], 'booleanColumns', 'newLineActive' ])
                {{--         Sectie om de nieuwe items (lines) toe te voegen--}}
                <x-tmk.section>
                    <div class="flex flex-row gap-4 justify-between">
                        <div class="flex flex-col items-start w-full">
                            @foreach ($columns as $column)
                                @if (!in_array($column, $hiddenColumns)   )
                                    @if (in_array($column, $booleanColumns))
                                        <!-- Hier wordt een checkbox weergegeven -->
                                        <div class="mb-2">
                                            <label
                                                for="newLine{{ $column }}"
                                                class="">
{{--                                                {{ ucfirst(__($column)) }}--}}
                                                Publiceren
                                                <input
                                                    id="newLine{{ $column }}" type="checkbox"
                                                    wire:model="{{ 'newLine' . ucfirst($column) }}"
                                                    class="ml-2 form-checkbox rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                                                    {{  (${"newLine" . ucfirst($column)} ? 'checked' : '') }}
                                                >
                                            </label></div>

                                    @else

                  @if(in_array($column, $textareaColumns))

    <!-- Hier wordt een textarea weergegeven -->
    <label for="newLine{{ $column }}">{{ ucfirst(__($column)) }}</label>
    <x-tmk.input-or-text type="textarea" id="newLine{{ $column }}"
                         rows="10"
                         placeholder="Voeg {{ __($column) }} toe"
                         wire:model="{{ $column === 'name' ? 'newLine' : 'newLine' . ucfirst($column) }}"
                         wire:keydown.escape="resetValues()"
                         class="w-full shadow-md placeholder-gray-300 my-2"></x-tmk.input-or-text>
@else

    <!-- Hier wordt een inputveld weergegeven -->
    <label for="newLine{{ $column }}">{{ ucfirst(__($column)) }}</label>
    <x-tmk.input-or-text id="newLine{{ $column }}"
                         placeholder="Voeg {{ __($column) }} toe"
                         wire:model="{{ $column === 'name' ? 'newLine' : 'newLine' . ucfirst($column) }}"
                         wire:keydown.escape="resetValues()"
                         class="w-full shadow-md placeholder-gray-300 my-2"></x-tmk.input-or-text>

@endif
                                    @endif
                                @else
                                    <!-- Verborgen inputveld voor "id" kolom -->
                                    <input type="hidden" id="newLine{{ $column }}" wire:model="newLine"/>
                                @endif
                            @endforeach
                            {{--                     inputerrors--}}
                            <div class="px-4 items-start gap-4">
                                @foreach ($columns as $column)
                                    @if ($column !== 'id')
                                        <x-input-error
                                            for="{{ $column === 'name' ? 'newLine' : 'newLine' . ucfirst($column) }}"
                                            class="w-full"/>
                                    @endif
                                @endforeach

                            </div>
                            <x-label for="dish_id" value="Recept"/>
                            <x-tmk.form.select wire:model="newLineDish_id"
                                               id="dish_id"
                                               class="block mt-2 w-full">
                                <option value="">Selecteer een recept</option>
                                @foreach($dishes as $dish)
                                    <option value="{{ $dish->id }}">
                                        {{$dish ->name}}
                                    </option>
                                @endforeach
                            </x-tmk.form.select>
                        </div>
                        {{--                 add or update--}}
                        <div class="flex flex-col w-32">
                            @if ($editing)
                                <!-- edit form elements go here -->
                                <x-button wire:click="createOrUpdate" class="flex justify-center bg-red-700 mt-1">Werk
                                    bij
                                </x-button>
                            @else
                                <!-- create form elements go here -->
                                <x-button wire:click="createOrUpdate" class="flex justify-center mt-1">Voeg toe
                                </x-button>
                            @endif

                            @if($newLinePicture_path != null)
                                <a href="{{ route('admin.cookiepictures', $editingLineId) }}">
                                    <img
                                        src="{{ asset('storage/cookiepictures/' . $newLinePicture_path) . "?v=" . time() }}"
                                        alt="{{ $newLinePicture_path }}"
                                        class="mx-1 m-2 border object-cover w-24 h-24 aspect-w-1 aspect-h-1"
                                    />
                                </a>
                            @else

{{--                               <img src="{{ asset('storage/cookiepictures/placeholder.png') }}"--}}
{{--                                             alt="{{ $newLinePicture_path }}"--}}
{{--                                            class="mx-1 m-2 border object-cover w-24 h-24 aspect-w-1 aspect-h-1"--}}
{{--                                       />--}}

                            @endif


                        </div>
                    </div>


                </x-tmk.section>
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$toggle('showModal')" wire:loading.attr="disabled">
                Cancel
            </x-secondary-button>
        </x-slot>

    </x-dialog-modal>


    {{--optie zonder modal--}}
    {{--        <div>
                @props(['columns', 'editing', 'textareaColumns','hiddenColumns' => ['id'], 'booleanColumns', 'newLineActive' ])
                         Sectie om de nieuwe items (lines) toe te voegen
                <x-tmk.section>
                    <div class="flex flex-row gap-4 justify-between">
                        <div class="flex flex-col items-start w-full">
                            @foreach ($columns as $column)
                                @if (!in_array($column, $hiddenColumns)   )
                                    @if (in_array($column, $booleanColumns))
                                        <!-- Hier wordt een checkbox weergegeven -->
                                        <div class="mb-2"><label for="newLine{{ $column }}" class="text-lg font-bold">
                                                {{ ucfirst(__($column)) }}
                                                <input id="newLine{{ $column }}" type="checkbox"
                                                       wire:model="{{ 'newLine' . ucfirst($column) }}"
                                                       class="ml-2 form-checkbox"
                                                    {{  (${"newLine" . ucfirst($column)} ? 'checked' : '') }}
                                                >
                                            </label></div>
                                    @else

                                        @if(in_array($column, $textareaColumns))

                                            <!-- Hier wordt een textarea weergegeven -->
                                            <x-tmk.input-or-text type="textarea" id="newLine{{ $column }}"
                                                                 placeholder="Voeg {{ __($column) }} toe"
                                                                 wire:model="{{ $column === 'name' ? 'newLine' : 'newLine' . ucfirst($column) }}"
                                                                 wire:keydown.escape="resetValues()"
                                                                 class="w-full shadow-md placeholder-gray-300 mb-3"></x-tmk.input-or-text>
                                        @else

                                            <!-- Hier wordt een inputveld weergegeven -->
                                            <x-tmk.input-or-text id="newLine{{ $column }}"
                                                                 placeholder="Voeg {{ __($column) }} toe"
                                                                 wire:model="{{ $column === 'name' ? 'newLine' : 'newLine' . ucfirst($column) }}"
                                                                 wire:keydown.escape="resetValues()"
                                                                 class="w-full shadow-md placeholder-gray-300 mb-3"></x-tmk.input-or-text>

                                        @endif
                                    @endif
                                @else
                                    <!-- Verborgen inputveld voor "id" kolom -->
                                    <input type="hidden" id="newLine{{ $column }}" wire:model="newLine"/>
                                @endif
                            @endforeach
                                                 inputerrors
                            <div class="px-4 items-start gap-4">
                                @foreach ($columns as $column)
                                    @if ($column !== 'id')
                                        <x-input-error
                                            for="{{ $column === 'name' ? 'newLine' : 'newLine' . ucfirst($column) }}"
                                            class="w-full"/>
                                    @endif
                                @endforeach                    </div>
                        </div>
                                         add or update
                        <div class="flex flex-col w-32">
                            @if ($editing)
                                <!-- edit form elements go here -->
                                <x-button wire:click="createOrUpdate" class="flex justify-center bg-red-700 mt-1">Werk bij
                                </x-button>
                            @else
                                <!-- create form elements go here -->
                                <x-button wire:click="createOrUpdate" class="flex justify-center mt-1">Voeg toe</x-button>
                            @endif

                            @if($newLinePicture_path != null)
                                <a href="{{ route('admin.cookiepictures', $editingLineId) }}">
                                    <img
                                        src="{{ asset('storage/cookiepictures/' . $newLinePicture_path) . "?v=" . time() }}"
                                        alt="{{ $newLinePicture_path }}"
                                        class="mx-1 m-2 border object-cover w-24 h-24 aspect-w-1 aspect-h-1"
                                    />
                                </a>
                            @else

                                       <img src="{{ asset('storage/cookiepictures/placeholder.png') }}"
                                            alt="{{ $newLinePicture_path }}"
                                            class="mx-1 m-2 border object-cover w-24 h-24 aspect-w-1 aspect-h-1"
                                       />

                            @endif


                        </div>
                    </div>

                </x-tmk.section>
            </div>--}}


    <!-- DynamicTable.blade.php -->

    @if($lines->isNotEmpty())
        <div class="flex justify-end">
            <x-button wire:click="openModal" class="mt-4 ">Voeg een nieuw koekje toe</x-button>
        </div>
    @endif

    <div class="">
        <x-tmk.section class="py-0">

            <x-tmk.section>
                <h1 class="text-xl font-bold text-gray-900">Filter</h1>
                <div class="my-4 flex flex-col sm:flex-row gap-2">
                    <div class="flex-1 relative mb-2 sm:mb-0">
                        <x-input id="search" type="text" placeholder="Filter"
                                 wire:model.live.debounce.500ms="search"
                                 wire:keydown.escape="resetValues"
                                 class="w-full shadow-md placeholder-gray-300"/>
                        <button
                            @click="$wire.set('search', '')"
                            class="w-5 absolute right-4 top-3">
                            <x-phosphor-x/>
                        </button>
                    </div>
                    <div class=" flex flex-row gap-2 justify-center">
                        <x-tmk.form.switch
                            wire:model.live="showInStock"
                            id="showInStock"
                            text-off="vooraad"
                            color-off="bg-lime-100"
                            text-on="geen VOORRAAD"
                            color-on="text-white bg-red-600"
                            class="w-20 h-auto"/>

                        <x-tmk.form.switch
                            wire:model.live="showActive"
                            id="showActive"
                            text-off="Gepubliceerd"
                            color-off="bg-lime-100"
                            text-on="Niet gepubliceerd"
                            color-on="text-white bg-red-600"
                            class="w-24 h-auto"/>


                    </div>
                </div>


            </x-tmk.section>
            {{--            // Sectie om de tabel te maken op basis van de kolomnamen (uitgezonderd exclude--}}

            @php
                $exclude = ['id' ];
                $columns = array_diff($columns, $exclude);
            @endphp

            <table class="min-w-full border-gray-300 mt-2 xl:table hidden">
                <thead>
                <tr class="bg-gray-100 text-gray-700 [&>th]:p-2">
                    @foreach ($columns as $column)
                        @if ($column === 'active')
                            <th class="px-2">
                                <div class="flex">
                                    <span>Gepubliceerd</span>
                                </div>
                            </th>
                        @else
                            <x-tmk.sort-table-header columnName="{{ $column }}" orderBy="{{ $orderBy }}"
                                                     orderAsc="{{ $orderAsc }}"/>
                        @endif
                    @endforeach
                    <!-- Extra kolomkop voor de potlood/vuilbakknop -->
                    @if (!$lines->isEmpty())

                        <th id="actions">Bewerk</th>
                    @endif
                </tr>
                </thead>
                <tbody>
                @foreach($lines as $line)
{{--                    <tr class="border-t border-gray-300" wire:key="{{ $line->id }}">--}}

                        <tr class="border-t {{ $line->stock == 0 ? 'border-gray-00 bg-red-200' : 'border-gray-300' }}" wire:key="{{ $line->id }}">
                            {{--<tr class="border-t {{ $line->stock == 0 ? 'border-gray-00 bg-red-200' : ($line->stock < 3 ? 'border-gray-300 bg-orange-200' : 'border-gray-300') }}" wire:key="{{ $line->id }}">--}}


                        @foreach($columns as $column)
                            @if($column === 'picture_path')
                                <td class="px-2">
                                    <a href="{{ route('admin.cookiepictures', $line->id) }}">
                                        @if(Storage::disk('public')->exists('cookiepictures/' . $line->picture_path))
                                            <img
                                                src="{{ asset('storage/cookiepictures/' . $line->$column) . "?v=" . time() }}"
                                                alt="{{ $line->$column }}"
                                                class="my-2 border object-cover w-12 h-12 aspect-w-1 aspect-h-1"
                                            />
                                        @else
                                            <img src="{{ asset('storage/cookiepictures/placeholder.png') }}"
                                                 alt="{{ $line->$column }}"
                                                 class="my-2 border object-cover w-12 h-12 aspect-w-1 aspect-h-1"
                                            />
                                        @endif
                                    </a>
                                </td>
                            @else
                                @if(in_array($column, $booleanColumns))
                                        <td class="px-2">
                                            @if ($column === 'active')
                                                @if($line->$column)
                                                    <!-- Groen vinkje -->
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="green" wire:click="toggleActive({{$line->id}})" class="w-6 h-6 cursor-pointer hover:scale-110 transition-transform">
                                                        <path fill-rule="evenodd" d="M15.293 5.293a1 1 0 0 1 1.414 1.414l-7 7a1 1 0 0 1-1.414 0l-3-3a1 1 0 0 1 1.414-1.414L8 12.586l6.293-6.293a1 1 0 0 1 1.414 0z" clip-rule="evenodd" />
                                                    </svg>
                                                @else
                                                    <!-- Rood kruis -->
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="red" wire:click="toggleActive({{$line->id}})" class="w-6 h-6 cursor-pointer hover:scale-110 transition-transform">
                                                        <path fill-rule="evenodd" d="M6.707 6.293a1 1 0 0 1 1.414-1.414L10 8.586l2.879-2.88a1 1 0 1 1 1.414 1.414L11.414 10l2.88 2.879a1 1 0 1 1-1.414 1.414L10 11.414l-2.879 2.88a1 1 0 0 1-1.414-1.414L8.586 10 5.707 7.121a1 1 0 0 1 0-1.414z" clip-rule="evenodd" />
                                                    </svg>
                                                @endif
                                            @else
                                                <input type="checkbox" disabled {{ $line->$column ? 'checked' : '' }}>
                                            @endif
                                        </td>
                                @else
                                    @if($column === 'dish_id')
                                        <td class="px-2">
                                            @if($line->dish_id == 1)
                                                <a href="{{ route('admin.gerechten', ['showModal' => true]) }}" class="text-gray-400 hover:text-black transition" title="Maak nieuw recept aan">
                                                    <x-phosphor-file-plus class="inline-block w-5 h-5"/>
                                                </a>
                                            @else
                                            <a href="{{ route('admin.gerechten',['search' => $line->dish->name]) }}"
                                               class="text-gray-400 hover:text-black transition" title="Bekijk recept">
                                                <x-phosphor-eye class="inline-block w-5 h-5"/>
                                            </a>
                                            @endif
                                        </td>
                                    @else
                                     <td class="px-2 {{ strlen($line->$column) == 1 ? 'pl-5' : '' }}"
    @if(strlen($line->$column) > 50) data-tippy-content="{{ $line->$column }}" @endif>
                                            @if($column === 'price')
    €{{ Str::limit($line->$column, 50, '...') }}
@else
    {{ Str::limit($line->$column, 50, '...') }}
@endif
                                        @endif
                                @endif
                            @endif
                        @endforeach
                        <td>
                            <!-- Potlood/vuilbakknop -->
                            <x-tmk.action-button-group :lineId="$line->id" :lineName="$line->name ?? 'line'"/>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            {{--             No records found--}}
            @if($lines  ->isEmpty())
                <x-tmk.alert type="danger" class="w-full">
                    Niets gevonden!
                </x-tmk.alert>
            @endif

            {{--            Pagination Links--}}
            <div class="my-4">
                {{ $lines->links() }}
            </div>

        {{--         kleine kaartjes--}}
            <div class="xl:hidden grid sm:grid-cols-2 gap-4 mb-4 ">
                @foreach($lines as $line)
                    <x-tmk.cookie-crud-card :line="$line"/>
                @endforeach
            </div>
        </x-tmk.section>
    </div>
    {{--              logger--}}
{{--    <x-tmk.livewire-log :lines="$lines"/>--}}

</div>



