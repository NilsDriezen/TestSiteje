
<div class="p-4 border border-gray-300 rounded overflow-hidden shadow-md flex justify-between {{ $cookieOrder->is_new ? 'border-gray-00 bg-amber-200' : 'border-gray-300' }}{{ $cookieOrder->active && \Carbon\Carbon::parse($cookieOrder->date_pick_up)->format('Y-m-d') < now()->format('Y-m-d') ? 'bg-red-400' : '' }}">
<div>
    <div class="flex items-center">
        <strong>Op te halen:</strong>
        @if($cookieOrder->active)
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="green" wire:click="toggleActive({{$cookieOrder->id}})" class="w-6 h-6 cursor-pointer hover:scale-110 transition-transform ml-2">
                <path fill-rule="evenodd" d="M15.293 5.293a1 1 0 0 1 1.414 1.414l-7 7a1 1 0 0 1-1.414 0l-3-3a1 1 0 0 1 1.414-1.414L8 12.586l6.293-6.293a1 1 0 0 1 1.414 0z" clip-rule="evenodd" />
            </svg>

        @else
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="red" wire:click="toggleActive({{$cookieOrder->id}})" class="w-6 h-6 cursor-pointer hover:scale-110 transition-transform ml-2">
                <path fill-rule="evenodd" d="M6.707 6.293a1 1 0 0 1 1.414-1.414L10 8.586l2.879-2.88a1 1 0 1 1 1.414 1.414L11.414 10l2.88 2.879a1 1 0 1 1-1.414 1.414L10 11.414l-2.879 2.88a1 1 0 0 1-1.414-1.414L8.586 10 5.707 7.121a1 1 0 0 1 0-1.414z" clip-rule="evenodd" />
            </svg>
        @endif
    </div>    <strong>Datum van ophalen:</strong> {{ $cookieOrder['date_pick_up'] }}<br>
        <strong>Tijdslot:</strong> {{ $cookieOrder['time_slot'] }}<br>
        <strong>Klantnaam:</strong> {{ $cookieOrder['customer_name'] }}<br>
        <strong>Email:</strong> {{ $cookieOrder['customer_email'] }}<br>
        <strong>Telefoonnummer:</strong> {{ $cookieOrder['customer_phone_number'] }}<br>
    <strong>Opmerking:</strong> <span title="{{ $cookieOrder['comment'] }}">{{ Str::limit($cookieOrder['comment'], 30, '...') }}</span><br>
    <strong>Bestelde koekjes:</strong>
        <ul>
            @foreach($cookieOrder['cookie_order_lines'] as $cookieOrderLine)
                <li>
                    {{ $cookieOrderLine['cookie']['name'] }} - {{ $cookieOrderLine['number_of_packs'] }} x
                </li>
            @endforeach
        </ul>
        <strong>Totaalprijs</strong>: €{{ $cookieOrder['total_price'] }}
    </div>
    <div class="w-20">
        <x-tmk.action-button-group :lineId="$cookieOrder->id" :lineName="$cookieOrder->name ?? 'line'"/>
    </div>
</div>
