<div>
    <!--  Big edit -->
    <div class="hidden sm:block">
        @props(['columns', 'editing', 'textareaColumns','hiddenColumns' => ['id', 'picture_1', 'picture_2',], 'booleanColumns', 'newLineActive' ])

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
                                <!-- Display a textarea -->
                                <x-tmk.input-or-text type="textarea" id="newLine{{ $column }}"
                                                     placeholder="Voeg {{ __($column) }}"
                                                     wire:model="{{ $column === 'name' ? 'newLine' : 'newLine' . ucfirst($column) }}"
                                                     wire:keydown.escape="resetValues()"
                                                     class="w-full shadow-md placeholder-gray-300 mb-3"
                                                     rows="10"
                                ></x-tmk.input-or-text>
                            @else
                                <!-- Display an input field -->
                                <x-tmk.input-or-text id="newLine{{ $column }}" placeholder="Voeg {{ __($column) }}"
                                                     wire:model="{{ $column === 'name' ? 'newLine' : 'newLine' . ucfirst($column) }}"
                                                     wire:keydown.escape="resetValues()"
                                                     class="w-full shadow-md placeholder-gray-300 mb-3"></x-tmk.input-or-text>
                            @endif
                        @endif
                    @endforeach



                    @if(in_array($newLineType, $this->imageUploadable))
                    <div class="flex">
                        <div class="flex flex-col mr-4">
                            <label for="newImage" class="block text-sm font-medium text-gray-700">Foto 1</label>
                            <div class="mt-1 flex items-center">
                                <span class="inline-block h-12 w-12 rounded-full overflow-hidden bg-gray-100">
                                    @if($newImage)
                                        <!-- Display newly uploaded image -->
                                        <img src="{{ $newImage->temporaryUrl() }}" alt="New Picture 1" class="object-cover w-full h-full">
                                    @elseif($editing && $newLinePicture_1)
                                        <!-- Display existing image when editing -->
                                        <img src="{{ asset('storage/websitepictures/' . basename($newLinePicture_1)) }}" alt="Existing Picture 1" class="object-cover w-full h-full">
                                    @endif
                                </span>
                                <input id="newImage" name="newImage" type="file" wire:model="newImage" class="ml-5">
                            </div>
                        </div>

                        <div class="flex flex-col">
                            <label for="newImage2" class="block text-sm font-medium text-gray-700">Foto 2</label>
                            <div class="mt-1 flex items-center">
                                <span class="inline-block h-12 w-12 rounded-full overflow-hidden bg-gray-100">
                                    @if($newImage2)
                                        <!-- Display newly uploaded image -->
                                        <img src="{{ $newImage2->temporaryUrl() }}" alt="New Picture 2" class="object-cover w-full h-full">
                                    @elseif($editing && $newLinePicture_2)
                                        <!-- Display existing image when editing -->
                                        <img src="{{ asset('storage/websitepictures/' . basename($newLinePicture_2)) }}" alt="Existing Picture 2" class="object-cover w-full h-full">
                                    @endif
                                </span>
                                <input id="newImage2" name="newImage2" type="file" wire:model="newImage2" class="ml-5">
                            </div>
                        </div>
                    </div>
                    @endif

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

    <!--  Mobile edit -->
    <div class="block sm:hidden">
        @if ($editing)
            <x-tmk.section>
                <div class="flex flex-col gap-4 justify-between">
                    <div class="flex flex-col items-start">
                        <!-- Display Type as text -->
                        <div class="font-bold pb-2">Type: {{ $newLineType }}</div>

                        @foreach ($columns as $column)
                            @if (!in_array($column, $hiddenColumns) && $column !== 'type' && $column !== 'picture_1' && $column !== 'picture_2')
                                @if(in_array($column, $textareaColumns))
                                    <!-- Display a textarea -->
                                    <x-tmk.input-or-text type="textarea" id="newLine{{ $column }}"
                                                         placeholder="Voeg {{ __($column) }}"
                                                         wire:model="{{ $column === 'name' ? 'newLine' : 'newLine' . ucfirst($column) }}"
                                                         wire:keydown.escape="resetValues()"
                                                         class="w-full shadow-md placeholder-gray-300 mb-3"
                                                         rows="10"
                                    ></x-tmk.input-or-text>
                                @else
                                    <!-- Display an input field -->
                                    <x-tmk.input-or-text id="newLine{{ $column }}" placeholder="Voeg {{ __($column) }}"
                                                         wire:model="{{ $column === 'name' ? 'newLine' : 'newLine' . ucfirst($column) }}"
                                                         wire:keydown.escape="resetValues()"
                                                         class="w-full shadow-md placeholder-gray-300 mb-3"></x-tmk.input-or-text>
                                @endif
                            @endif
                        @endforeach

                        @if(in_array($newLineType, $this->imageUploadable))
                            <div class="flex-col">
                                <div class="flex flex-col mr-4">
                                    <label for="newImage" class="block text-sm font-medium text-gray-700">Foto 1</label>
                                    <div class="mt-1 flex items-center">
                                <span class="inline-block h-12 w-12 rounded-full overflow-hidden bg-gray-100">
                                    @if($newImage)
                                        <!-- Display newly uploaded image -->
                                        <img src="{{ $newImage->temporaryUrl() }}" alt="New Picture 1" class="object-cover w-full h-full">
                                    @elseif($editing && $newLinePicture_1)
                                        <!-- Display existing image when editing -->
                                        <img src="{{ asset('storage/websitepictures/' . basename($newLinePicture_1)) }}" alt="Existing Picture 1" class="object-cover w-full h-full">
                                    @endif
                                </span>
                                        <input id="newImage" name="newImage" type="file" wire:model="newImage" class="ml-5">
                                    </div>
                                </div>

                                <div class="flex flex-col mt-2">
                                    <label for="newImage2" class="block text-sm font-medium text-gray-700">Foto 2</label>
                                    <div class="mt-1 flex items-center">
                                <span class="inline-block h-12 w-12 rounded-full overflow-hidden bg-gray-100">
                                    @if($newImage2)
                                        <!-- Display newly uploaded image -->
                                        <img src="{{ $newImage2->temporaryUrl() }}" alt="New Picture 2" class="object-cover w-full h-full">
                                    @elseif($editing && $newLinePicture_2)
                                        <!-- Display existing image when editing -->
                                        <img src="{{ asset('storage/websitepictures/' . basename($newLinePicture_2)) }}" alt="Existing Picture 2" class="object-cover w-full h-full">
                                    @endif
                                </span>
                                        <input id="newImage2" name="newImage2" type="file" wire:model="newImage2" class="ml-5">
                                    </div>
                                </div>
                            </div>
                        @endif



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
                <div class="flex justify-center mt-4"> <!-- Added margin-top -->
                    @if ($editing)
                        <!-- Edit form elements -->
                        <x-button wire:click="createOrUpdate" class="flex justify-center bg-red-700">Update</x-button>
                    @else
                        <!-- Create form elements -->
                        <x-button wire:click="createOrUpdate" class="flex justify-center">Add</x-button>
                    @endif
                </div>
            </x-tmk.section>
        @endif


    </div>

    <!--  Big view -->
    <div class="hidden sm:block">


        <!-- DynamicTable.blade.php -->
        <div>
            {{-- Section to create the table based on the column names (excluding timestamps) --}}
            <x-tmk.section>

                <table class="min-w-full border border-gray-300">
                    <thead>
                    <tr class="bg-gray-100 text-gray-700 [&>th]:p-2">
                        @foreach ($columns as $column)
                            <x-tmk.sort-table-header columnName="{{ $column }}" orderBy="{{ $orderBy }}" orderAsc="{{ $orderAsc }}"/>
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
                                @if($column === 'picture_1')
                                    <td class="px-2">
                                        @if($editing && $line->id == $editingLineId && $newImage)
                                            <!-- Display newly uploaded image -->
                                            <div class="rounded-full overflow-hidden h-12 w-12">
                                                <img src="{{ $newImage->temporaryUrl() }}" alt="New Picture 1" class="object-cover w-full h-full">
                                            </div>
                                        @elseif($line->picture_1)
                                            <!-- Display existing image -->
                                            <div class="rounded-full overflow-hidden h-12 w-12">
                                                <img src="{{ asset('storage/websitepictures/' . basename($line->picture_1)) }}" alt="Picture 1" class="object-cover w-full h-full">
                                            </div>
                                        @endif
                                    </td>
                                @elseif($column === 'picture_2')
                                    <td class="px-2">
                                        @if($editing && $line->id == $editingLineId && $newImage2)
                                            <!-- Display newly uploaded image -->
                                            <div class="rounded-full overflow-hidden h-12 w-12">
                                                <img src="{{ $newImage2->temporaryUrl() }}" alt="New Picture 2" class="object-cover w-full h-full">
                                            </div>
                                        @elseif($line->picture_2)
                                            <!-- Display existing image -->
                                            <div class="rounded-full overflow-hidden h-12 w-12">
                                                <img src="{{ asset('storage/websitepictures/' . basename($line->picture_2)) }}" alt="Picture 2" class="object-cover w-full h-full">
                                            </div>
                                        @endif
                                    </td>
                                @else
                                    <!-- Display other columns -->
                                    <td class="px-2">
                                        {{ $column === 'is_approved' ? ($line->$column ? 'yes' : 'no') : ($column === 'date' ? \Carbon\Carbon::createFromFormat('Y-m-d', $line->$column)->format('d-m-Y') : \Illuminate\Support\Str::limit($line->$column, 50, '...')) }}
                                    </td>
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

    <!--  Mobile view -->
    <div class="block sm:hidden">
        @foreach($lines as $line)
            <div class="border border-gray-300 mb-4 p-4 mt-4 bg-white">
                <!-- Include all other relevant fields -->
                @foreach ($columns as $column)
                    @if ($column !== 'id' && $column !== 'picture_1' && $column !== 'picture_2')
                        @if (in_array($column, $booleanColumns))
                            <p><strong>{{ ucfirst(__($column)) }}:</strong> {{ $line->$column ? 'Yes' : 'No' }}</p>
                        @else
                            <p><strong>{{ ucfirst(__($column)) }}:</strong> {{ $line->$column }}</p>
                        @endif
                    @endif
                @endforeach

                <!-- Message indicating the need for a bigger screen if there are images -->
                @if (!empty($line->picture_1) || !empty($line->picture_2))
                    <p class="text-red-500 pt-2 font-bold">Om de afbeeldingen optimaal aan te passen, is het aangeraden om op een groter scherm te werken.</p>
                @endif

                <!-- Edit button -->
                <div class="border border-gray-300 rounded-md overflow-hidden m-2 w-10 h-10 flex items-center justify-center">
                    <button wire:click="editLine({{ $lineId = $line->id }})" class="text-gray-400 hover:text-sky-100 hover:bg-gray-500 transition">
                        <x-phosphor-pencil-line-duotone class="inline-block w-5 h-5"/>
                    </button>
                </div>
            </div>
        @endforeach
    </div>

</div>
