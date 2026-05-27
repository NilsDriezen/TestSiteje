<div>
{{--  Select type--}}
    <div class="mb-2 flex items-center">
        <label for="newLineType" class="text-lg font-bold mr-2">
            Type
            <x-form.select id="newLineType"
                           wire:model.live="typeAgenda"
                           wire:change="resetValues"
                           class="ml-2 form-select">

                <option value="" style="color: green;">Selecteer type</option>
                <option value="koekjes">koekjes</option>
                <option value="reservaties">reservaties</option>
            </x-form.select>
        </label>
        <div class="md:pb-4 p-4 pr-0">


            @if ($typeAgenda == 'reservaties')
                <img src="{{ asset('assets/icons/dashboard/reservation.svg') }}" alt="reservaties" class="w-10 h-10">
            @else
                <img src="{{ asset('assets/icons/dashboard/cookies.svg') }}" alt="cookies" class="w-10 h-10">
            @endif
        </div>
    </div>
{{--Modal nieuwe openingstijd--}}
    <x-dialog-modal wire:model="showModal">

        <x-slot name="title">

            <div class="flex items-center justify-between">
                @if($editing)
                    <h2 class="text-lg font-bold">
                        Bewerk openingstijd
                    </h2>
                    <div>

                        @if ($newLineType == 'reservaties')
                            <img src="{{ asset('assets/icons/dashboard/reservation.svg') }}" alt="reservaties"
                                 class="w-10 h-10">
                        @else
                            <img src="{{ asset('assets/icons/dashboard/cookies.svg') }}" alt="cookies"
                                 class="w-10 h-10">
                        @endif
                    </div>
                @else
                    <h2 class="text-lg font-bold">
                        Voeg een nieuwe openingstijd toe
                    </h2>
                    <div>
                        @if ($newLineType == 'reservaties')
                            <img src="{{ asset('assets/icons/dashboard/reservation.svg') }}" alt="reservaties"
                                 class="w-10 h-10">
                        @else
                            <img src="{{ asset('assets/icons/dashboard/cookies.svg') }}" alt="cookies"
                                 class="w-10 h-10">
                        @endif
                    </div>
                @endif
            </div>
        </x-slot>

        <x-slot name="content">
            <div class="">
                @props(['columns', 'editing', 'textareaColumns','hiddenColumns' => ['id', 'day_of_week', 'type', 'date_exception'], 'booleanColumns', 'newLineActive'])
                {{--weekdagen/uitzondering--}}
                <div class="flex">

                    @if ($editing)
                        @if(!$uitzondering)
                            <button wire:click="setUitzondering(false)"
                                    class="px-4 py-2 mt-1 {{ $uitzondering ? 'bg-blue-500 text-white' : 'bg-blue-700 text-white' }} rounded-t-lg">
                                Weekdagen
                            </button>
                        @else
                            <button wire:click="setUitzondering(true)"
                                    class="px-4 ml-0 py-2 mt-1 {{ $uitzondering ? 'bg-blue-700 text-white' : 'bg-blue-500 text-white' }} rounded-t-lg ml-2">
                                Uitzonderingen
                            </button>
                        @endif
                    @else
                        <button wire:click="setUitzondering(false)"
                                class="px-4 py-2 mt-1 {{ $uitzondering ? 'bg-blue-500 text-white' : 'bg-blue-700 text-white' }} rounded-t-lg">
                            Weekdagen
                        </button>
                        <button wire:click="setUitzondering(true)"
                                class="px-4 py-2 mt-1 {{ $uitzondering ? 'bg-blue-700 text-white' : 'bg-blue-500 text-white' }} rounded-t-lg ml-2">
                            Uitzonderingen
                        </button>
                    @endif
                </div>
                <section
                    class="mt-0 rounded-br rounded-tr p-4 bg-white border border-gray-300 overflow-hidden shadow-md my-4">
                    <div class="flex flex-row gap-4 justify-between">
                        <div class="flex flex-col items-start w-full">
                            @foreach ($columns as $column)
                                @if ($uitzondering)
                                    {{--input om de uitzonderingsdatum te selecteren--}}
                                    @if($column === 'date_exception')
                                        <div class="mb-2"><label for="newLine{{ $column }}" class="text-lg font-bold">
                                                {{ ucfirst(__($column)) }}
                                                <input id="newLine{{ $column }}"
                                                       wire:model="newLine{{ ucfirst($column) }}"
                                                       type="date"
                                                       class="ml-2 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                            </label></div>
                                    @endif
                                @else

                                    {{--select om de dagen van de week te selecteren--}}
                                    @if($column === 'day_of_week')
                                        <div class="mb-2"><label for="newLine{{ $column }}" class="text-lg font-bold">
                                                {{ ucfirst(__($column)) }}
                                                <x-form.select id="newLine{{ $column }}"
                                                               wire:model="newLine{{ ucfirst($column) }}"
                                                               class="ml-2 form-select">
                                                    <option value="" style="color: green;">Selecteer weekdag</option>
                                                    <option value="Monday">Maandag</option>
                                                    <option value="Tuesday">Dinsdag</option>
                                                    <option value="Wednesday">Woensdag</option>
                                                    <option value="Thursday">Donderdag</option>
                                                    <option value="Friday">Vrijdag</option>
                                                    <option value="Saturday">Zaterdag</option>
                                                    <option value="Sunday">Zondag</option>
                                                </x-form.select>
                                            </label></div>
                                    @endif
                                @endif
                                @if (!in_array($column, $hiddenColumns)   )
                                    @if (in_array($column, $booleanColumns))
                                        <!-- Hier wordt een checkbox weergegeven -->
                                        @if($uitzondering)
                                            <div class="mb-2"><label for="newLine{{ $column }}"
                                                                     class="text-lg font-bold">
                                                    {{ ucfirst(__($column)) }}
                                                    <input id="newLine{{ $column }}" type="checkbox"
                                                           wire:model="{{ 'newLine' . ucfirst($column) }}"
                                                           wire:click="toggleTimeBasedOnClosed"
                                                           class="ml-2 form-checkbox"
                                                        {{  (${"newLine" . ucfirst($column)} ? 'checked' : '') }}
                                                    >
                                                    {{--                                                @dump($newLineTime_start)--}}
                                                </label></div>
                                        @endif
                                    @else
                                        @if(in_array($column, $textareaColumns))
                                            <!-- Hier wordt een textarea weergegeven -->
                                            <x-tmk.input-or-text type="textarea" id="newLine{{ $column }}"
                                                                 placeholder="Voeg {{ __($column) }} toe"
                                                                 wire:model="{{ $column === 'name' ? 'newLine' : 'newLine' . ucfirst($column) }}"
                                                                 wire:keydown.escape="resetValues()"
                                                                 class="w-full shadow-md placeholder-gray-300 mb-3"></x-tmk.input-or-text>
                                        @else
                                            <div class="mb-2"><label for="newLine{{ $column }}"
                                                                     class="text-lg font-bold">
                                                    {{ ucfirst(__($column)) }}
                                                    <x-tmk.input-or-text id="newLine{{ $column }}"
                                                                         placeholder="Voeg {{ __($column) }} toe"
                                                                         wire:model="{{ $column === 'name' ? 'newLine' : 'newLine' . ucfirst($column) }}"
                                                                         wire:keydown.escape="resetValues()"
                                                                         class="shadow-md placeholder-gray-300 mb-3"
                                                                         type="time"
                                                    ></x-tmk.input-or-text>
                                                </label></div>
                                        @endif
                                    @endif
                                @endif
                                {{--select om type te selecteren--}}
                                @if($column === 'type')

                                    <div class="mb-2"><label for="newLine{{ $column }}" class="text-lg font-bold">
                                            {{ ucfirst(__($column)) }}
                                            <x-form.select id="newLine{{ $column }}"
                                                           wire:model.live="newLineType"
                                                           class="ml-2 form-select"
                                            >

                                                <option
                                                    value="koekjes" {{ $typeAgenda == 'koekjes' ? 'selected' : '' }}>
                                                    koekjes
                                                </option>
                                                <option
                                                    value="reservaties" {{ $typeAgenda == 'reservaties' ? 'selected' : '' }}>
                                                    reservaties
                                                </option>
                                            </x-form.select>
                                        </label></div>

                                @endif

                            @endforeach
                            {{-- inputerrors --}}
                            <div class="px-4 items-start gap-4">
                                @foreach ($columns as $column)
                                    @if ($column !== 'id')
                                        <x-input-error
                                            for="{{ $column === 'name' ? 'newLine' : 'newLine' . ucfirst($column) }}"
                                            class="w-full"/>
                                    @endif
                                @endforeach                    </div>
                        </div>
                        {{-- add or update --}}
                        <div class="flex flex-col w-32 justify-between">
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

                        </div>
                    </div>

                </section>
            </div>
        </x-slot>
        <x-slot name="footer">
            <x-secondary-button wire:click="$toggle('showModal')" wire:loading.attr="disabled">
                Cancel
            </x-secondary-button>
        </x-slot>

    </x-dialog-modal>

{{--Buttons Agenda/Lijstview--}}
    <div class="xl:w-1/2">
        <div class="flex justify-between">
    <span class="relative">
        <button wire:click="setCalendarVisible(true)"
                class=" px-4 py-2 mt-1 {{ $calendarVisible ? 'bg-blue-500 text-white' : 'bg-blue-700 text-white' }} rounded-t-lg ">
            Agenda
        </button>
          <x-phosphor-pencil class="inline-block w-5 h-5 absolute top-0 right-0 text-gray-400"/>
        <button wire:click="setCalendarVisible(false)"
                class="px-4 py-2 mt-1 {{ $calendarVisible ? 'bg-blue-700 text-white' : 'bg-blue-500 text-white' }} rounded-t-lg ml-2">
            Lijst
        </button>
    </span>
            <span>
         <x-button wire:click="openModal" class="justify-end">
             <span class="hidden sm:inline">Voeg een nieuwe openingstijd toe</span>
        <span class="sm:hidden">Nieuw</span>
         </x-button>
     </span>
        </div>
{{--Kalender of lijstview--}}
{{--        Lijstview--}}
        @if(!$calendarVisible)
            <section
                class="mt-0 rounded-br rounded-tr p-4 bg-white border border-gray-300 overflow-hidden shadow-md my-4 flex flex-col ">

                <div class=" flex flex-row gap-2 justify-end ">
                    <x-tmk.form.switch
                        wire:model.live="uitzondering"
                        id="showUitzondering"
                        text-off="weekdag"
                        color-off=" bg-lime-100"
                        text-on="uitzondering"
                        color-on=" bg-red-600 text-white "
                        class="w-auto h-auto rounded-b-none"/>
                </div>

                @php
                    if (!$uitzondering) {
                        $exclude = ['date_exception', 'type'];}
                    else {
                        $exclude = ['day_of_week', 'type'];
                    }
                        $columns = array_diff($columns, $exclude);
                @endphp

                <table
                    class="mt-0 rounded-br rounded-tl p-4 bg-white border border-gray-300 overflow-hidden shadow-md ">
                    <thead>
                    <tr class="bg-gray-100 text-gray-700 [&>th]:p-2">
                        @foreach ($columns as $column)
                            @if ($column === 'closed')
                                <th class="px-2">
                                    <div class="flex">
                                        <span>Open</span>
                                    </div>
                                </th>
                            @else
                                <x-tmk.sort-table-header columnName="{{ $column }}" orderBy="{{ $orderBy }}"
                                                         orderAsc="{{ $orderAsc }}"/>
                            @endif
                        @endforeach
                        <!-- Extra kolomkop voor de potlood/vuilbakknop -->
                        @if (!$lines->isEmpty())
                            <th id="actions">Acties</th>
                        @endif
                    </tr>
                    </thead>
                    <tbody>                @foreach($lines as $line)
                        <tr class="border-t border-gray-300" wire:key="{{ $line->id }}">
                            @foreach($columns as $column)

                                @if(in_array($column, $booleanColumns))

                                    <td class="px-2">
                                        @if ($column === 'closed')
                                            @if(!$line->$column)
                                                <!-- Groen vinkje -->
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="green"
                                                     class="w-6 h-6  transition-transform">
                                                    <path fill-rule="evenodd"
                                                          d="M15.293 5.293a1 1 0 0 1 1.414 1.414l-7 7a1 1 0 0 1-1.414 0l-3-3a1 1 0 0 1 1.414-1.414L8 12.586l6.293-6.293a1 1 0 0 1 1.414 0z"
                                                          clip-rule="evenodd"/>
                                                </svg>
                                            @else
                                                <!-- Rood kruis -->
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="red"

                                                     class="w-6 h-6  transition-transform">
                                                    <path fill-rule="evenodd"
                                                          d="M6.707 6.293a1 1 0 0 1 1.414-1.414L10 8.586l2.879-2.88a1 1 0 1 1 1.414 1.414L11.414 10l2.88 2.879a1 1 0 1 1-1.414 1.414L10 11.414l-2.879 2.88a1 1 0 0 1-1.414-1.414L8.586 10 5.707 7.121a1 1 0 0 1 0-1.414z"
                                                          clip-rule="evenodd"/>
                                                </svg>
                                            @endif
                                        @else
                                            <input type="checkbox" disabled {{ $line->$column ? 'checked' : '' }}>
                                        @endif
                                    </td>
                                @else
                                    @if (in_array($column, ['time_start', 'time_end']))

                             <td class="px-2">{{ date('H:i', strtotime($line->$column)) }}u</td>
                                    @else
                                    <td class="px-2">   {{ __(Str::limit($line->$column, 50, '...')) }}</td>
                                    @endif
                                @endif


                            @endforeach
                            <td>
                                <!-- Potlood/vuilbakknop -->
                                <x-tmk.action-button-group :lineId="$line->id"
                                                           :lineName="$line->name ?? 'openingstijd'"/>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                {{-- No records found --}}
                @if($lines  ->isEmpty())
                    <x-tmk.alert type="danger" class="w-full">
                        Niets gevonden!
                    </x-tmk.alert>
                @endif
                {{-- Pagination Links --}}
                <div class="my-4">
                    {{ $lines->links() }}
                </div>
            </section>
        @else
{{--        Kalenderview--}}
            <section
                class="mt-0 rounded-br rounded-tr p-4 bg-white border border-gray-300 overflow-hidden shadow-md my-4">

                <x-tmk.calendar :monthArray="$monthArray" :openDaysOfMonth="$openDaysOfMonth" :month="$month"
                                :year="$year"
                                :selectedDay="$selectedDay" :timeSlots="$timeSlots" :selected-dayd="$selectedDayd"
                                :openingDays="$openingDays" :typeAgenda="$typeAgenda" class="mt-0"/>
            </section>
        @endif</div>

{{--Log--}}
{{--    <x-tmk.livewire-log :lines="$lines" :month="$month"/>--}}
</div>
