<div>

    <x-dialog-modal wire:model="showModal" maxWidth="2xl">
        <x-slot name="title">
        </x-slot>

        <x-slot name="content">
            <div>
                @props(['columns', 'editing', 'textareaColumns','hiddenColumns' => ['id', 'date', 'is_new'], 'booleanColumns'])

                {{-- Sectie om de nieuwe items (lines) toe te voegen --}}
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
                                                    {{ ${"newLine" . ucfirst($column)} === 1 ? 'checked' : '' }}

                                                >
                                            </label></div>
                                    @else

                                        @if ($column === 'message')
                                            <!-- Here is where you want the textarea for the 'message' column -->
                                            <x-tmk.input-or-text type="textarea" id="newLine{{ $column }}" placeholder="Voeg {{ __($column) }} toe"
                                                                 wire:model="{{ $column === 'name' ? 'newLine' : 'newLine' . ucfirst($column) }}"
                                                                 wire:keydown.escape="resetValues()"
                                                                 class="w-full h-32 shadow-md placeholder-gray-300 mb-3"></x-tmk.input-or-text>
                                        @else
                                            <!-- Here is where you want the input field for the 'name' column -->
                                            <x-tmk.input-or-text id="newLine{{ $column }}" placeholder="Voeg {{ __($column) }} toe"
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
                                <x-button wire:click="createOrUpdate" class="flex justify-center bg-red-700 mt-1">Werk bij
                                </x-button>
                            @else
                                <!-- create form elements go here -->
                                <x-button wire:click="createOrUpdate" class="flex justify-center mt-1">Voeg toe</x-button>
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

    @if($lines->isNotEmpty())
        <div class="flex justify-end">
            <x-button wire:click="openModal" class="mt-4 mb-4">Voeg een nieuwe review toe</x-button>
        </div>
    @endif


    <div class="flex justify-between items-center gap-2">
        <div>
            <x-button wire:click="toggleIsNew" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-green-400">Markeer nieuwe Reviews als bekeken.</x-button>
        </div>

        <x-tmk.form.switch
            wire:click="toggleShowOnlyPending"
            id="showOnlyPending"
            :text-off="$showOnlyPending === null ? 'Alle reviews' : ($showOnlyPending ? 'Goedgekeurd' : 'nog niet goedgekeurd')"
            :color-off="$showOnlyPending === null ? 'bg-gray-400' : ($showOnlyPending ? 'bg-green-400' : 'bg-red-600')"
            :text-on="'Switching...'"
            :color-on="'bg-gray-600'"
            class="w-auto h-20"
        />
    </div>





    <!-- DynamicTable.blade.php -->
    <div>

        <!-- Display table on large screens -->
        <div class="hidden sm:block">
            <!-- DynamicTable.blade.php -->
            <div>
                {{-- Sectie om de tabel te maken op basis van de kolomnamen (uitgezonderd timestamps--}}
                <x-tmk.section class="py-0">
                    <x-tmk.filter :lines="$lines"/>

                    <table class="min-w-full border border-gray-300">
                        <!-- Table headers -->
                        <thead>
                        <tr class="bg-gray-100 text-gray-700 [&>th]:p-2">
                            @foreach ($columns as $column)
                                @if ($column !== 'id' && $column !== 'is_new') <!-- verborgen kollom headers -->
                                <x-tmk.sort-table-header columnName="{{ $column }}" orderBy="{{ $orderBy }}" orderAsc="{{ $orderAsc }}"/>
                                @endif
                            @endforeach
                            <!-- Extra kolomkop voor de potlood/vuilbakknop -->
                            @if (!$lines->isEmpty())
                                <th id="actions">Bewerk</th>
                            @endif
                        </tr>
                        </thead>
                        <!-- Table body -->
                        <tbody>
                        @foreach($lines as $line)
                            <tr class="border-t border-gray-300
               @if($line->is_new) bg-green-100
               @elseif(!$line->is_approved) bg-red-100
               @endif"
                                wire:key="{{ $line->id }}">
                                @foreach($columns as $column)
                                    @if($column !== 'id' && $column !== 'is_new') <!-- celwaardes -->
                                    @if(in_array($column, $booleanColumns))
                                        <td class="px-2">
                                            <input type="checkbox" {{ $line->$column ? 'checked' : '' }} wire:change="toggleActive({{$line->id}})">
                                        </td>
                                    @else
                                        <td class="px-2">{{ Str::limit($line->$column, 50, '...') }}</td>
                                    @endif
                                    @endif
                                @endforeach
                                <td>
                                    <!-- Potlood/vuilbakknop -->
                                    <x-tmk.action-button-group :lineId="$line->id" :lineName="$line->name ?? 'line'" wire:click="editLine({{ $line->id }})"/>

                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                    {{-- No records found --}}
                    @if($lines->isEmpty())
                        <x-tmk.alert type="danger" class="w-full">
                            Nothing found!
                        </x-tmk.alert>
                    @endif

                    <div class="my-4">
                        {{ $lines->links() }} {{-- Pagination Links --}}
                    </div>
                </x-tmk.section>
            </div>
        </div>

        <!-- Display cards on smaller screens -->
        <div class="block sm:hidden">
            @foreach($lines as $line)
                <div class="border border-gray-300 mb-4 p-4 mt-4 bg-white">
                    @foreach ($columns as $column)
                        @if ($column !== 'id' && $column !== 'is_new' && $column !== 'is_approved')
                            @if (in_array($column, $booleanColumns))
                                <p><strong>{{ ucfirst(__($column)) }}:</strong> {{ $line->$column ? 'Yes' : 'No' }}</p>
                            @else
                                <p><strong>{{ ucfirst(__($column)) }}:</strong> {{ $line->$column }}</p>
                            @endif
                        @endif
                    @endforeach
                    <!-- Toggle is_approved -->
                    <div class="flex items-center">
                        <input type="checkbox" {{ $line->is_approved ? 'checked' : '' }} wire:change="toggleApproved({{ $line->id }})">
                        <label class="ml-2">Is goedgekeurd</label>
                    </div>
                    <!-- Potlood/vuilbakknop -->
                    <x-tmk.action-button-group :lineId="$line->id" :lineName="$line->name ?? 'line'" wire:click="editLine({{ $line->id }})"/>
                </div>
            @endforeach
                <div class="my-4 flex justify-between">
                    @if (!$lines->onFirstPage())
                        <a href="{{ $lines->previousPageUrl() }}" class="px-4 py-2 border rounded-l hover:bg-blue-500 hover:text-white">Vorige</a>
                    @else
                        <span></span> <!-- Empty span to keep alignment -->
                    @endif

                    @if ($lines->hasMorePages())
                        <a href="{{ $lines->nextPageUrl() }}" class="px-4 py-2 border rounded-r hover:bg-blue-500 hover:text-white">Volgende</a>
                    @else
                        <span></span> <!-- Empty span to keep alignment -->
                    @endif
                </div>
        </div>



    </div>

</div>
