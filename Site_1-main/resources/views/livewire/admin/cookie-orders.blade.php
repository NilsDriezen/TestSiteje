<div>
    {{--optie met modal--}}
    <x-dialog-modal wire:model="showModal" maxWidth="2xl">
        <x-slot name="title">

        </x-slot>

        <x-slot name="content">

            <div>
                @props(['columns', 'editing', 'textareaColumns','hiddenColumns' => ['id', 'is_new'], 'booleanColumns', 'newLineActive' ])
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
                                                Op te halen
                                                <input
                                                    id="newLine{{ $column }}" type="checkbox"
                                                    wire:model="{{ 'newLine' . ucfirst($column) }}"
                                                    class="ml-2 form-checkbox rounded border-gray-300 text-indigo-600 shadow-sm"
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

type="{{ $column === 'date_pick_up' ? 'date' : 'text' }}"
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

    <div class="">


        <x-tmk.alert type="info" dismissible="true" class="mt-4">
            <p class="font-bold">Opgelet</p>
            @if ($notPickUpCount > 1)
                <p> Er zijn <b>{{ $notPickUpCount }}</b> oudere bestellingen die nog niet zijn afgehaald.</p>
            @elseif ($notPickUpCount === 1)
                <p> Er is <b>{{ $notPickUpCount }}</b> oudere bestelling die nog niet is afgehaald.</p>
            @else
                <p> Alle oudere bestellingen zijn afgehaald.</p>
            @endif

            @if ($todayCount > 1)
                <p> Vandaag zijn er <b>{{ $todayCount }}</b> afhalingen.</p>
            @elseif ($todayCount === 1)
                <p> Vandaag is er <b>{{ $todayCount }}</b> afhaling.</p>
            @else
                <p> Er zijn <b>geen</b> afhalingen vandaag.</p>
            @endif

            @if ($newCount > 0)

                <div class="flex gap-1.5"><p> Er zijn <b>{{ $newCount }}</b> nieuwe bestellingen.</p>
                    <div
                        class="w-6 h-6 flex-none cursor-pointer"
                        wire:click="resetIsNew">
                        <x-heroicon-s-check-circle
                            data-tippy-content="Markeer als verwerkt"
                            class="border-gray-00 text-green-600"
                        />
                    </div>
                </div>
            @elseif ($newCount === 1)

                <div class="flex gap-1.5"><p> Er is <b>{{ $todayCount }}</b> nieuwe bestelling.</p>
                    <div
                        class="w-6 h-6 flex-none cursor-pointer"
                        wire:click="resetIsNew">
                        <x-heroicon-s-check-circle
                            data-tippy-content="Markeer als verwerkt"
                            class="border-gray-00 text-green-600"
                        />
                    </div>
                </div>
            @else
                <p> Alle bestellingen zijn verwerkt.</p>
            @endif

            @if($activeCount > 1)
                <p> Er zijn in totaal <b>{{ $activeCount }}</b> lopende bestellingen.</p>
            @elseif ($activeCount === 1)
                <p> Er is nog <b>{{ $activeCount }}</b> lopende bestelling.</p>
            @else
                <p> Er zijn <b>geen</b> lopende bestellingen.</p>
            @endif

        </x-tmk.alert>


        {{--filtersectie--}}
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
                        wire:model.live="showToday"
                        wire:change="toggleShowNotNew"
                        id="showToday"
                        text-off="alle data"
                        color-off="bg-lime-100"
                        text-on="Vandaag"
                        color-on="text-white bg-blue-600"
                        class="w-20 h-auto"/>

                    <x-tmk.form.switch
                        wire:model.live="showActive"
                        id="showActive"
                        text-off="Lopende"
                        color-off="bg-lime-100"
                        text-on="Afgehaald"
                        color-on="text-white bg-green-600"
                        class="w-20 h-auto"/>

                    @if ($newCount > 0)
                                 <x-tmk.form.switch
                        wire:model.live="showNotNew"
                        id="showNotNew"
                        text-off="Nieuw"
                        color-off="text-white bg-blue-600"
                        text-on="ALLES"
                        color-on="bg-lime-100"
                        class="w-20 h-auto"/>
                    @endif
                </div>
            </div>


        </x-tmk.section>

        {{--tabel--}}
        <x-tmk.section>
            @if ($showToday)
                <h1 class="text-xl font-bold text-gray-900">Afhalingen vandaag ({{ $todayCount }})</h1>
            @else
                @if ($showActive)
                    <h1 class="text-xl font-bold text-gray-900">Afgehaalde bestellingen</h1>
                @elseif ($showNotNew)
                    <h1 class="text-xl font-bold text-gray-900">Alle bestellingen ({{ $activeCount }})</h1>
                @else
                    <div class="flex gap-1.5"><h1 class="text-xl font-bold text-gray-900">Nieuwe bestellingen
                            ({{ $newCount }})</h1>
                        @if($newCount > 0)
                        <div
                            class="w-6 h-6 flex-none cursor-pointer"
                            wire:click="resetIsNew">
                            <x-heroicon-s-check-circle
                                data-tippy-content="Markeer als verwerkt"
                                class="border-gray-00 text-green-600"
                            />
                        </div>
                        @endif
                    </div>
                @endif

            @endif
            @php
                $exclude = ['id','is_new'];
                $columns = array_diff($columns, $exclude);
            @endphp

            <table class="min-w-full border-gray-300 mt-2 xl:table hidden">
                {{--kolomkoppen--}}
                <thead>
                <tr class="bg-gray-100 text-gray-700 [&>th]:p-2">
                    @foreach ($columns as $column)
                    @if ($column === 'active')
                        <th class="px-2">
                            <div class="flex">
                                <span>Opgehaald</span>
                            </div>
                        </th>
                    @else
                                                <x-tmk.sort-table-header columnName="{{ $column }}" orderBy="{{ $orderBy }}"
                                                                         orderAsc="{{ $orderAsc }}"/>
                    @endif
                    @endforeach
                    <th id="koekjes">
                        <div class="flex">
                            <span>Koekjes</span>
                        </div>
                    </th>
                    <!-- Extra kolomkop voor de potlood/vuilbakknop -->
                    @if (!$lines->isEmpty())
                        <th id="actions">Bewerk</th>
                    @endif
                </tr>
                </thead>
                {{--kolominhoud--}}
                <tbody>
                @foreach($lines as $line)
                    <tr
                        class="border-t {{ $line->is_new ? 'border-gray-00 bg-amber-200' : 'border-gray-300' }} {{ $line->active && \Carbon\Carbon::parse($line->date_pick_up)->format('Y-m-d') < now()->format('Y-m-d') ? 'bg-red-400' : '' }}"
                        wire:key="row_{{ $line->id }}">

                        @foreach($columns as $column)
                                @if(in_array($column, $booleanColumns))
                                    <td class="px-2">
                                        @if ($column === 'active')
                                            @if(!$line->$column)
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
                                    {{--
                                                                        <td class="px-2"
                                                                            @if(strlen($line->$column) > 20) data-tippy-content="{{ $line->$column }}" @endif>
                                                                            {{ Str::limit($line->$column, 20, '...') }}
                                                                        </td>--}}
                                    <td class="px-2"

                                        @if(strlen($line->$column) > 20) data-tippy-content="{{ $line->$column }}" @endif>
                                        @if($column === 'customer_email')
                                            <a class="text-sky-600 underline"
                                               href="mailto:{{ $line->$column }}">{{ Str::limit($line->$column, 20, '...') }}</a>
                                        @else
                                            @if ($column === 'total_price')
                                            €{{ Str::limit($line->$column, 20, '...') }}
                                            @else
                                                {{ Str::limit($line->$column, 20, '...') }}
                                            @endif
                                        @endif
                                    </td>

                                @endif
                        @endforeach
                        <td class="">
                            <ul>
                                @foreach($line['cookie_order_lines'] as $cookieOrderLine)
                                    <li>
                                        {{ $cookieOrderLine['number_of_packs'] }}
                                        x {{ $cookieOrderLine['cookie']['name'] }}
                                    </li>
                                @endforeach
                            </ul>
                        </td>
                        <td>
                            <!-- Potlood/vuilbakknop -->
{{--                            <x-tmk.action-button-group :lineId="$line->id" :lineName="$line->name ?? 'bestelling'"/>--}}
                            <div class="border border-gray-300 rounded-md overflow-hidden m-2 grid  @if($line->active)grid-cols-2 @endif h-10">
                                @if($line->active)
                                <button wire:click="editLine({{ $line->id }})" @click="showForm = true"
                                        class="text-gray-400 hover:text-sky-100 hover:bg-gray-500 transition border-r border-gray-300">
                                    <x-phosphor-pencil-line-duotone class="inline-block w-5 h-5"/>
                                </button>
                                @endif
                                <button @click="$dispatch('swal:confirm', {
        title: 'Verwijder {{ $line->name }}?',
        cancelButtonText: 'NEE!',
        confirmButtonText: 'JA, VERWIJDER',
        next: {
            event: 'delete-line',
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
            </table>


            {{--             Nothing found--}}
            @if($lines  ->isEmpty())
                <x-tmk.alert type="danger" class="w-full">
                    Niets gevonden!
                </x-tmk.alert>
            @endif

            {{--            Pagination Links--}}
            <div class="my-4">
                {{ $lines->links() }}
            </div>

            {{--
         kleine kaartjes
 --}}
            <div class="xl:hidden grid md:grid-cols-2 gap-4 ">
                @foreach($lines as $cookieOrder)
                    <x-tmk.cookie-order-card :cookieOrder="$cookieOrder"/>
                @endforeach
            </div>
        </x-tmk.section>
    </div>

    {{--              logger--}}
{{--    <x-tmk.livewire-log :lines="$lines"/>--}}

</div>



