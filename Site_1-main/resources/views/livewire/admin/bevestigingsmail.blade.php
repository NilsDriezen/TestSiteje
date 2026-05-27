<div>
    <div class="hidden sm:block">
        @props(['columns', 'editing', 'textareaColumns','hiddenColumns' => ['id'], 'booleanColumns', 'newLineActive' ])


        {{-- Section to add new items (lines) --}}
        @if ($editing)

            <x-tmk.section>
                <div class="flex flex-row gap-4 justify-between">
                    <div class="flex flex-col items-start w-full">
                        <!-- Display Type as text -->
                        <div class="font-bold pb-2">Type: {{ $newLineType }}</div>

                        @foreach ($columns as $column)
                            @if (!in_array($column, $hiddenColumns) && $column !== 'type')
                                @if(in_array($column, $textareaColumns))
                                    <!-- Display a label -->
                                    <label for="newLine{{ $column }}" class="block font-medium text-sm text-gray-700 underline mb-0.5">{{ ucfirst(__($column)) }}</label>
                                    <!-- Display a textarea -->
                                    <x-tmk.input-or-text type="textarea" id="newLine{{ $column }}"
                                                         placeholder="Voeg {{ __($column) }}"
                                                         wire:model="{{ $column === 'name' ? 'newLine' : 'newLine' . ucfirst($column) }}"
                                                         wire:keydown.escape="resetValues()"
                                                         class="w-full shadow-md placeholder-gray-300 mb-3"
                                                         rows="10"
                                    ></x-tmk.input-or-text>
                                @else
                                    <!-- Display a label -->
                                    <label for="newLine{{ $column }}" class="block font-medium text-sm text-gray-700">{{ ucfirst(__($column)) }}</label>
                                    <!-- Display an input field -->
                                    <x-tmk.input-or-text type="textarea" id="newLine{{ $column }}" placeholder="Voeg {{ __($column) }}"
                                                         wire:model="{{ $column === 'name' ? 'newLine' : 'newLine' . ucfirst($column) }}"
                                                         wire:keydown.escape="resetValues()"
                                                         class="w-full shadow-md placeholder-gray-300 mb-3"></x-tmk.input-or-text>
                                @endif
                            @else
                                <!-- Hidden input field for "id" column -->
                                <!-- <input type="hidden" id="newLine{{ $column }}" wire:model="newLine"/> -->
                            @endif
                        @endforeach


                        {{-- Input errors --}}
                        <div class="px-4 items-start gap-4">
                            @foreach ($columns as $column)
                                @if ($column !== 'id')
                                    <x-input-error for="{{ $column === 'name' ? 'newLine' : 'newLine' . ucfirst($column) }}"
                                                   class="w-full"/>
                                @endif
                            @endforeach
                        </div>
                    </div>
                    {{-- Add or update --}}
                    <div class="flex flex-col w-32">
                        @if ($editing)
                            <!-- Edit form elements -->
                            <x-button wire:click="createOrUpdate" class="flex justify-center bg-red-700 mt-1">Update</x-button>
                        @else
                            <!-- Create form elements -->
                            <x-button wire:click="createOrUpdate" class="flex justify-center mt-1">Add</x-button>
                        @endif
                    </div>
                </div>
            </x-tmk.section>
        @endif

    </div>

    <div class="block sm:hidden">
        @props(['columns', 'editing', 'textareaColumns','hiddenColumns' => ['id'], 'booleanColumns', 'newLineActive' ])


        {{-- Section to add new items (lines) --}}
        @if ($editing)

            <x-tmk.section>
                <div class="flex flex-row gap-4 justify-between">
                    <div class="flex flex-col items-start w-full">
                        <!-- Display Type as text -->
                        <div class="font-bold pb-2">Type: {{ $newLineType }}</div>

                        @foreach ($columns as $column)
                            @if (!in_array($column, $hiddenColumns) && $column !== 'type')
                                @if(in_array($column, $textareaColumns))
                                    <!-- Display a label -->
                                    <label for="newLine{{ $column }}" class="block font-medium text-sm text-gray-700 underline mb-0.5">{{ ucfirst(__($column)) }}</label>
                                    <!-- Display a textarea -->
                                    <x-tmk.input-or-text type="textarea" id="newLine{{ $column }}"
                                                         placeholder="Voeg {{ __($column) }}"
                                                         wire:model="{{ $column === 'name' ? 'newLine' : 'newLine' . ucfirst($column) }}"
                                                         wire:keydown.escape="resetValues()"
                                                         class="w-full shadow-md placeholder-gray-300 mb-3"
                                                         rows="10"
                                    ></x-tmk.input-or-text>
                                @else
                                    <!-- Display a label -->
                                    <label for="newLine{{ $column }}" class="block font-medium text-sm text-gray-700">{{ ucfirst(__($column)) }}</label>
                                    <!-- Display an input field -->
                                    <x-tmk.input-or-text type="textarea" id="newLine{{ $column }}" placeholder="Voeg {{ __($column) }}"
                                                         wire:model="{{ $column === 'name' ? 'newLine' : 'newLine' . ucfirst($column) }}"
                                                         wire:keydown.escape="resetValues()"
                                                         class="w-full shadow-md placeholder-gray-300 mb-3"></x-tmk.input-or-text>
                                @endif
                            @else
                                <!-- Hidden input field for "id" column -->
                                <!-- <input type="hidden" id="newLine{{ $column }}" wire:model="newLine"/> -->
                            @endif
                        @endforeach


                        {{-- Input errors --}}
                        <div class="px-4 items-start gap-4">
                            @foreach ($columns as $column)
                                @if ($column !== 'id')
                                    <x-input-error for="{{ $column === 'name' ? 'newLine' : 'newLine' . ucfirst($column) }}"
                                                   class="w-full"/>
                                @endif
                            @endforeach
                        </div>
                    </div>

                </div>
                {{-- Add or update --}}
                <div class="flex flex-col w-32">
                    <x-button wire:click="createOrUpdate" class="flex justify-center bg-red-700 mt-1">Update</x-button>
                </div>
            </x-tmk.section>
        @endif

    </div>

    <div class="hidden sm:block">


        <!-- DynamicTable.blade.php -->
        <div>
            {{-- Section to create the table based on the column names (excluding timestamps) --}}
            <x-tmk.section>

                <table class="min-w-full border border-gray-300">
                    <thead>
                    <tr class="bg-gray-100 text-gray-700 [&>th]:p-2">
                        @foreach ($columns as $column)
                            @if ($column !== 'id')

                            <x-tmk.sort-table-header columnName="{{ $column }}" orderBy="{{ $orderBy }}" orderAsc="{{ $orderAsc }}"/>
                            @endif
                        @endforeach
                        <!-- Additional column header for edit/delete buttons -->
                        @if (!$lines->isEmpty())
                            <th id="actions">Bewerk</th>
                        @endif
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($lines as $line)
                        <tr class="border-t border-gray-300" wire:key="{{ $line->id }}">
                            @foreach($columns as $column)
                                @if ($column !== 'id')
                                    <td class="px-2" title="{{$line->$column}}">   {{__(Str::limit($line->$column, 50, '...')) }}</td>

                                @endif
                            @endforeach


                            <!-- Action buttons -->
                            <td class="flex items-center justify-center">
                                <div class="border border-gray-300 rounded-md overflow-hidden m-2 w-10 h-10 flex items-center justify-center">
                                    <button wire:click="editLine({{ $lineId = $line->id }})"
                                            class="text-gray-400 hover:text-sky-100 hover:bg-gray-500 transition">
                                        <x-phosphor-pencil-line-duotone class="inline-block w-5 h-5"/>
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
                        Nothing found!
                    </x-tmk.alert>
                @endif

                <div class="my-4">
                    {{ $lines->links() }} {{-- Pagination Links --}}
                </div>
            </x-tmk.section>
        </div>
    </div>

    <div class="block sm:hidden">
        @foreach($lines as $line)
            <div class="border border-gray-300 mb-4 p-4 mt-4 bg-white">

                <!-- Include all other relevant fields -->
                @foreach ($columns as $column)
                    @if ($column !== 'id')
                        @if (in_array($column, $booleanColumns))
                            <p><strong>{{ ucfirst(__($column)) }}:</strong> {{ $line->$column ? 'Yes' : 'No' }}</p>
                        @else
                            <p><strong>{{ ucfirst(__($column)) }}:</strong> {!! nl2br(e($line->$column)) !!}</p>                        @endif
                    @endif
                @endforeach
                <!-- Potlood/vuilbakknop -->
                <td class="flex items-center justify-center">
                    <div class="border border-gray-300 rounded-md overflow-hidden m-2 w-10 h-10 flex items-center justify-center">
                        <button wire:click="editLine({{ $lineId = $line->id }})"
                                class="text-gray-400 hover:text-sky-100 hover:bg-gray-500 transition">
                            <x-phosphor-pencil-line-duotone class="inline-block w-5 h-5"/>
                        </button>
                    </div>
                </td>            </div>
        @endforeach
    </div>

</div>
