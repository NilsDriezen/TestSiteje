<div>
    <div class="my-4">{{ $cookies->links() }}</div>

    {{-- cards --}}
    <div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($cookies as $cookie)
             @if ($cookie->active == 1)
                <div
                    wire:key="item-{{ $cookie->id }}"
                    class="flex flex-col"
                >

                    <x-tmk.cookie-card
                        :src="$cookie->picture_path"
                        :alt="$cookie->picture_path"
                        :name="$cookie->name"
                        :description="$cookie->description"
                        :price="$cookie->price"
                        :stock="$cookie->stock"
                        :id="$cookie->id"
                    >
                    </x-tmk.cookie-card>
                </div>            @endif
            @endforeach

        </div>


        <x-tmk.section class="text-xl" >
            {{ $cookieText->content}}
        </x-tmk.section>

    </div>

    {{-- Modals--}}

        {{-- Detail section Modal--}}
        <x-dialog-modal
            wire:model="showModal"
        >
            {{--titel--}}
            <x-slot name="title">
                <div class="relative">
                    <x-tmk.blurred-image
                        wire:model.live="showBigImage"
                        :src="$selectedCookie->picture_path ?? ''"
                        :alt="$selectedCookie->picture_path ?? ''"
                        :name="$selectedCookie->name ?? ''"

                    />
                </div>
            </x-slot>
            {{--content--}}
            <x-slot name="content">
                <h2 class="text-2xl font-semibold pt-5">Beschrijving</h2>
                <p class="my-2 py-2 text-gray-700">{{ $selectedCookie->description ?? '' }}</p>


            </x-slot>

            <x-slot name="footer">
                <p class="text-gray-700">€{{ $selectedCookie->price ?? '' }}</p>
            </x-slot>

        </x-dialog-modal>


    {{-- livewire log linksboven --}}
{{--    <x-tmk.livewire-log :cookies="$cookies" :cookieText="$cookieText"/>--}}


</div>
