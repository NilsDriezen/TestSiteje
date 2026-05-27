<div>
    <div>
        <p>
            {{ $menuTemplate->content }}
        </p>
    </div>
    <div class="mt-10">
        <h2 class="menu-month">
            Menu voor de maand<span class="menu-month">{{ __($currentMonth) }}</span>
        </h2>
    </div>
    <div class="mt-10
                lg:grid
                lg:grid-cols-8
                lg:content-stretch
                lg:gap-4
                ">
        <div class="mb-10 bg-white
                    lg:col-span-2
                    ">
            <livewire:cocktail-card/>
        </div>
        <div class="mb-10 bg-white
                    lg:col-span-3
                    ">
            <livewire:menu-card/>
        </div>
        <div class="mb-10 bg-white
                    lg:col-span-3
                    ">
            <livewire:veggie-menu-card/>
        </div>
    </div>
    <div class="flex flex-row justify-between gap-4">
        <button class="menu-button mb-5">
            <a href="{{ route('menuNextMonth') }}" class="menu-text">
                Bekijk het menu voor de maand<span class="menu-month">{{ __($nextMonth) }}</span>
            </a>
        </button>
        <button class="menu-button mb-5">
            <a href="{{ route('reserveren') }}" class="menu-text">
                Reserveer hier <i class="fa-solid fa-utensils text-2xl"></i>
            </a>
        </button>
    </div>
</div>
