<div>
    <div
            class="relative">
        <x-input id="search" type="text"
                 wire:model.live.debounce.500ms="search"
                 wire:keydown.escape="resetValues()"
                 class="block my-4 w-full"
                 placeholder="Filter"/>
        <button
                @click="$wire.set('search', '')"
                @keydown.escape="$wire.set('search', '')"
                class="w-5 absolute right-4 top-3">
            <x-phosphor-x/>
        </button>
    </div>

</div>
