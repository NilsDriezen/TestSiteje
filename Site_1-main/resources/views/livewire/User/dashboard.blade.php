<div>
    <x-slot name="subtitle">
        Welkom {{ Auth::user()->first_name }} {{ Auth::user()->last_name }}
        <br>
        @if(!Auth::user()->admin)
            <span class="inline-flex items-center rounded-md bg-indigo-50 px-2 py-1 font-medium text-indigo-700 text-2xl mt-2 ring-1 ring-inset ring-indigo-700/10">Personeel</span>
        @endif
    </x-slot>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        <div class="bg-white p-4 shadow rounded-lg">
            <h2 class="text-xl font-semibold text-gray-800">Reservaties</h2>
            <a href="{{ route('admin.reservaties') }}" class="mt-4 block
            text-blue-600 hover:underline">Bekijk reservaties</a>
        </div>
        <div class="bg-white p-4 shadow rounded-lg">
            <h2 class="text-xl font-semibold text-gray-800">Koekjes ({{ $todayCount }})</h2>
            <a href="{{ route('user.koekjesbestellingen') }}" class="mt-4 block text-blue-600 hover:underline">Bekijk koekjes </a>
        </div>
        <div class="bg-white p-4 shadow rounded-lg">
            <h2 class="text-xl font-semibold text-gray-800">Planning</h2>
            <a href="{{ route('user.planning') }}" class="mt-4 block text-blue-600 hover:underline">Bekijk de planning</a>
        </div>
    </div>
</div>
