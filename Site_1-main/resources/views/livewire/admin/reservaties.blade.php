@props(['columns', 'editing', 'textareaColumns', 'hiddenColumns' => ['id'], 'booleanColumns'])
<div x-data="{ showForm: false }">

    <div>


        @php
            $default_capacity = 20;
            $extracted_data = [];
            $available_dates = [];

            foreach ($openingDays as $date => $timeSlots) {
                foreach ($timeSlots as $timeSlot) {
                    $remaining_capacity = $default_capacity;
                    if ($timeSlot['type'] == 'reservaties') {
                        foreach ($reservations_all as $reservatie) {
                            if ($reservatie->date == $date) {
                                $remaining_capacity -= $reservatie->number_of_person;
                            }
                        }
                        $extracted_data[] = [
                            'remaining_capacity' => $remaining_capacity,
                            'date' => $date,
                            'start_time' => $timeSlot['start_time'],
                        ];

                        if ($remaining_capacity >= $newLineNumberOfPerson) {
                            $available_dates[$date] = [
                                'date' => $date,
                                'remaining_capacity' => $remaining_capacity,
                            ];
                        }
                    }
                }
            }

            foreach ($lines as $line) {
                if ($line->is_new == 1) {
                    $new_entries[] = $line;
                }
            }
        @endphp


        <input type="hidden" id="jsonTableData" value="{{ json_encode($extracted_data) }}">

        {{-- Sectie om de nieuwe items (lines) toe te voegen --}}
        <x-tmk.section x-show="showForm">
            <div class="flex flex-row gap-4 justify-between">
                <div class="flex flex-col items-start w-full">
                    @foreach ($columns as $column)
                        @if (!in_array($column, $hiddenColumns))
                            @if ($column == 'date')
                                <x-form.select name="available_dates" id="newLineDate" wire:model="newLineDate"
                                               class="w-full shadow-md placeholder-gray-300 mb-3">
                                    <option value="">Selecteer een beschikbare datum</option>
                                    @foreach ($available_dates as $dateInfo)
                                        <option value="{{ $dateInfo['date'] }}"
                                                data-remaining-capacity="{{ $dateInfo['remaining_capacity'] }}">{{ $dateInfo['date'] }}
                                            - Overblijvende capaciteit: {{ $dateInfo['remaining_capacity'] }}</option>
                                    @endforeach
                                </x-form.select>
                            @elseif ($column == 'time_slot')
                                <x-form.select name="available_time_slots" id="newLineTimeSlot" wire:model="newLineTime_slot"
                                   class="w-full shadow-md placeholder-gray-300 mb-3">
                                    <option value="{{$newLineTime_slot}}">{{$newLineTime_slot}}</option>
                                    @foreach ($extracted_data as $timeInfo)
                                        @if($timeInfo['date'] == $newLineDate);
                                            @if($newLineTime_slot != $timeInfo['start_time'] );
                                            <option value="{{ $timeInfo['start_time'] }}">
                                                {{ $timeInfo['start_time'] }}
                                            </option>
                                            @endif;
                                        @endif;
                                    @endforeach
                                </x-form.select>
                            @elseif (in_array($column, $booleanColumns))
                                <!-- Checkbox for boolean columns -->
                                <div class="mb-2">
                                    <label for="newLine{{ $column }}" class="text-lg font-bold">
                                        {{ ucfirst(__($column)) }}
                                        <input id="newLine{{ $column }}" type="checkbox"
                                               wire:model="{{ 'newLine' . ucfirst($column) }}"
                                               class="ml-2 form-checkbox" {{ ${"newLine" . ucfirst($column)} === 1 ? 'checked' : '' }}>
                                    </label>
                                </div>
                            @else
                                @if (in_array($column, $textareaColumns))
                                    <!-- Textarea for specified columns -->
                                    <x-tmk.input-or-text type="textarea" id="newLine{{ $column }}"
                                                         placeholder="Voeg {{ __($column) }} toe"
                                                         wire:model="{{ $column === 'name' ? 'newLine' : 'newLine' . ucfirst($column) }}"
                                                         wire:keydown.escape="resetValues()"
                                                         class="w-full shadow-md placeholder-gray-300 mb-3"></x-tmk.input-or-text>
                                @else
                                    <!-- Input field for other columns -->
                                    <x-tmk.input-or-text id="newLine{{ $column }}"
                                                         placeholder="Voeg {{ __($column) }} toe"
                                                         wire:model="{{ $column === 'name' ? 'newLine' : 'newLine' . ucfirst($column) }}"
                                                         wire:keydown.escape="resetValues()"
                                                         class="w-full shadow-md placeholder-gray-300 mb-3"></x-tmk.input-or-text>
                                @endif
                            @endif
                        @endif
                    @endforeach

                    {{-- inputerrors --}}
                    <div class="px-4 items-start gap-4">
                        @foreach ($columns as $column)
                            @if ($column !== 'id')
                                <x-input-error for="{{ $column === 'name' ? 'newLine' : 'newLine' . ucfirst($column) }}"
                                               class="w-full"/>
                            @endif
                        @endforeach
                    </div>
                </div>
                {{-- add or update --}}
                <div class="flex flex-col w-32">
                    @if ($editing)
                        <!-- edit form elements go here -->
                        <x-button wire:click="createOrUpdate" class="flex justify-center bg-red-700 mt-1" @click="showForm = false">Werk bij
                        </x-button>
                    @else
                        <!-- create form elements go here -->
                        <x-button wire:click="createOrUpdate" class="flex justify-center mt-1">Voeg toe</x-button>
                    @endif
                </div>
            </div>
        </x-tmk.section>
    </div>

    <!-- DynamicTable.blade.php -->
    <div class="">
        {{--    // Sectie om de tabel te maken op basis van de kolomnamen (uitgezonderd timestamps --}}
        <x-tmk.section>
            <h1 class="text-xl font-bold text-gray-900">Filter</h1>
            <div class="my-4 flex flex-col sm:flex-row gap-2">
                <div class="flex-1 relative mb-2 sm:mb-0">
                    <x-input id="search" type="text" placeholder="Filter"
                             wire:model.live.debounce.500ms="search"
                             wire:keydown.escape="resetValues"
                             class="w-full shadow-md placeholder-gray-300"/>
                    <button @click="$wire.set('search', '')"
                            class="w-5 absolute right-4 top-3">
                        <x-phosphor-x/>
                    </button>
                </div>
                <div class="flex-1 flex flex-row gap-2 justify-center">
                    <x-tmk.form.switch wire:model.live="showToday"
                                       wire:click="toggleShowToday"
                                       id="showToday"
                                       text-off="Alle data"
                                       color-off="bg-lime-100"
                                       text-on="Vandaag"
                                       color-on="text-white bg-blue-600"
                                       class="w-20 h-auto"/>
                    <x-button wire:click="resetIsNew" class="bg-gray-200 text-gray-800 {{ empty($new_entries) ? 'disabled' : '' }}">Bevestig nieuwe reservaties
                    </x-button>
                    <a href="/reserveren" class="
            self-stretch w-full h-full flex justify-center items-center
            bg-green-500 flex-1
            ">Reservatie toevoegen
                    </a>
                </div>
            </div>
        </x-tmk.section>


        @if(!empty($new_entries))
            <x-tmk.section>
                <h1 class="text-xl font-bold text-gray-900">Nieuwe reserveringen</h1>
                <table class="min-w-full border border-gray-300">
                    <thead>
                    <tr class="bg-gray-100 text-gray-700 [&>th]:p-2">
                        @foreach ($columns as $column)
                            <x-tmk.sort-table-header columnName="{{ $column }}" orderBy="{{ $orderBy }}"
                                                     orderAsc="{{ $orderAsc }}"/>
                        @endforeach
                        @if (!empty($new_entries))
                            <th>
                                Menukeuze
                            </th>
                            <th id="actions">Bewerk</th>
                        @endif
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($new_entries as $line)
                        <tr class="border-t border-gray-300 bg-amber-200" wire:key="{{ $line->id }}">
                            @foreach($columns as $column)
                                @if($column === 'picture_path')
                                    <td class="px-2">
                                        <a href="{{ route('admin.collectionpictures', $line->id) }}">
                                            @if(Storage::disk('public')->exists('collectionpictures/' . $line->picture_path))
                                                <img
                                                    src="{{ asset('storage/collectionpictures/' . $line->$column) . "?v=" . time() }}"
                                                    alt="{{ $line->$column }}"
                                                    class="my-2 border object-cover w-12 h-12 aspect-w-1 aspect-h-1"/>
                                            @else
                                                <img src="{{ asset('storage/collectionpictures/placeholder.png') }}"
                                                     alt="{{ $line->$column }}"
                                                     class="my-2 border object-cover w-12 h-12 aspect-w-1 aspect-h-1"/>
                                            @endif
                                        </a>
                                    </td>
                                @else
                                    <td class="px-2">
                                        {{ ($column === 'is_four_course' || $column === 'active') ? ($line->$column ? 'ja' : 'nee') : \Str::limit($line->$column, 50, '...') }}
                                    </td>
                                @endif
                            @endforeach
                            <td class="">
                                @if( $line['quantity'] > 0)
                                    {{ $line['number_of_person'] - $line['quantity'] }} x standaard menu<br>
                                    {{ $line['quantity'] }} x vegetarisch menu
                                @else
                                    {{ $line['number_of_person'] }} x standaard menu<br>
                                @endif
                            </td>
                            <td>
                                <x-tmk.action-button-group :lineId="$line->id" :lineName="$line->name ?? 'line'"
                                                           @click="showForm = true"/>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </x-tmk.section>
        @endif


        <x-tmk.section class="py-0">
            <table class="min-w-full border border-gray-300">
                <thead>
                <tr class="bg-gray-100 text-gray-700 [&>th]:p-2">
                    @foreach ($columns as $column)
                        <x-tmk.sort-table-header columnName="{{ $column }}" orderBy="{{ $orderBy }}"
                                                 orderAsc="{{ $orderAsc }}"/>
                    @endforeach
                    <!-- Extra kolomkop voor de potlood/vuilbakknop -->
                    @if (!$lines->isEmpty())
                        <th>
                            Menukeuze
                        </th>
                        <th id="actions">Bewerk</th>
                    @endif

                </tr>
                </thead>
                <tbody>
                @foreach($lines as $line)
                    <tr class="border-t border-gray-300"
                        wire:key="{{ $line->id }}">
                        @foreach($columns as $column)
                            @if($column === 'picture_path')
                                <td class="px-2">
                                    <a href="{{ route('admin.collectionpictures', $line->id) }}">
                                        @if(Storage::disk('public')->exists('collectionpictures/' . $line->picture_path))
                                            <img
                                                src="{{ asset('storage/collectionpictures/' . $line->$column) . "?v=" . time() }}"
                                                alt="{{ $line->$column }}"
                                                class="my-2 border object-cover w-12 h-12 aspect-w-1 aspect-h-1"/>
                                        @else
                                            <img src="{{ asset('storage/collectionpictures/placeholder.png') }}"
                                                 alt="{{ $line->$column }}"
                                                 class="my-2 border object-cover w-12 h-12 aspect-w-1 aspect-h-1"/>
                                        @endif
                                    </a>
                                </td>
                            @else
                                <td class="px-2">
                                    {{ ($column === 'is_four_course' || $column === 'active') ? ($line->$column ? 'ja' : 'nee') : \Str::limit($line->$column, 50, '...') }}
                                </td>
                            @endif
                        @endforeach
                        <td class="">
                            @if( $line['quantity'] > 0)
                                {{ $line['number_of_person'] - $line['quantity'] }} x standaard menu<br>
                                {{ $line['quantity'] }} x vegetarisch menu
                            @else
                                {{ $line['number_of_person'] }} x standaard menu<br>
                            @endif
                        </td>
                        <td>
                            <div class="border border-gray-300 rounded-md overflow-hidden m-2 grid grid-cols-2 h-10">

                                <button wire:click="editLine({{ $line['id']  }})" @click="showForm = true"
                                        data-reservatiedate="{{ $line['date']  }}"
                                        data-reservatietijd="{{ $line['time_slot']  }}"
                                        class="text-gray-400 hover:text-sky-100 hover:bg-gray-500 transition border-r border-gray-300">
                                    <x-phosphor-pencil-line-duotone class="inline-block w-5 h-5"/>
                                </button>
                                <button @click="$dispatch('swal:confirm', {
                                        title: 'Verwijder {{ $line['customer_name']  }}?',
                                        cancelButtonText: 'NEE!',
                                        confirmButtonText: 'JA, VERWIJDER DEZE LIJN',
                                        next: {
                                            event: 'delete-line',
                                            params: {
                                                id: {{ $line['id']  }}
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
            </table>

            {{-- No records found --}}
            @if($lines->isEmpty())
                <x-tmk.alert type="danger" class="w-full">
                    Geen reservaties gevonden
                </x-tmk.alert>
            @endif

            <div class="my-4">
                {{ $lines->links() }} {{-- Pagination Links --}}
            </div>
        </x-tmk.section>
    </div>

    {{-- logger --}}
{{--    <x-tmk.livewire-log :lines="$lines" :json="$extracted_data"/>--}}

    <script>

        document.addEventListener('DOMContentLoaded', function () {
            var jsonTableData = JSON.parse(document.getElementById('jsonTableData').value);
            var newLineNumberOfPerson = document.getElementById('newLinenumber_of_person');
            var availableDatesSelect = document.getElementById('newLineDate');
            var availableTimesSelect = document.getElementById('newLineTimeSlot');

            // Function to handle timeslot updates
            function handleCalendarTimeslot() {
                var selectedDate = availableDatesSelect.value;
                var filteredTimeSlots = jsonTableData.filter(function (item) {
                    return item.date === selectedDate && item.remaining_capacity > 0;
                }).map(function (item) {
                    return item.start_time;
                });
                renderTimeslots(filteredTimeSlots);
            }

            // Function to render timeslot options
            function renderTimeslots(timeslots) {
                availableTimesSelect.options.length = 0;
                timeslots.forEach(function (time) {
                    var option = document.createElement('option');
                    option.value = time;
                    option.textContent = time;
                    availableTimesSelect.appendChild(option);
                });
            }

            // Function to handle calendar updates
            function handleCalendarUpdate() {
                var capacity = parseInt(newLineNumberOfPerson.value);
                availableDatesSelect.innerHTML = '<option value="">Selecteer een beschikbare datum</option>';
                var filteredDates = jsonTableData.filter(function (item) {
                    return item.remaining_capacity >= capacity;
                }).map(function (item) {
                    return item.date;
                });

                filteredDates.forEach(function (date) {
                    var option = document.createElement('option');
                    option.value = date;
                    option.textContent = date;
                    availableDatesSelect.appendChild(option);
                });

                renderTimeslots([]);
            }

            // Event listeners
            availableDatesSelect.addEventListener('change', handleCalendarTimeslot);
            newLineNumberOfPerson.addEventListener('input', handleCalendarUpdate);
        });

    </script>
</div>
