<!-- resources/views/components/SortTableHeader.blade.php -->

{{--functie schrijven!--}}
{{--public function resort($column)--}}
{{--{--}}
{{--$this->orderBy === $column ?--}}
{{--$this->orderAsc = !$this->orderAsc :--}}
{{--$this->orderAsc = true;--}}
{{--$this->orderBy = $column;--}}
{{--}--}}

@props(['columnName', 'orderBy', 'orderAsc', 'displayText' => null])

@php

    $displayText =  $columnName;
@endphp

@if ($columnName !== 'picture_path')
<th wire:click="resort('{{ $columnName }}')" {{ $attributes->merge(['class' => ""])}}>
    <div class="flex cursor-pointer">
        <span data-tippy-content="Sorteer op {{ __($displayText) }}">{{ __($columnName) }}</span>
        <x-heroicon-s-chevron-up
            class="w-5 text-slate-400 ml-1 mt-1 {{$orderAsc ?: 'rotate-180'}} {{$orderBy === $columnName ? 'inline-block' : 'opacity-0'}}"/>
    </div>
</th>
@else
    <th {{ $attributes->merge(['class' => "text-left"])}}>
        <span >{{ __($columnName) }}</span>
    </th>
@endif
