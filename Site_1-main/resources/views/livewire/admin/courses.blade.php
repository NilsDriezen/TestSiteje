<div class="md:w-3/4 lg:w-3/4 xl:w-3/4 ml-5 md:ml-28  xl:ml-36 mx-auto">

    {{-- Filter --}}

        <x-tmk.section class="mb-4 grid grid-cols-1 md:grid-cols-12 gap-4">
            <!-- Search input -->
            <div class="col-span-10 lg:col-span-3 md:col-span-6">
                <div class="relative">
                    <x-input id="search" type="text" placeholder="Filter op type gang"
                             class="w-full shadow-md placeholder-gray-300"
                             {{--wire:model="search"--}}
                             wire:model.live.debounce.500ms="search" />
                    @if(!empty($search))
                        <button @click="$wire.set('search', '')"
                                class="absolute inset-y-0 right-0 pr-3 flex items-center">
                            <x-phosphor-x/>
                        </button>
                    @endif
                </div>
            </div>

            <!-- Switch for 'no dish' -->
            <div class="col-span-10 md:col-span-6 lg:col-span-3 sm:col-span-3 flex justify-end items-center">
                <div class="w-full max-w-xs ml-auto">
                    <x-tmk.form.switch id="noDish"
                                       wire:model.live="noDish"
                                       text-off="Zonder gerecht"
                                       text-on="Zonder gerecht"
                                       class="w-full  lg:w-full md:w-full max-w-xs" />
                </div>
            </div>


            <!-- Per page selection -->
            <div class="col-span-10 lg:col-span-3 md:col-span-6 flex-grow flex-shrink flex items-center">
                <x-label for="perPage" class="mr-2">Per pagina:</x-label>
                <x-tmk.form.select id="perPage" wire:model="perPage" class="col-span-10 lg:col-span-3 md:col-span-5 flex-grow flex-shrink">
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="15">15</option>
                    <option value="20">20</option>
                </x-tmk.form.select>
            </div>


            <div class="col-span-10 md:col-span-6 lg:col-span-3 flex justify-center items-center">
                <x-button wire:click="newCourse()"
                          class="w-auto h-full flex justify-center text-center md:w-64 lg:w-48 px-4 py-2 bg-blue-500 hover:bg-blue-700 text-white font-bold rounded">
                    Nieuwe gang
                </x-button>
            </div>

        </x-tmk.section>



    {{-- Table with records --}}
    <x-tmk.section>
        <div class="my-4">{{ $courses->links() }}</div>
        <table class="text-center w-full border border-gray-300">
            <colgroup>
                <col class="w-14 hidden">
                <col class="w-40">
                <col class="w-40">
                <col class="w-20">
            </colgroup>
            <thead>
            <tr class="bg-gray-100 text-gray-700 [&>th]:p-2">
                <th class="hidden">#</th>
               {{-- <th class="text-center">Type</th>--}}
                <th wire:click="resort('type')">
                    <span
                        data-tippy-content="Sorteer op type">Type</span><x-heroicon-s-chevron-up
                        class="w-5 text-slate-400
                             {{$orderAsc ?: 'rotate-180'}}
                             {{$orderBy === 'type' ? 'inline-block' : 'hidden'}}"/></th>
                {{--<th>Aantal gerechten</th>--}}
                <th wire:click="resort('dishes_count')">
                    <span
                        data-tippy-content="Sorteer op type">Aantal gerechten</span><x-heroicon-s-chevron-up
                        class="w-5 text-slate-400
                             {{$orderAsc ?: 'rotate-180'}}
                             {{$orderBy === 'dishes_count' ? 'inline-block' : 'hidden'}}"/></th>
                <th>

                </th>
            </tr>
            </thead>
            <tbody>
            @foreach($courses as $course)
            <tr wire:key="{{ $course->id }}" class="border-t border-gray-300">

            <td class="hidden">{{ $course->id }}</td>
                <td class="text-center">{{ $course->type }}</td>
                <td>{{ $course->dishes->count() }}</td>
                <td>
                    <div class="border border-gray-300 rounded-md overflow-hidden m-2 grid grid-cols-2 h-10">
                        <button
                            class="text-gray-400 hover:text-sky-100 hover:bg-sky-500 transition border-r border-gray-300"
                            wire:click="editCourse({{ $course->id }})">
                            <x-phosphor-pencil-line-duotone class="inline-block w-5 h-5"/>
                        </button>
                        <button
                            class="text-gray-400 hover:text-red-100 hover:bg-red-500 transition"
                            wire:click="deleteCourse({{ $course->id }})">
                            <x-phosphor-trash-duotone class="inline-block w-5 h-5"/>
                        </button>
                        {{--<button @click="$dispatch('swal:confirm', {
                                    title: 'Verwijder {{ $course->type }}?',
                                    cancelButtonText: 'NEE!',
                                    confirmButtonText: 'JA, VERWIJDER DEZE GANG!',
                                    next: {
                                        event: 'delete-course',
                                        params: {
                                            id: {{ $course->id }}
                                        }
                                    }
                                })"
                                class="text-gray-400 hover:text-red-100 hover:bg-red-500 transition">
                            <x-phosphor-trash-duotone class="inline-block w-5 h-5"/>
                        </button>--}}
                    </div>
                </td>
            </tr>
            {{--@empty
                <tr>
                    <td colspan="6" class="border-t border-gray-300 p-4 text-center text-gray-500">
                        <div class="font-bold italic text-sky-800">Geen gangen gevonden</div>
                    </td>
                </tr>--}}
            @endforeach
            {{-- No records found --}}
            @if($courses->isEmpty())
                <x-tmk.alert type="danger" class="w-full">
                    Niets gevonden!
                </x-tmk.alert>
            @endif
            </tbody>
        </table>
    </x-tmk.section>

    {{-- Modal for add and update record --}}
    <x-dialog-modal id="courseModal"
                    wire:model.live="showModal">
        <x-slot name="title">
            <h2>   {{ is_null($form->id) ? 'Nieuw gang' : 'Wijzig gang'}}</h2>
        </x-slot>
        <x-slot name="content">
            {{-- error messages --}}
            @if ($errors->any())
                <x-tmk.alert type="danger">
                    <x-tmk.list>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </x-tmk.list>
                </x-tmk.alert>
            @endif
            <div class="flex flex-row gap-4 mt-4">
                <div class="flex-1 flex-col gap-2">
                    <label for="type">Type gang</label>
                    <x-input id="type" type="text" placeholder="Type gang"
                             wire:model.live="form.type"
                             class="w-full shadow-md placeholder-gray-300"/>
                </div>
            </div>
        </x-slot>
        <x-slot name="footer">
            <x-secondary-button @click="$wire.showModal = false">Annuleer</x-secondary-button>
            @if(is_null($form->id))
                <x-tmk.form.button color="success"
                                   disabled="{{ $form->type ? 'false' : 'true' }}"
                                   wire:click="createCourse()"
                                   class="ml-2">Opslaan</x-tmk.form.button>
            @else
                <x-tmk.form.button color="info"
                                      disabled="{{ $form->type ? 'false' : 'true' }}"
                                   wire:click="updateCourse({{ $form->id }})"
                                   class="ml-2">Opslaan
                </x-tmk.form.button>
            @endif

        </x-slot>
    </x-dialog-modal>
</div>
