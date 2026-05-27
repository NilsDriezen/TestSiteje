<div>
    @if(!empty($backorder))
        <x-tmk.alert type="info" dismissible="false" class="mt-4">
            <p class="font-bold">Opgelet</p>
            <p> Volgende koekjes zijn niet in stock en zullen pas later kunnen afgehaald worden.</p>
            <x-tmk.list type="ul" class="mt-4 text-sm font-semibold">
                @foreach($backorder as $item)
                    <li>{{ $item }}</li>
                @endforeach
            </x-tmk.list>
        </x-tmk.alert>
    @endif

    @if(Cart::getTotalQty() === 0)
        {{-- Cart is empty --}}
        <x-tmk.alert type="info" class="w-full">
            Uw mandje is leeg
        </x-tmk.alert>
    @else
        {{-- Cart is not empty --}}

            <x-tmk.section>
                <table class="hidden md:block text-center w-full">
                    <colgroup>
                        <col class="w-14">
                        <col class="w-20">
                        <col class="w-20">
                        <col class="w-max">
                        <col class="w-24">
                    </colgroup>
                    <thead>
                    <tr class="border-b-4 border-gray-300 text-gray-700 [&>th]:p-2">
                        <th>Hoeveelheid</th>
                        <th>Prijs</th>
                        <th></th>
                        <th class="text-left">Soort</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach( Cart::getCookies() as $cookie)
                        <tr class="border-b border-gray-300 align-top [&>td]:py-2">
                            <td>{{ $cookie['qty'] }}</td>
                            <td>€ {{ $cookie['price'] }}</td>
                            <td>
                                <img src="{{ $cookie['picture_path'] }}" alt="{{ $cookie['name'] }}"/>
                            </td>
                            <td class="pl-2 text-left">
                                <p class="text-lg font-medium">{{ $cookie['name'] }}</p>
                                <p class="italic pb-2">{{ $cookie['description'] }}</p>

                            </td>
                            <td>
                                <div class="border border-gray-300 rounded-md overflow-hidden text-sm grid grid-cols-2
                                [&>*]:p-2 hover:[&>*]:bg-sky-500 hover:[&>*]:text-sky-50 [&>*]:cursor-pointer [&>*]:transition">
                                    <p
                                        wire:click="decreaseQty({{ $cookie['id'] }})"
                                        class="border-r border-gray-300">-1</p>
                                    <p
                                        wire:click="increaseQty({{ $cookie['id'] }})
                            ">+1</p>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    <tr>
                        <td colspan="3" class="pt-4 text-left">
                            <x-tmk.form.button
                                wire:click="emptyBasket()"
                                color="danger">
                                Mandje leegmaken
                            </x-tmk.form.button>
                        </td>
                        <td>

                        </td>
                        <td class="pt-4 text-left">
                            <p class="font-medium">Totaal:</p>
                            <p>€ {{ Cart::getTotalPrice() }}</p>
                        </td>
                    </tr>

                        <tr>
                            <td colspan="4"></td>
                            <td class="pt-4 text-left">
                                <x-tmk.form.button color="info" wire:click="checkoutForm()">
                                Bestel
                                </x-tmk.form.button>
                            </td>
                        </tr>

                    </tbody>
                </table>
                <div class="md:hidden">
                    <div class="border border-gray-300 rounded-md overflow-hidden shadow-md">
                        <div class="p-4">
                            <!-- Card content here -->
                            @foreach( Cart::getCookies() as $cookie)
                                <div class="flex items-center justify-between border-b border-gray-300 py-2">
                                    <div>
                                        <p class="font-medium">Hoeveelheid: {{ $cookie['qty'] }}</p>
                                        <p class="font-medium">Prijs: € {{ $cookie['price'] }}</p>
                                        <p class="font-medium">Soort: {{ $cookie['name'] }}</p>
{{--                                        <p class="italic">{{ $cookie['description'] }}</p>--}}
                                    </div>
                                    <div class="border border-gray-300 rounded-md overflow-hidden text-sm grid grid-cols-2 p-2 hover:bg-sky-500 hover:text-sky-50 cursor-pointer transition">
                                        <p wire:click="decreaseQty({{ $cookie['id'] }})" class="border-r border-gray-300">-1</p>
                                        <p wire:click="increaseQty({{ $cookie['id'] }})">+1</p>
                                    </div>
                                </div>
                            @endforeach

                            <!-- Additional content like total price and buttons -->
                            <div class=" pt-4">
                                <div class="text-right">
                                    <p class="font-medium">Total: € {{ Cart::getTotalPrice() }}</p>

                                    <x-tmk.form.button wire:click="emptyBasket()" color="danger" class="font-medium">
                                        Mandje leegmaken
                                    </x-tmk.form.button>
                                    <x-tmk.form.button color="info" wire:click="checkoutForm()">
                                        Bestel
                                    </x-tmk.form.button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </x-tmk.section>
        @endif

{{--Modal checkout--}}
        <x-dialog-modal id="checkoutModal" wire:model.live="showModal">
            <x-slot name="title">
                <h1 class="text-2xl">Bestelling Koekjes - Uw gegevens</h1>
            </x-slot>
            <x-slot name="content">

                <h3 class="text-xl">Uw gegevens</h3>

                <div class="mt-4 space-y-1">
                    <x-label for="name" value="Naam"/>
                    <x-input id="name" type="text" class="block w-full"
                             wire:model.blur="form.name"/>
                    <x-input-error for="form.name"/>
                </div>

                <div class="grid grid-cols-2 gap-4 mt-4">
                    <div class="space-y-1">
                        <x-label for="phoneNumber" value="Telefoonnummer"/>
                        <x-input id="phoneNumber" type="text" class="block w-full"
                                 wire:model.blur="form.phoneNumber"/>
                        <x-input-error for="form.phoneNumber"/>

                    </div>
                    <div class="space-y-1">
                        <x-label for="email" value="Email"/>
                        <x-input id="email" type="text" class="block w-full"
                                 wire:model.blur="form.email"/>
                        <x-input-error for="form.email"/>
                    </div>
                </div>
                <div class="mt-2 col-span-2 ">
                    <x-label for="remarks" value="Opmerkingen:" />
                    <textarea id="remarks" wire:model.live="form.notes" class="block w-full mt-1 rounded-md shadow-sm focus:ring focus:ring-sky-500 focus:border-sky-500"></textarea>

                </div>


                <h3 class="text-xl mt-4">Afhaaldata</h3>

         {{--       juiste code voor de afhaaldata--}}
                <div class="grid grid-cols-2 gap-4 my-2">
{{--                    <!-- Select input voor dagen -->
                    <div class="mt-4">
                        <x-label for="openingDay" value="Kies een dag:" />
                        <select id="openingDay" wire:model.live="form.date" class="block w-full mt-1 rounded-md shadow-sm focus:ring focus:ring-sky-500 focus:border-sky-500">
                            <option value="">-- Selecteer --</option>

                            @foreach($openingDays as $date => $timeSlots)

                                @foreach($timeSlots as $timeSlot)
                                    @if(!in_array($date, $selectedDates))
                                        <option value="{{ $date }}">{{ \Carbon\Carbon::parse($date)->translatedFormat('l, j F Y') }}</option>
                                        @php $selectedDates[] = $date; @endphp
                                    @endif
                                @endforeach
                            @endforeach
                        </select>
                    </div>
                    <!-- Select input voor uren -->
                    <div class="mt-4">
                        <x-label for="openingTime" value="Kies een tijd:" />
                        <select id="openingTime" wire:model.live="form.time" class="block w-full mt-1 rounded-md shadow-sm focus:ring focus:ring-sky-500 focus:border-sky-500">
                            <option value="">-- Selecteer --</option>

                            @if(!is_null($form->date) && isset($openingDays[$form->date]))
                                @foreach($openingDays[$form->date] as $timeSlot)
                         Filter op het type "koekjes" -->
                                    @if(!in_array($timeSlot['time_slot'], $selectedTimes))
                                        <option value="{{ $timeSlot['time_slot'] }}">{{$timeSlot['time_slot'] }}</option>
                                        @php $selectedTimes[] = $timeSlot['time_slot']; @endphp
                                    @endif

                                @endforeach
                            @endif
                        </select>
                    </div>--}}

                    <div class="space-y-1">
                        <x-label for="selectedDay" value="Geselecteerde dag"/>
                      <x-input id="selectedDay" type="text" class="block w-full bg-gray-100" disabled
         wire:model.live="form.date" placeholder="Selecteer een dag in de agenda"/>
                        <x-input-error for="form.date"/>
                    </div>
                    <div class="space-y-1">
                        <x-label for="selectedTime" value="Geselecteerd tijdsslot"/>
                        <x-input id="selectedTime" type="text" class="block w-full bg-gray-100" disabled
                                 wire:model.live="form.time" placeholder="Selecteer een tijdsslot in de agenda"/>
                        <x-input-error for="form.time"/>
                    </div>




</div>
                <x-tmk.calendar-basket :monthArray="$monthArray" :openingDays="$openingDays" :openDaysOfMonth="$openDaysOfMonth" :month="$month" :year="$year" :selectedDay="$selectedDay" :timeSlots="$timeSlots" :selected-time-slots="$selectedTimeSlots" :selected-dayd="$selectedDayd"/>


            </x-slot>
            <x-slot name="footer">
                <x-secondary-button @click="$wire.showModal = false">Annuleer</x-secondary-button>
                <x-tmk.form.button wire:click="checkout()" color="info" class="ml-2">Plaats bestelling</x-tmk.form.button>
            </x-slot>
        </x-dialog-modal>



{{--        <x-tmk.basket-log/>--}}
        {{-- basket-log uitzetten--}}

        {{-- livewire log linksboven --}}

{{--        <x-tmk.livewire-log :monthArray="$monthArray" :openingdays="$openingDays" :openDaysOfMonth="$openDaysOfMonth"/>--}}

</div>
