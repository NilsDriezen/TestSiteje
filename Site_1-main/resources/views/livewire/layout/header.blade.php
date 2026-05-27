<div>
    <header class='bg-white font-sans tracking-wide relative z-50'>
        <section
            class='flex items-center lg:justify-center flex-wrap gap-5 relative py-3 px-10 border-gray-200 border-b lg:min-h-[80px] max-lg:min-h-[60px]'>
            <a href="/home"><img src="/assets/images/logo_huiskamer.svg" alt="logo" class='md:w-[230px] w-36'/>
            </a>
            <div class='flex ml-auto lg:hidden'>
                <!-- Winkelwagenknop -->
                <div id="mandje" class='flex ml-auto hidden lg:block'>
                    <a href='/mandje' class='relative ml-3  hover:text-secondary text-gray-500 font-bold text-[15px]'>
                        <x-fas-shopping-basket class="w-7 h-7"/>
                        @if(Cart::getTotalQty() > 0)
                            <span
                                class="absolute -top-1 -right-1 text-xs bg-rose-500 text-rose-100 rounded-full w-5 h-5 flex items-center justify-center">
                        {{ Cart::getTotalQty() }}
                    </span>
                        @endif
                    </a>
                </div>
                <button id="toggleOpen">
                    <svg class="w-7 h-7" fill="#000" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                              d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                              clip-rule="evenodd"></path>
                    </svg>
                </button>
            </div>
        </section>

        <div class='py-3.5 px-0 '>

            <div id="collapseMenu"
                 class='w-full max-lg:hidden lg:!block max-lg:before:fixed max-lg:before:bg-black max-lg:before:opacity-50 max-lg:before:inset-0 max-lg:before:z-50'>
                <button id="toggleClose" class='lg:hidden fixed top-2 right-4 z-[100] rounded-full bg-white p-3'>
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 fill-black" viewBox="0 0 320.591 320.591">
                        <path
                            d="M30.391 318.583a30.37 30.37 0 0 1-21.56-7.288c-11.774-11.844-11.774-30.973 0-42.817L266.643 10.665c12.246-11.459 31.462-10.822 42.921 1.424 10.362 11.074 10.966 28.095 1.414 39.875L51.647 311.295a30.366 30.366 0 0 1-21.256 7.288z"
                            data-original="#000000"></path>
                        <path
                            d="M287.9 318.583a30.37 30.37 0 0 1-21.257-8.806L8.83 51.963C-2.078 39.225-.595 20.055 12.143 9.146c11.369-9.736 28.136-9.736 39.504 0l259.331 257.813c12.243 11.462 12.876 30.679 1.414 42.922-.456.487-.927.958-1.414 1.414a30.368 30.368 0 0 1-23.078 7.288z"
                            data-original="#000000"></path>
                    </svg>
                </button>

                <ul
                    id="dropdown"
                    class="lg:flex lg:justify-center lg:gap-x-10 max-lg:space-y-3 max-lg:fixed max-lg:bg-white max-lg:w-1/2 max-lg:min-w-[300px] max-lg:top-0 max-lg:left-0 max-lg:p-6 max-lg:h-full max-lg:shadow-md max-lg:overflow-auto z-50"
                >
                    <li class='mb-6 hidden max-lg:block'>
                        <a href="javascript:void(0)"><img src="/assets/images/logo_huiskamer.svg" alt="logo" class='md:w-[230px] w-36'/>
                        </a>
                    </li>
                    <li class='max-lg:border-b max-lg:py-3'><a href='/home'
                                                               class='hover:text-secundary text-gray-500 font-bold text-[15px] block'>Home</a>
                    </li>
                    <li class='max-lg:border-b max-lg:py-3'><a href='/menu'
                                                               class='hover:text-secondary text-gray-500 font-bold text-[15px] block'>Menu</a>
                    </li>
                    <li class='max-lg:border-b max-lg:py-3'><a href='/reserveren'
                                                               class='hover:text-secondary text-gray-500 font-bold text-[15px] block'>Reserveren</a>
                    </li>
                    <li class='max-lg:border-b max-lg:py-3'><a href='/koekjes'
                                                               class='hover:text-secondary text-gray-500 font-bold text-[15px] block'>Koekjes</a>
                    </li>
                    <li class='max-lg:border-b max-lg:py-3'><a href='/contact'
                                                               class='hover:text-secondary text-gray-500 font-bold text-[15px] block'>Contact</a>
                    </li>
                    <li class='max-lg:border-b max-lg:py-3 mt-1'><a href='/mandje'
                                                                    class='relative mr-3 hover:text-secondary text-gray-500 font-bold text-[15px] block'>
                            <x-fas-shopping-basket class="w-4 h-4"/>
                            @if(Cart::getTotalQty() > 0)
                                <span
                                    class="absolute -top-2 left-2 text-xs bg-rose-500 text-rose-100 rounded-full w-4 h-4 flex items-center justify-center">
                    {{ Cart::getTotalQty() }}
                </span>
                            @endif
                        </a>
                    </li>
                </ul>

            </div>
   <div class="relative w-full top-[-55px] md:top-[-60px]  lg:top-[-30px]">

                {{--                @guest
                                    <x-nav-link href="{{ route('login') }}" :active="request()->routeIs('login')">
                                        Login
                                    </x-nav-link>
                                    <x-nav-link href="{{ route('register') }}" :active="request()->routeIs('register')">
                                        Register
                                    </x-nav-link>
                                @endguest--}}
                {{-- dropdown navigation--}}
                @auth
                    <x-dropdown align="right" width="48">
                        {{-- avatar --}}
                        <x-slot name="trigger">
                            <img class="rounded-full h-8 w-8 cursor-pointer float-right"
                                 src="https://ui-avatars.com/api/?name={{urlencode(auth()->user()->first_name)}}"
                                 alt="{{ auth()->user()->name }}">
                        </x-slot>
                        <x-slot name="content">
                            {{-- all users --}}
                            <div class="block px-4 py-2 text-xs text-gray-400">{{ auth()->user()->first_name }}</div>
                            <x-dropdown-link href="{{ route('profile.show') }}">Update Profile</x-dropdown-link>
                            <div class="border-t border-gray-100"></div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                        class="block w-full text-left px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition">
                                    Logout
                                </button>
                            </form>
                            <div class="border-t border-gray-100"></div>
                            {{-- admins only --}}
                            @if(auth()->user()->admin)
                                <x-dropdown-link href="{{ route('admin.dashboard') }}">Dashboard</x-dropdown-link>
                                <div class="block px-4 py-2 text-xs text-gray-400">Ordersbeheer en feedback</div>
                                <div class="border-t border-gray-100"></div>
                                <x-dropdown-link href="{{ route('admin.koekjesbestellingen') }}" class="relative">
                                    <span class="relative">koekjesbestellingen
                                        @if($aantal > 0)
                                            <span
                                                class="absolute top-0 left-32 text-xs bg-green-600 text-white rounded-full w-4 h-4 flex items-center justify-center -mt-2 -mr-3"
                                                data-tippy-content="Nieuwe koekjesbestellingen">
                                                {{ $aantal }}
                                            </span>
                                        @endif
                                    </span>
                                </x-dropdown-link>
                                <x-dropdown-link href="{{ route('admin.reservaties') }}" class="relative">
                                    <span class="relative">Reservaties
                                        @if($aantalreservaties > 0)
                                            <span
                                                class="absolute top-0 left-20 text-xs bg-green-600 text-white rounded-full w-4 h-4 flex items-center justify-center -mt-2 -mr-3"
                                                data-tippy-content="Nieuwe reservaties">
                                                {{ $aantalreservaties }}
                                            </span>
                                        @endif
                                    </span>
                                </x-dropdown-link>
                                <x-dropdown-link href="{{ route('admin.reviews') }}" class="relative">
                                    <span class="relative">Reviews
                                        @if($aantalNieuweReviews > 0)
                                            <span
                                                class="absolute top-0 left-14 text-xs bg-green-600 text-white rounded-full w-4 h-4 flex items-center justify-center -mt-2 -mr-3"
                                                data-tippy-content="Nieuwe reviews">
                                                {{ $aantalNieuweReviews     }}
                                            </span>
                                        @endif
                                    </span>
                                </x-dropdown-link>
                                <div class="block px-4 py-2 text-xs text-gray-400">Gebruikersbeheer</div>
                                <div class="border-t border-gray-100"></div>
                                <x-dropdown-link href="{{ route('admin.personeel') }}">Personeel</x-dropdown-link>
                                <div class="block px-4 py-2 text-xs text-gray-400">Inhoud beheren</div>
                                <div class="border-t border-gray-100"></div>
                                <x-dropdown-link href="{{ route('admin.agendabeheer') }}">Agenda</x-dropdown-link>
                                <x-dropdown-link href="{{ route('admin.bevestigingsmail') }}">Bevestigingsmail
                                </x-dropdown-link>
                                <x-dropdown-link href="{{ route('admin.website') }}">Website</x-dropdown-link>
                                <x-dropdown-link href="{{ route('admin.courses') }}">Gangen</x-dropdown-link>
                                <div class="block px-4 py-2 text-xs text-gray-400">Productbeheer</div>
                                <div class="border-t border-gray-100"></div>
                                <x-dropdown-link href="{{ route('admin.gerechten') }}">Gerechten</x-dropdown-link>
                                <x-dropdown-link href="{{ route('admin.ingredienten') }}">Ingrediënten</x-dropdown-link>
                                <x-dropdown-link href="{{ route('admin.koekjesbeheer') }}">Koekjesbeheer
                                </x-dropdown-link>
                                <x-dropdown-link href="{{ route('admin.menubeheer') }}">Menubeheer</x-dropdown-link>
                                <x-dropdown-link href="{{ route('admin.cocktailbeheer') }}">Cocktailbeheer
                                </x-dropdown-link>





                                <div class="border-t border-gray-100"></div>
                            {{--niet admin user = personeel --}}
                            @else
                                <x-dropdown-link href="{{ route('user.dashboard') }}">Dashboard</x-dropdown-link>

                                <div class="border-t border-gray-100"></div>
                                <x-dropdown-link href="{{ route('admin.reservaties') }}">Reservaties</x-dropdown-link>
                                <div class="border-t border-gray-100"></div>
                                <x-dropdown-link href="{{ route('user.koekjesbestellingen') }}">Koekjes</x-dropdown-link>
                                <div class="border-t border-gray-100"></div>
                                {{--user planning--}}
                                <x-dropdown-link href="{{ route('user.planning')}}">Planning</x-dropdown-link>
                            @endif
                        </x-slot>
                    </x-dropdown>
            </div>
            @endauth
        </div>

    </header>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const toggleOpen = document.getElementById('toggleOpen');
            const toggleClose = document.getElementById('toggleClose');
            const collapseMenu = document.getElementById('collapseMenu');

            toggleOpen.addEventListener('click', () => {
                collapseMenu.classList.toggle('max-lg:hidden');
            });

            toggleClose.addEventListener('click', () => {
                collapseMenu.classList.toggle('max-lg:hidden');
            });
        });
    </script>


    <script>
let clickCount = 0;
let clickTimer = null;

document.querySelector('a[href="/home"]').addEventListener('click', function(event) {
    clickCount++;
    if (clickCount === 1) {
        clickTimer = setTimeout(function() {
            clickCount = 0;
        }, 1000); // reset de teller na 1 seconde
    } else if (clickCount === 3) {
        event.preventDefault(); // voorkomt dat de link de pagina herlaadt
        clearTimeout(clickTimer);
        clickCount = 0;
        window.location.href = '/login'; // vervang '/login' door de daadwerkelijke URL van uw loginpagina
    }
});
    </script>

</div>
