<div>
    <x-slot name="subtitle">
        Welkom {{ Auth::user()->first_name }} {{ Auth::user()->last_name }}
        <br>
        @if(Auth::user()->admin)
            <span class="inline-flex items-center rounded-md bg-indigo-50 px-2 py-1 font-medium text-indigo-700 text-2xl mt-2 ring-1 ring-inset ring-indigo-700/10">Admin</span>
        @endif
    </x-slot>
    {{--<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">--}}
    <span class="inline-flex shadow-xl items-center rounded-md bg-indigo-50 px-2 py-1 font-medium text-indigo-700 text-2xl mt-2 ring-1 ring-inset ring-indigo-700/10">Ordersbeheer en feedback</span>

    <div class="bg-d1 rounded-xl grid grid-cols-1 lg:grid-cols-3 md:grid-cols-2 my-8">
            <div class="bg-white m-5 p-4 rounded-lg flex flex-col md:flex-row justify-start items-start align-text-bottom hover:bg-gray-50 shadow-lg ring-1 ring-gray-900/5">
                <div class="md:pb-4 w-full md:w-40 p-4 pr-0">
                    <img src="{{ asset('assets/icons/dashboard/bestellingen.svg') }}" alt="koekjesbestellingen" class="w-10 h-10">
                </div>

                <div class=" md:flex-row flex-col flex justify-between items-start w-full space-y-4 md:space-y-0">
                    <div class="flex flex-col justify-start items-start space-y-2">
                        <a href="{{ route('admin.koekjesbestellingen', ['showToday' => 0]) }}"
                           class='relative mr-3  hover:text-secondary text-gray-500 font-bold text-[15px] block'>
                            @if( $aantal >0)
                                {{-- <span
                                     class="absolute -top-2 -right-2 text-xs bg-green-600 text-white rounded-full w-4 h-4 flex items-center justify-center">
                                     {{ $aantal }}
                                 </span>--}}
                                <span
                                    class="absolute -top-16 -right-16 xl:right-10 lg:right-2 lg:top-3.5 md:right-10 md:top-3 text-xs bg-green-600 text-white rounded-full w-4 h-4 flex items-center justify-center"
                                    data-tippy-content="Nieuwe koekjesbestellingen"
                                >
                        {{ $aantal }}
                        </span>
                            @endif</a>
                        <h2 class="text-xl font-semibold text-gray-800">Koekjesbestellingen </h2>
                        <a href="{{ route('admin.koekjesbestellingen') }}" class="mt-4 block text-blue-600 hover:underline">Bekijk koekjesbestellingen</a>
                    </div>
                </div>
            </div>

            <div class="bg-white m-5 p-4 rounded-lg flex flex-col md:flex-row justify-start items-start align-text-bottom  hover:bg-gray-50 shadow-lg ring-1 ring-gray-900/5">
                <div class="md:pb-4 w-full md:w-40 p-4 pr-0">
                    <img src="{{ asset('assets/icons/dashboard/reservation.svg') }}" alt="reservaties" class="w-10 h-10">
                </div>
                <div class=" md:flex-row flex-col flex justify-between items-start w-full space-y-4 md:space-y-0">
                    <div class="flex flex-col justify-start items-start space-y-2">
                        <a href="{{ route('admin.reservaties', ['showToday' => 0]) }}"
                           class='relative mr-3  hover:text-secondary text-gray-500 font-bold text-[15px] block'>
                            @if( $aantalreservaties >0)
                                {{-- <span
                                     class="absolute -top-2 -right-2 text-xs bg-green-600 text-white rounded-full w-4 h-4 flex items-center justify-center">
                                     {{ $aantal }}
                                 </span>--}}
                                <span
                                    class="absolute -top-16 -right-16 xl:right-10 lg:right-2 lg:top-3.5 md:right-10 md:top-3 text-xs bg-green-600 text-white rounded-full w-4 h-4 flex items-center justify-center"
                                    data-tippy-content="Nieuwe reservaties"
                                >
                        {{ $aantalreservaties }}
                        </span>
                            @endif</a>
                        <h2 class="text-xl font-semibold text-gray-800">Reservaties</h2>
                        <a href="{{ route('admin.reservaties') }}" class="mt-4 block text-blue-600 hover:underline">Bekijk reservaties</a>
                    </div>
                </div>
            </div>

            <div class="bg-white m-5 p-4 rounded-lg flex flex-col md:flex-row justify-start items-start align-text-bottom  hover:bg-gray-50 shadow-lg ring-1 ring-gray-900/5">
                <div class="md:pb-4 w-full md:w-40 p-4 pr-0">
                    <img src="{{ asset('assets/icons/dashboard/feedback.svg') }}" alt="reviews" class="w-10 h-10">
                </div>

                <div class=" md:flex-row flex-col flex justify-between items-start w-full space-y-4 md:space-y-0">
                    <div class="flex flex-col justify-start items-start space-y-2">
                        <a href="{{ route('admin.reviews', ['showToday' => 0]) }}"
                           class='relative mr-3  hover:text-secondary text-gray-500 font-bold text-[15px] block'>
                            @if( $aantalNieuweReviews >0)
                                <span
                                    class="absolute -top-16 -right-16 xl:right-10 lg:right-2 lg:top-3.5 md:right-10 md:top-3 text-xs bg-green-600 text-white rounded-full w-4 h-4 flex items-center justify-center"
                                    data-tippy-content="Nieuwe reviews"
                                >
                        {{ $aantalNieuweReviews }}
                        </span>
                            @endif</a>
                        <h2 class="text-xl font-semibold text-gray-800">Reviews</h2>
                        <a href="{{ route('admin.reviews') }}" class="mt-4 block text-blue-600 hover:underline">Bekijk reviews</a>
                    </div>
                </div>
            </div>


        </div>
        {{--end top 3 with icons--}}

    {{--    <div class="bg-d1 rounded-xl">--}}
    <span class="inline-flex shadow-xl items-center rounded-md bg-indigo-50 px-2 py-1 font-medium text-indigo-700 text-2xl mt-2 ring-1 ring-inset ring-indigo-700/10">Gebruikersbeheer</span>
    <div class="bg-d1 rounded-xl grid grid-cols-1 lg:grid-cols-3 md:grid-cols-2 my-8">
                <div class="bg-white m-5 p-4 rounded-lg flex flex-col md:flex-row justify-start items-start align-text-bottom  hover:bg-gray-50 shadow-lg ring-1 ring-gray-900/5">
                    <div class="md:pb-4 w-full md:w-40 p-4 pr-0">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-10 h-10">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                        </svg>
                    </div>
                    <div class=" md:flex-row flex-col flex justify-between items-start w-full space-y-4 md:space-y-0">

                        <div class="flex flex-col justify-start items-start space-y-2">
                            <h2 class="text-xl font-semibold text-gray-800">Personeel</h2>
                            <a href="{{ route('admin.personeel') }}" class="block text-blue-600 hover:underline row-span-2 col-span-2">Bekijk personeel</a>
                        </div>
                    </div>
                </div>
            </div>
       {{-- </div>--}}
{{--        end personeel--}}

    <span class="inline-flex shadow-xl items-center rounded-md bg-indigo-50 px-2 py-1 font-medium text-indigo-700 text-2xl mt-2 ring-1 ring-inset ring-indigo-700/10">Inhoud beheren</span>
    <div class="bg-d1 rounded-xl grid grid-cols-1 lg:grid-cols-3 md:grid-cols-2 my-8">
        <div class="bg-white m-5 p-4 rounded-lg flex flex-col md:flex-row justify-start items-start align-text-bottom  hover:bg-gray-50 shadow-lg ring-1 ring-gray-900/5">
                <div class="md:pb-4 w-full md:w-40 p-4 pr-0">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-10 h-10">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5m-9-6h.008v.008H12v-.008ZM12 15h.008v.008H12V15Zm0 2.25h.008v.008H12v-.008ZM9.75 15h.008v.008H9.75V15Zm0 2.25h.008v.008H9.75v-.008ZM7.5 15h.008v.008H7.5V15Zm0 2.25h.008v.008H7.5v-.008Zm6.75-4.5h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V15Zm0 2.25h.008v.008h-.008v-.008Zm2.25-4.5h.008v.008H16.5v-.008Zm0 2.25h.008v.008H16.5V15Z" />
                    </svg>
                </div>
                <div class=" md:flex-row flex-col flex justify-between items-start w-full space-y-4 md:space-y-0">
                    <div class="flex flex-col justify-start items-start space-y-2">
                    <h2 class="text-xl font-semibold text-gray-800">Agenda</h2>
                    <a href="{{ route('admin.agendabeheer') }}" class="mt-4 block text-blue-600 hover:underline">Bekijk agendabeheer</a>
                    </div>
                </div>
            </div>
            <div class="bg-white m-5 p-4 rounded-lg flex flex-col md:flex-row justify-start items-start align-text-bottom  hover:bg-gray-50 shadow-lg ring-1 ring-gray-900/5">
                <div class="md:pb-4 w-full md:w-40 p-4 pr-0">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-10 h-10">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                </svg>
                </div>
                <div class=" md:flex-row flex-col flex justify-between items-start w-full space-y-4 md:space-y-0">
                    <div class="flex flex-col justify-start items-start space-y-2">
                <h2 class="text-xl font-semibold text-gray-800">Bevestigingsmail</h2>
                <a href="{{ route('admin.bevestigingsmail') }}" class="mt-4 block text-blue-600 hover:underline">Bekijk bevestigingsmail</a>
                    </div>
                </div>
            </div>

            <div class="bg-white m-5 p-4 rounded-lg flex flex-col md:flex-row justify-start items-start align-text-bottom  hover:bg-gray-50 shadow-lg ring-1 ring-gray-900/5">
                <div class="md:pb-4 w-full md:w-40 p-4 pr-0">
                    <img src="{{ asset('assets/icons/dashboard/website.svg') }}" alt="website" class="w-10 h-10">
                </div>
                <div class=" md:flex-row flex-col flex justify-between items-start w-full space-y-4 md:space-y-0">
                    <div class="flex flex-col justify-start items-start space-y-2">
                        <h2 class="text-xl font-semibold text-gray-800">Website</h2>
                        <a href="{{ route('admin.website') }}" class="mt-4 block text-blue-600 hover:underline">Bekijk website</a>
                    </div>
                </div>
            </div>

            <div class="bg-white m-5 p-4 rounded-lg flex flex-col md:flex-row justify-start items-start align-text-bottom  hover:bg-gray-50 shadow-lg ring-1 ring-gray-900/5">
                <div class="md:pb-4 w-full md:w-40 p-4 pr-0">
                    <img src="{{ asset('assets/icons/dashboard/courses.svg') }}" alt="gangen" class="w-10 h-10">
                </div>
                <div class=" md:flex-row flex-col flex justify-between items-start w-full space-y-4 md:space-y-0">
                    <div class="flex flex-col justify-start items-start space-y-2">
                        <h2 class="text-xl font-semibold text-gray-800">Gangen</h2>
                        <a href="{{ route('admin.courses') }}" class="mt-4 block text-blue-600 hover:underline">Bekijk gangen</a>
                    </div>
                </div>
            </div>

        </div>
        {{--</div>--}}
{{--        end agenda, bevestigingsmail,website, courses--}}
    <span class="inline-flex shadow-xl items-center rounded-md bg-indigo-50 px-2 py-1 font-medium text-indigo-700 text-2xl mt-2 ring-1 ring-inset ring-indigo-700/10">Productbeheer</span>
        <div class="bg-d1 rounded-xl grid grid-cols-1 lg:grid-cols-3 md:grid-cols-2 my-8">
            <div class="bg-white m-5 p-4 rounded-lg flex flex-col md:flex-row justify-start items-start align-text-bottom  hover:bg-gray-50 shadow-lg ring-1 ring-gray-900/5">
                <div class="md:pb-4 w-full md:w-40 p-4 pr-0">
                    <img src="{{ asset('assets/icons/dashboard/dish.svg') }}" alt="gerechten" class="w-10 h-10">
                </div>
                <div class=" md:flex-row flex-col flex justify-between items-start w-full space-y-4 md:space-y-0">
                    <div class="flex flex-col justify-start items-start space-y-2">
                        <h2 class="text-xl font-semibold text-gray-800">Gerechten</h2>
                        <a href="{{ route('admin.gerechten') }}" class="mt-4 block text-blue-600 hover:underline">Bekijk gerechten</a>
                    </div>
                </div>
            </div>

            <div class="bg-white m-5 p-4 rounded-lg flex flex-col md:flex-row justify-start items-start align-text-bottom  hover:bg-gray-50 shadow-lg ring-1 ring-gray-900/5">
                <div class="md:pb-4 w-full md:w-40 p-4 pr-0">
                    <img src="{{ asset('assets/icons/dashboard/ingredients.svg') }}" alt="ingredienten" class="w-10 h-10">
                </div>
                <div class=" md:flex-row flex-col flex justify-between items-start w-full space-y-4 md:space-y-0">
                    <div class="flex flex-col justify-start items-start space-y-2">
                        <h2 class="text-xl font-semibold text-gray-800">Ingredienten</h2>
                        <a href="{{ route('admin.ingredienten') }}" class="mt-4 block text-blue-600 hover:underline">Bekijk ingredienten</a>
                    </div>
                </div>
            </div>

            <div class="bg-white m-5 p-4 rounded-lg flex flex-col md:flex-row justify-start items-start align-text-bottom  hover:bg-gray-50 shadow-lg ring-1 ring-gray-900/5">
                <div class="md:pb-4 w-full md:w-40 p-4 pr-0">
                    <img src="{{ asset('assets/icons/dashboard/cookies.svg') }}" alt="cookies" class="w-10 h-10">
                </div>
                <div class=" md:flex-row flex-col flex justify-between items-start w-full space-y-4 md:space-y-0">
                    <div class="flex flex-col justify-start items-start space-y-2">
                        <h2 class="text-xl font-semibold text-gray-800">Koekjesbeheer</h2>
                        <a href="{{ route('admin.koekjesbeheer') }}" class="mt-4 block text-blue-600 hover:underline">Bekijk koekjesbeheer</a>
                    </div>
                </div>
            </div>

            <div class="bg-white m-5 p-4 rounded-lg flex flex-col md:flex-row justify-start items-start align-text-bottom  hover:bg-gray-50 shadow-lg ring-1 ring-gray-900/5">
                <div class="md:pb-4 w-full md:w-40 p-4 pr-0">
                    <img src="{{ asset('assets/icons/dashboard/menu.svg') }}" alt="menubeheer" class="w-10 h-10">
                </div>
                <div class=" md:flex-row flex-col flex justify-between items-start w-full space-y-4 md:space-y-0">
                    <div class="flex flex-col justify-start items-start space-y-2">
                        <h2 class="text-xl font-semibold text-gray-800">Menubeheer</h2>
                        <a href="{{ route('admin.menubeheer') }}" class="mt-4 block text-blue-600 hover:underline">Bekijk menubeheer</a>
                    </div>
                </div>
            </div>

            <div class="bg-white m-5 p-4 rounded-lg flex flex-col md:flex-row justify-start items-start align-text-bottom  hover:bg-gray-50 shadow-lg ring-1 ring-gray-900/5">
                <div class="md:pb-4 w-full md:w-40 p-4 pr-0">
                    <img src="{{ asset('assets/icons/dashboard/cocktail.svg') }}" alt="cocktails" class="w-10 h-10">
                </div>
                <div class=" md:flex-row flex-col flex justify-between items-start w-full space-y-4 md:space-y-0">
                    <div class="flex flex-col justify-start items-start space-y-2">
                        <h2 class="text-xl font-semibold text-gray-800">Cocktailbeheer</h2>
                        <a href="{{ route('admin.cocktailbeheer') }}" class="mt-4 block text-blue-600 hover:underline">Bekijk cocktailbeheer</a>
                    </div>
                </div>
            </div>

        </div>
        {{--end Gerechten, Ingredienten, Koekjesbeheer, Menubeheer, Cocktailbeheer--}}








    <x-tmk.livewire-log/>
</div>

