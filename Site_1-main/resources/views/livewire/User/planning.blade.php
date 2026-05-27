<div>
    <!-- Reservaties -->
    <h2>Reservaties</h2>
    <x-tmk.section>
        <div class="overflow-x-auto">
            <table class="min-w-full border border-gray-300">
                <thead>
                <tr class="bg-gray-100 text-gray-700">
                    @foreach ($reservationColumns as $column)
                        @unless(in_array($column, $excludeReservation))
                            <th>
                                {{ __($column) }}
                            </th>
                        @endunless
                    @endforeach
                </tr>
                </thead>
                <tbody>
                @foreach($reservations as $reservation)
                    <tr class="border-t border-gray-300" wire:key="{{ $reservation->id }}">
                        @foreach($reservationColumns as $column)
                            @unless(in_array($column, $excludeReservation))
                                <td class="px-2">{{ Str::limit($reservation->$column, 50, '...') }}</td>
                            @endunless
                        @endforeach
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </x-tmk.section>

    <!-- Koekjes bestellingen -->
    <h2>Koekjes bestellingen</h2>
    <x-tmk.section>
        <div class="overflow-x-auto">
            <table class="min-w-full border border-gray-300">
                <thead>
                <tr class="bg-gray-100 text-gray-700">
                    @foreach ($cookieColumns as $column)
                        @unless(in_array($column, $excludeCookie))
                            <th>
                                {{ __($column) }}
                            </th>
                        @endunless
                    @endforeach
                </tr>
                </thead>
                <tbody>
                @foreach($cookieOrders as $cookieOrder)
                    <tr class="border-t border-gray-300" wire:key="{{ $cookieOrder->id }}">
                        @foreach($cookieColumns as $column)
                            @unless(in_array($column, $excludeCookie))
                                <td class="px-2">{{ Str::limit($cookieOrder->$column, 50, '...') }}</td>
                            @endunless
                        @endforeach
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </x-tmk.section>
</div>
