@php

$monthFull = date('F', strtotime($month . '/1')); // outputs 'May'
# bepaal de laatste datum in openingdays
$dates = array_keys($openingDays);
sort($dates);
$lastDay = end($dates);
$lastDayMonth = date('m', strtotime($lastDay));
$lastDayYear = date('Y', strtotime($lastDay));

@endphp


{{--@dump($lastDay);--}}


<section class="p-4 bg-white border border-gray-300 rounded overflow-hidden shadow-md my-4">
    <div class="flex justify-between items-center mb-4">
        <button wire:click.live="prevMonth" id="prevMonthBtn"
                class="px-4 py-2 bg-gray-200 rounded {{ now()->month == $month && now()->year == $year ? 'opacity-50 cursor-not-allowed' : '' }}">
            Vorige maand
        </button>
<h2 class="text-lg font-bold text-center flex items-center justify-center">
    {{ __($monthFull) }} {{$year}}
    <div class="md:pb-4 p-4 pr-0">
        @if ($typeAgenda == 'reservaties')
            <img src="{{ asset('assets/icons/dashboard/reservation.svg') }}" alt="reservaties" class="w-10 h-10">
        @else
        <img src="{{ asset('assets/icons/dashboard/cookies.svg') }}" alt="cookies" class="w-10 h-10">
        @endif
    </div>
</h2>

{{--        @dump($lastDayMonth, $lastDayYear, $month, $year)--}}
        <button wire:click.live="nextMonth" id="nextMonthBtn"
                class="px-4 py-2 bg-gray-200 rounded
            {{ $lastDayMonth == $month && $lastDayYear == $year ? 'opacity-50 cursor-not-allowed' : '' }}"
            {{ $lastDayMonth == $month && $lastDayYear == $year ? 'disabled' : '' }}
        >
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
            <h3 class="text-lg font-semibold mb-2">Beschikbare Tijdslots voor {{ date('d-m-y', strtotime($selectedDay)) }}</h3>            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
         @foreach($timeSlots as $time)
    <div class="bg-white border border-gray-200 rounded-lg p-4 relative text-center">
        <p class="text-gray-600 font-medium">{{ $time == " - " ? 'Geen tijdslot ingevuld' : $time. 'u' }}</p>
    </div>
@endforeach
            </div>
        @endif
    </div>

</section>
