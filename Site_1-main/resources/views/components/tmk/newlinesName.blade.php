{{--tmk.newlinesName.blade.php--}}
<div>
    @props(['columns', 'editing', 'textareaColumns','hiddenColumns' => [], 'booleanColumns', 'newLineActive' ])

    {{-- Sectie om de nieuwe items (lines) toe te voegen --}}
    <x-tmk.section>
        <div class="flex flex-row gap-4 justify-between">
            <div class="flex flex-col items-start w-full">
                @foreach ($columns as $column)
                    @if (!in_array($column, $hiddenColumns)   )
                        @if (in_array($column, $booleanColumns))
                            <!-- Hier wordt een checkbox weergegeven -->
                            <label for="newLine{{ $column }}" class="text-lg font-bold">
                                {{ ucfirst(__($column)) }}
                                <input id="newLine{{ $column }}" type="checkbox"
                                       wire:model="{{ 'newLine' . ucfirst($column) }}"
                                       class="ml-2 form-checkbox"
                                    {{ ${"newLine" . ucfirst($column)} === 1 ? 'checked' : '' }}
                                >
                            </label>
                        @else

                        @if(in_array($column, $textareaColumns))

                            <!-- Hier wordt een textarea weergegeven -->
                            <x-tmk.input-or-text type="textarea" id="newLine{{ $column }}"
                                                 placeholder="Voeg {{ __($column) }} toe"
                                                 wire:model="{{ $column === 'name' ? 'newLine' : 'newLine' . ucfirst($column) }}"
                                                 wire:keydown.escape="resetValues()"
                                                 class="w-full shadow-md placeholder-gray-300 mb-3"></x-tmk.input-or-text>
                        @else

                            <!-- Hier wordt een inputveld weergegeven -->
                            <x-tmk.input-or-text id="newLine{{ $column }}" placeholder="Voeg {{ __($column) }} toe"
                                                 wire:model="{{ $column === 'name' ? 'newLine' : 'newLine' . ucfirst($column) }}"
                                                 wire:keydown.escape="resetValues()"
                                                 class="w-full shadow-md placeholder-gray-300 mb-3"></x-tmk.input-or-text>


                        @endif
                        @endif
                    @else
                        {{--                        <!-- Verborgen inputveld voor "id" kolom -->--}}
                        {{--                        <input type="hidden" id="newLine{{ $column }}" wire:model="newLine"/>--}}
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

                {{-- Additional slot content --}}
                <div class="mt-4">
                    {{ $slot }}
                </div>
            </div>
        </div>

    </x-tmk.section>
</div>
