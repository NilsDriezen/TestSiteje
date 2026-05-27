<div
    class="pl-4 pr-1 py-4  {{ $line->stock == 0 ? 'bg-red-200' : 'bg-white' }} border border-gray-300 rounded overflow-hidden shadow-md flex justify-between {{ $line->is_new ? 'border-gray-00 bg-amber-200' : 'border-gray-300' }}">

    <div>
        <strong class="text-xl"> {{ $line['name'] }}</strong><br>
        <a href="{{ route('admin.cookiepictures', $line->id) }}">
            @if(Storage::disk('public')->exists('cookiepictures/' . $line->picture_path))
                <img
                    src="{{ asset('storage/cookiepictures/' . $line->picture_path) . "?v=" . time() }}"
                    alt="{{ $line->picture_path }}"
                    class="my-2 border object-cover w-12 h-12 aspect-w-1 aspect-h-1"
                />
            @else
                <img src="{{ asset('storage/cookiepictures/placeholder.png') }}"
                     alt="{{ $line->picture_path }}"
                     class="my-2 border object-cover w-12 h-12 aspect-w-1 aspect-h-1"
                />
            @endif
        </a>

        <span title="{{ $line['description'] }}"><strong>Beschrijving:</strong> {{Str::limit($line['description'],30,'...') }}</span><br>
        <strong>Prijs:</strong> {{ $line->price }}<br>
        <strong>Beschikbaarheid:</strong> {{ $line->stock }}<br>
        <strong>Recept:</strong>
        @if($line->dish_id == 1)
            <a href="{{ route('admin.gerechten', ['showModal' => true]) }}"
               class="text-gray-400 hover:text-black transition" title="Open modal">
                <x-phosphor-file-plus class="inline-block w-5 h-5"/>
            </a>
        @else
            <a href="{{ route('admin.gerechten',['search' => $line->dish->name]) }}"
               class="text-gray-400 hover:text-black transition">
                <x-phosphor-eye class="inline-block w-5 h-5"/>
            </a>
        @endif<br>

<div class="flex items-center">
    <strong>Publiceren:</strong>
    @if($line->active)
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="green" wire:click="toggleActive({{$line->id}})" class="w-6 h-6 cursor-pointer hover:scale-110 transition-transform ml-2">
            <path fill-rule="evenodd" d="M15.293 5.293a1 1 0 0 1 1.414 1.414l-7 7a1 1 0 0 1-1.414 0l-3-3a1 1 0 0 1 1.414-1.414L8 12.586l6.293-6.293a1 1 0 0 1 1.414 0z" clip-rule="evenodd" />
        </svg>
    @else
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="red" wire:click="toggleActive({{$line->id}})" class="w-6 h-6 cursor-pointer hover:scale-110 transition-transform ml-2">
            <path fill-rule="evenodd" d="M6.707 6.293a1 1 0 0 1 1.414-1.414L10 8.586l2.879-2.88a1 1 0 1 1 1.414 1.414L11.414 10l2.88 2.879a1 1 0 1 1-1.414 1.414L10 11.414l-2.879 2.88a1 1 0 0 1-1.414-1.414L8.586 10 5.707 7.121a1 1 0 0 1 0-1.414z" clip-rule="evenodd" />
        </svg>
    @endif
</div>



    </div>
    <div class="w-36">
        <x-tmk.action-button-group :lineId="$line->id" :lineName="$line->name ?? 'line'"/>
    </div>
</div>
