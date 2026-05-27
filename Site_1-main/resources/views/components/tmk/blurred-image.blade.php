{{-- x-tmk-blurred-image --}}
@props(['src', 'alt', 'name',  'isCollection' => false])

<div class="relative">

    <img
        src="{{ asset(Storage::disk('public')->exists('cookiepictures/' . $src) ?
             'storage/cookiepictures/' . $src . "?v=" . time() :
             'storage/cookiepictures/placeholder.png') }}"
        alt="{{ $alt }}"
        {{ $attributes->merge(['class' => "w-full h-64 object-cover mb-4 rounded-lg transform blur hover:blur-0 transition duration-500 hover:drop-shadow-lg ease-in-out shadow-lg"]) }}
    >

    <h2 {{ $attributes->merge(['class' => "absolute bottom-4 left-4 text-gray-400 bg-gray-100 text-xl font-bold rounded-md p-1 m-1"]) }}>
        {{ $name }}
    </h2>

</div>
