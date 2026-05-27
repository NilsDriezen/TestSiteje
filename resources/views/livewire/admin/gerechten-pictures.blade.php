<div>
    @if($dish)
        <h2>{{ $dish->name }}</h2>
        <div
            x-data
            class="w-60 h-60 flex flex-col gap-4">
            <img class="border border-gray-300 object-cover rounded shadow-lg"
                 src="{{ asset(str_replace('public/', '', $dish->path) ?: 'storage/dishpictures/no-photo.png') . '?v=' . time() }}"
                 alt="{{ $dish->name }}">
            <div class="border border-gray-500 flex text-center [&>a]:flex-1 [&>a]:bg-gray-300 [&>a]:p-2 [&>a]:transition">
                <a href="#"
                   wire:click.prevent="$set('showModal', true)"
                   class="hover:text-white hover:bg-sky-800 border-r border-gray-500">BEWERK</a>
                <a href="#"
                    @click.prevent="$dispatch('swal:confirm', {
          title: 'Verwijder deze foto?',
          cancelButtonText: 'NEE',
          cancelButtonColor: '#3085d6',
          confirmButtonText: 'JA',
          confirmButtonColor: '#d33',
          next: {
                event: 'delete-picture'
          }
       })"
                   class="hover:text-white hover:bg-green-800 border-r border-gray-500">VERWIJDER</a>
               {{-- <a href="#"
                   class="hover:text-white hover:bg-red-800">TERUG</a>--}}
                <a href="javascript:history.back()"
                   class="hover:text-white hover:bg-red-800">TERUG</a>
            </div>
        </div>

        {{-- Upload picture modal --}}
        <x-dialog-modal wire:model.live="showModal">
            <x-slot name="title">
                <h2 class="text-lg font-bold">Selecteer Afbeelding</h2>
            </x-slot>
            <x-slot name="content">
                <div class="flex flex-col gap-4">
                    <div class="flex gap-4">
                        <img class="w-36 h-36 border border-gray-300 object-cover" id="picturePreview"
                                src="{{ $newPicture ? $newPicture->temporaryUrl() : asset($dish->path) . '?v=' . time()}}"
                             alt="Geen afbeelding">
                        <div class="flex-1 py-2">
                            <p class="text-lg font-bold">{{ $dish->name }}</p>
                            <input type="file" id="picture"
                                   wire:model.live="newPicture"
                                   wire:loading.attr="disabled"
                                   wire:target="newPicture"
                                   accept="image/*"
                                   class="mt-4 file:border-0 file:text-white file:bg-sky-800 file:p-2 file:rounded file:cursor-pointer">
                            <x-input-error for="newPicture" class="mt-2"/>
                            <p class="w-full italic text-sky-700 pt-4" wire:loading wire:target="newPicture">
                               Bezig met uploaden...
                            </p>
                        </div>
                    </div>
                </div>
            </x-slot>
            <x-slot name="footer">
                <x-secondary-button wire:click="$toggle('showModal')" wire:loading.attr="disabled">
                    Annuleren
                </x-secondary-button>
                @if($newPicture)
                    <x-button class="ml-2"
                              wire:click="savePicture()"
                              wire:loading.attr="disabled">Opslaan
                    </x-button>
                @endif
            </x-slot>
        </x-dialog-modal>

    @else
        <h2>Redundant pictures</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($redundantCovers as $rPicture)
                <figure class="relative">
                    <img class="border border-gray-300 rounded shadow-lg"
                         src="{{ asset($rPicture) }}" alt="">
                    <button @click="$dispatch('swal:confirm', {
          title: 'Verwijder deze foto?',
          cancelButtonText: 'NEE',
          cancelButtonColor: '#3085d6',
          confirmButtonText: 'JA',
          confirmButtonColor: '#d33',
          next: {
                event: 'delete-picture',
                param: {
                    redundantPicture: '{{ $rPicture }}'
                   }
                  }
       })" class="absolute -top-2 -right-2 w-12 h-12 border border-red-700 bg-red-500 hover:bg-red-700 text-white p-3 rounded-full shadow-lg cursor-pointer">
                        <x-phosphor-trash-fill />
                    </button>
                </figure>
            @endforeach
        </div>
    @endif

    {{--logger--}}
{{--    <x-tmk.livewire-log :lines="$dish"/>--}}
</div>

