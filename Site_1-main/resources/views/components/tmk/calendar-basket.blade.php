@php

    $monthFull = date('F', strtotime($month . '/1')); // outputs 'May'
    # bepaal de laatste datum in openingdays
    $dates = array_keys($openingDays);
    sort($dates);
    $lastDay = end($dates);
    $lastDayMonth = date('m', strtotime($lastDay));
    $lastDayYear = date('Y', strtotime($lastDay));

@endphp


<section class="p-4 bg-white border border-gray-300 rounded overflow-hidden shadow-md my-4">
    <div class="flex justify-between items-center mb-4">
        <button wire:click="prevMonth" id="prevMonthBtn"
                class="px-4 py-2 bg-gray-200 rounded {{ now()->month == $month && now()->year == $year ? 'opacity-50 cursor-not-allowed' : '' }}">
            Vorige maand
        </button>
        <h2 class="text-lg font-bold text-center">{{ __($monthFull) }} {{$year}}</h2>
        <button wire:click="nextMonth" id="nextMonthBtn"
                class="px-4 py-2 bg-gray-200 rounded {{ $lastDayMonth == $month && $lastDayYear == $year ? 'opacity-50 cursor-not-allowed' : '' }}"
            {{ $lastDayMonth == $month && $lastDayYear == $year ? 'disabled' : '' }}>
            Volgende maand
        </button>
    </div>
    <table class="w-full border-collapse">
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
        <td class="sm:py-4 py-1 px-0 sm:px-6 text-center  calendar-day relative
        @if(in_array($day, $openDaysOfMonth))
         @if($day == $selectedDayd)
            bg-green-500 cursor-pointer hover:bg-green-600 transition-colors

        @else
            bg-green-200 cursor-pointer hover:bg-green-300 transition-colors
        @endif
     @endif
            bg-gray-100
            border border-gray-300"
            data-day="{{ $day }}"
            wire:click="selectDayTime({{ $day }})"
        >
            {{ $day }}

        </td>
    @endforeach
</tr>
        @endforeach
        </tbody>
    </table>

    <div class="mt-4">
        @if($selectedDay)
            <h3 class="text-lg font-semibold mb-2">Beschikbare Tijdslots voor {{ $selectedDay }}</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                @foreach($timeSlots as $time)
                    <div class="bg-white border border-gray-200 rounded-lg p-4 relative"> <!-- Voeg 'relative' toe -->
                        <p class="text-gray-600 font-medium">{{ $time }}</p>
                        <button
                            class="mt-2 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 focus:outline-none focus:bg-blue-600"
                            wire:click="selectTimeSlot('{{ $time }}')"
                        >Selecteer</button>
                        @if(in_array($time, $selectedTimeSlots))
                            <svg class="w-6 h-6 text-green-500 absolute top-0 right-0 mr-2 mt-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif
    </div>



{{--    <script>
        // Voeg een klikgebeurtenis toe aan elke kalenderdag
        var calendarDays = document.querySelectorAll('.calendar-day');
        calendarDays.forEach(function(day) {
            day.addEventListener('click', function() {
                var clickedDay = this.getAttribute('data-day');
                // Zet de geklikte dag om naar een datum in het formaat "YY-m-d"
                var date = new Date();
                var year = date.getFullYear();
                var month = date.getMonth() + 1; // getMonth geeft de maand als 0-indexed terug
                var formattedDate = year + '-' + month + '-' + clickedDay;
                // log de geformatteerde datum
                console.log('Geklikte dag als datum:', formattedDate);
            });
        });



        // Voeg een klikgebeurtenis toe aan de knoppen voor vorige en volgende maand
        document.getElementById('prevMonthBtn').addEventListener('click', function() {
            // Plaats hier de logica om naar de vorige maand te navigeren
            console.log('Naar de vorige maand navigeren');
            // fuctie volgendeMaand oproepen
        });

        document.getElementById('nextMonthBtn').addEventListener('click', function() {
            // Plaats hier de logica om naar de volgende maand te navigeren
            console.log('Naar de volgende maand navigeren');
        });
    </script>--}}
</section>
