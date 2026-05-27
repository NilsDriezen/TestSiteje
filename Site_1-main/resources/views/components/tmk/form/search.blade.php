@props([
    'model' => 'search',
    'live' => false,
    'debounce' => 500,
    'placeholder' => 'Search...',
])
@php
    $live = filter_var($live, FILTER_VALIDATE_BOOLEAN);
@endphp
<div {!! $attributes->merge(['class' => 'relative w-full']) !!}>
    <input type="text"
    {{ $live ? "wire:model.live.debounce.${debounce}ms" : 'wire:model' }}="{{ $model }}"
    class="w-full pl-10 border-gray-300 focus:border-[#A79A66] focus:ring-[#A79A66] rounded-md shadow-sm"
    placeholder="{{ $placeholder }}"/>
    <x-phosphor-magnifying-glass class="absolute top-3 ml-3 w-5 h-5 text-gray-400"/>
    <button
        x-show="$wire.{{ $model }}"
        wire:click="$set('{{ $model }}', '')"
        class="w-5 absolute right-4 top-3 text-gray-400">
        <x-phosphor-x/>
    </button>
</div>
