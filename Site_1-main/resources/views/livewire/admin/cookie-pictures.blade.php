<div x-data class="w-1/5 h-1/5 flex flex-col gap-4 cookies-center">
    @if($cookie)
        <h2> {{ $cookie->name }}</h2>

        <img class="border border-gray-300 object-cover rounded shadow-lg"
             src="{{ asset(Storage::disk('public')->exists('cookiepictures/' . $cookie->picture_path) ?
         'storage/cookiepictures/' . $cookie->picture_path . "?v=" . time() :
         'storage/cookiepictures/placeholder.png') }}"
             alt="niks te zien">

        <div class="gap-2 flex flex-row justify-center">
            <x-button

                wire:click.prevent="$set('showModal', true)"
                class="hover:bg-sky-800">
                BEWERK
            </x-button>

            <x-button
                @click.prevent="$dispatch('swal:confirm', {
            title: 'Deze afbeelding voor {{ $cookie->name }} verwijderen?',
            cancelButtonText: 'NEE',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'JA',
            confirmButtonColor: '#d33',
            next: {
                event: 'delete-picture'
            }
        })"
                class="hover:bg-red-800">
                VERWIJDER
            </x-button>

            <x-button
                class="hover:bg-gray-100">
                <a href="javascript:void(0);" onclick="history.back()">TERUG</a>
{{--                <a href="{{ route('admin.koekjesbeheer') }}">TERUG</a>--}}
            </x-button>

        </div>

        {{-- Upload picture modal --}}
        <x-dialog-modal wire:model.live="showModal">
            <x-slot name="title">
                <h2 class="text-lg font-bold">Selecteer Afbeelding</h2>
            </x-slot>
            <x-slot name="content">
                <div class="flex flex-col gap-4">
                    <div class="flex gap-4">
                        <img class=" py-4 w-36 h-36   object-cover" id="picturePreview"
                             src='{{ $newPicture ? $newPicture->temporaryUrl() : asset("storage/cookiepictures/{$cookie->picture_path}?v=" . time()) }}'
                             alt="Geen afbeelding">


                        <div class="flex flex-col">
                            <p class="text-lg font-bold">{{$cookie->name}} </p>
                            <p class="py-4 italic font-semibold"></p>

                            <input type="file" id="picture"
                                   wire:model.live="newPicture"
                                   wire:loading.attr="disabled"
                                   wire:target="newPicture"
                                   accept="image/*"
                                   class="file:border-0 file:text-white file:bg-sky-800 file:p-2 file:rounded file:cursor-pointer ">
                            <x-input-error for="newPicture" class="mt-2"/>
                            <p class="w-full italic text-sky-700 pt-4" wire:loading wire:target="newPicture">
                                Processing image...
                            </p>
                        </div>
                    </div>
                </div>
            </x-slot>
            <x-slot name="footer">
                <x-secondary-button wire:click="$toggle('showModal')" wire:loading.attr="disabled">
                    Cancel
                </x-secondary-button>
                @if($newPicture)
                    <x-button class="ml-2"
                              wire:click="savePicture()"
                              wire:loading.attr="disabled">Save
                    </x-button>
                @endif
            </x-slot>
        </x-dialog-modal>

    @else
        <h2>Redundant Pictures</h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($redundantPictures as $picture)
                <figure class="relative">
                    <img class="border border-gray-300 rounded shadow-lg w-full h-full object-cover"
                         src="{{ '/storage/' . $picture }}" alt="">

                    <button



                        @click="$dispatch('swal:confirm', {
                    title: 'Verwijder {{ $picture }}?',
                    cancelButtonText: 'NEE!',
                    confirmButtonText: 'JA, VERWIJDER DEZE FOTO!',
                    next: {
                        event: 'delete-picture',
                        params: {
                            redundantPicture: '{{ $picture }}'
                       }
                    }
                })"

                        class="absolute -top-2 -left-2 w-9 h-9  b bg-red-500 hover:bg-red-700 text-white p-2 rounded-full shadow-lg cursor-pointer">
                        <x-phosphor-trash-fill />
                    </button>
                </figure>
            @endforeach
        </div>

    @endif


    {{--          logger--}}
{{--    <x-tmk.livewire-log :cookies="$cookies"/>--}}

</div>

