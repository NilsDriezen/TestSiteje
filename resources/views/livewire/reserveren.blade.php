<div x-data="{ newLineNumberOfPerson: '', newLineTimeSlot: '' }">
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
                        $available_dates[$date] = $date;
                    }
                }
            }
        }
    @endphp

    <input type="hidden" id="jsonTableData" value="{{ json_encode($extracted_data) }}">

    <!-- Input field to enter capacity -->


    <x-tmk.input-or-text id="newLineNumberOfPerson" placeholder="Met hoeveel personen komen jullie eten?"
                         x-model="newLineNumberOfPerson"
                         wire:model="newLineNumberOfPerson"
                         class="w-full shadow-md placeholder-gray-300 mb-3"


    ></x-tmk.input-or-text>
    <p class="text-sm text-gray-500 mb-2">Na het ingeven van het aantal personen vind je hieronder de beschikbare datums om te reserveren:</p>
    @php
        $monthFull = date('F', strtotime($month . '/1'));
        $monthDigit = date('m', strtotime($month . '/1'));
    @endphp

        <!-- Calendar section -->
    <section x-show="newLineNumberOfPerson" class="p-4 bg-white border border-gray-300 rounded overflow-hidden shadow-md my-4">
        <div class="flex justify-between items-center mb-4">
            <button wire:click="prevMonth" id="prevMonthBtn" class="px-4 py-2 bg-gray-200 rounded">Vorige maand</button>
            <h2 class="text-lg font-bold text-center">{{ __($monthFull) }} {{$year}}</h2>
            <button wire:click="nextMonth" id="nextMonthBtn" class="px-4 py-2 bg-gray-200 rounded">Volgende maand</button>
        </div>
        <table class="w-full border-collapse calendar">
            <thead>
            <tr>
                <th class="py-1 sm:py-2 px-1 sm:px-4 bg-gray-100 border border-gray-300">Ma</th>
                <th class="py-1 sm:py-2 px-1 sm:px-4 bg-gray-100 border border-gray-300">Di</th>
                <th class="py-1 sm:py-2 px-1 sm:px-4 bg-gray-100 border border-gray-300">Wo</th>
                <th class="py-1 sm:py-2 px-1 sm:px-4 bg-gray-100 border border-gray-300">Do</th>
                <th class="py-1 sm:py-2 px-1 sm:px-4 bg-gray-100 border border-gray-300">Vr</th>
                <th class="py-1 sm:py-2 px-1 sm:px-4 bg-gray-100 border border-gray-300">Za</th>
                <th class="py-1 sm:py-2 px-1 sm:px-4 bg-gray-100 border border-gray-300">Zo</th>
            </tr>
            </thead>
            <tbody>
            @foreach($monthArray as $week)
                <tr>
                    @foreach($week as $day)
                        <td class="sm:py-4 py-1 px-0 sm:px-6 text-center calendar-day relative bg-gray-100 border border-gray-300 cursor-pointer"
                            data-day="{{ $day }}"
                            data-date="{{$year}}-{{$monthDigit}}-{{$day}}"
                            id="{{$year}}-{{$monthDigit}}-{{$day}}"
                        >
                            {{ $day }}
                        </td>
                    @endforeach
                </tr>
            @endforeach
            </tbody>
        </table>

        <div class="mt-4" id="timeslotContainer" style="display:none"></div>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                var jsonTableData = JSON.parse(document.getElementById('jsonTableData').value);
                var newLineNumberOfPerson = document.getElementById('newLineNumberOfPerson');
                var availableDatesSelect = document.getElementById('newLineDate');
                var availableTimesSelect = document.getElementById('newLineTimeSlot');
                var timeslotContainer = document.getElementById('timeslotContainer');
                var selectedDayElement = null;

                // Function to render timeslot buttons
                function renderTimeslots(timeslots) {
                    timeslotContainer.innerHTML = '<h3 class="text-lg font-semibold mb-2">Beschikbare Tijdslots</h3>';
                    availableTimesSelect.innerHTML = '<option value="">Selecteer een beschikbaar tijdslot</option>';
                    var gridDiv = document.createElement('div');
                    gridDiv.className = 'grid grid-cols-1 md:grid-cols-3 gap-4';

                    timeslots.forEach(function (time) {
                        var timeDiv = document.createElement('div');
                        timeDiv.className = 'bg-white border border-gray-200 rounded-lg p-4 relative';
                        var timeP = document.createElement('p');
                        timeP.className = 'text-gray-600 font-medium';
                        timeP.textContent = time;

                        var timeButton = document.createElement('button');
                        timeButton.className = 'mt-2 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 focus:outline-none focus:bg-blue-600';
                        timeButton.setAttribute('data-time', time);
                        timeButton.textContent = 'Selecteer';
                        timeButton.addEventListener('click', function () {
                            var selectedTime = this.getAttribute('data-time');
                            document.querySelector("#newLineTimeSlot").value = selectedTime;

                        });

                        timeDiv.appendChild(timeP);
                        timeDiv.appendChild(timeButton);
                        gridDiv.appendChild(timeDiv);

                        var option = document.createElement('option');
                        option.value = time;
                        option.textContent = time;
                        availableTimesSelect.appendChild(option);
                    });
                    timeslotContainer.appendChild(gridDiv);
                }

                // Function to change the background color of elements based on dates
                function changeBackgroundColor() {
                    var calendarDayElements = document.querySelectorAll('.calendar-day');
                    calendarDayElements.forEach(function (element) {
                        element.classList.remove('bg-green-300');
                        element.classList.add('disabled');
                    });

                    var capacity = parseInt(newLineNumberOfPerson.value);
                    var filteredDates = Object.keys(@json($available_dates)).filter(function (date) {
                        return jsonTableData.some(function (item) {
                            return item.date === date && item.remaining_capacity >= capacity;
                        });
                    });

                    filteredDates.forEach(function (date) {
                        var element = document.getElementById(date);
                        if (element) {
                            element.classList.add('bg-green-300');
                            element.classList.remove('disabled');
                        }
                    });
                }

                // Function to handle calendar updates
                function handleCalendarUpdate() {
                    var capacity = parseInt(newLineNumberOfPerson.value);
                    availableDatesSelect.innerHTML = '<option value="">Selecteer een beschikbare datum</option>';

                    var filteredDates = Object.keys(@json($available_dates)).filter(function (date) {
                        return jsonTableData.some(function (item) {
                            return item.date === date && item.remaining_capacity >= capacity;
                        });
                    });

                    filteredDates.forEach(function (date) {
                        var option = document.createElement('option');
                        option.value = date;
                        option.textContent = date;
                        availableDatesSelect.appendChild(option);
                    });

                    // Call the function to change background color
                    changeBackgroundColor();
                }

                // Event listener for calendar days
                function attachCalendarDayListeners() {
                    var calendarDays = document.querySelectorAll('.calendar-day');
                    calendarDays.forEach(function (day) {
                        day.addEventListener('click', function () {
                            if (this.classList.contains('disabled')) {
                                return;
                            }
                            var selectedDate = this.getAttribute('data-date');
                            availableDatesSelect.value = selectedDate;
                            availableDatesSelect.dispatchEvent(new Event('change'));

                            // Update selected day background color
                            if (selectedDayElement) {
                                selectedDayElement.classList.remove('bg-green-400');
                                selectedDayElement.classList.add('bg-gray-100');
                            }
                            this.classList.remove('bg-gray-100');
                            this.classList.add('bg-green-400');
                            selectedDayElement = this;
                        });
                    });
                }

                // Event listener for available dates select input
                availableDatesSelect.addEventListener('change', function () {
                    var selectedDate = this.value;
                    var filteredTimeSlots = jsonTableData.filter(function (item) {
                        return item.date === selectedDate && item.remaining_capacity > 0;
                    }).map(function (item) {
                        return item.start_time;
                    });
                    renderTimeslots(filteredTimeSlots);
                });

                // Event listener for number of persons input field
                newLineNumberOfPerson.addEventListener('input', handleCalendarUpdate);

                // Create a MutationObserver to detect changes in the .calendar table
                const calendarTable = document.querySelector('.calendar');
                const observer = new MutationObserver(function (mutationsList, observer) {
                    for (let mutation of mutationsList) {
                        if (mutation.type === 'childList') {
                            handleCalendarUpdate();
                            attachCalendarDayListeners();
                        }
                    }
                });

                // Start observing the calendar table for changes
                observer.observe(calendarTable, { childList: true, subtree: true });

                // Initial setup
                handleCalendarUpdate();
                attachCalendarDayListeners();
            });
        </script>

    </section>

    <!-- Select form for available dates -->
    <x-form.select style="display:none" name="available_dates" id="newLineDate" wire:model="newLineDate"  class="w-full shadow-md placeholder-gray-300 mb-3">
        <option value="">Selecteer een beschikbare datum</option>
        @foreach ($available_dates as $date)
            <option value="{{ $date }}">{{ $date }}</option>
        @endforeach
    </x-form.select>

    <!-- Select form for available time slots -->
    <x-form.select x-show="newLineNumberOfPerson" name="available_time_slots" wire:model="newLineTimeSlot" id="newLineTimeSlot" x-model="newLineTimeSlot" class="w-full shadow-md placeholder-gray-300 mb-10 mt-5">
        <option value="">Selecteer een beschikbaar tijdslot</option>
    </x-form.select>


        <x-tmk.input-or-text id="newLineCustomerName" placeholder="Naam"
                             wire:model="newLineCustomerName"
                             class="w-full shadow-md placeholder-gray-300 mb-3"
                             x-show="newLineTimeSlot"
        ></x-tmk.input-or-text>

        <x-tmk.input-or-text id="newLineCustomerPhoneNumber"
                             placeholder="Telefoonnummmer (0400 12 34 56)"
                             wire:model="newLineCustomerPhoneNumber"
                             class="w-full shadow-md placeholder-gray-300 mb-3"
                             x-show="newLineTimeSlot"
        ></x-tmk.input-or-text>
    <p class="text-sm text-gray-500 mb-2" x-show="newLineTimeSlot">Voer een geldig telefoonnummer in met 10 tot 20 cijfers. Het mag spaties, streepjes en een optioneel '+'-teken bevatten.</p>



    <x-tmk.input-or-text id="newLineCustomerEmail" placeholder="E-mailadres"
                             wire:model="newLineCustomerEmail"
                             class="w-full shadow-md placeholder-gray-300 mt-3"
                             x-show="newLineTimeSlot"
        ></x-tmk.input-or-text>



        <!-- Textarea for the message attribute -->
        <x-tmk.input-or-text type="textarea" id="newLineComment"
                             placeholder="Opmerkingen"
                             wire:model="newLineComment"
                             class="w-full shadow-md placeholder-gray-300 mt-3"
                             x-show="newLineTimeSlot"></x-tmk.input-or-text>

        <x-tmk.input-or-text id="newLineQuantity" placeholder="Hoeveel personen wensen het vegetarisch menu?"
                             wire:model="newLineQuantity"
                             class="w-full shadow-md placeholder-gray-300 mt-2"
                             x-show="newLineTimeSlot"
        ></x-tmk.input-or-text>

        <div class="form-check mt-3 mb-1" x-show="newLineTimeSlot">
            <input type="checkbox" class="form-check-input" id="fourcourseCheckbox" wire:model="newLineIsFourCourse">
            <label class="form-check-label" for="fourcourseCheckbox">Ik en mijn gezelschap nemen een 4-gangenmenu i.p.v. een 3-gangenmenu</label>
        </div>

        <!-- Create button -->
        <x-button wire:click="createOrUpdateReservation" class="flex justify-center mt-5 mb-5"  x-show="newLineTimeSlot">Reserveren</x-button>
    </template>
    <x-tmk.errorbag></x-tmk.errorbag>

    {{--<x-tmk.livewire-log :time="$newLineTimeSlot" :date="$newLineDate" :name="$newLineCustomerName" />--}}
</div>
