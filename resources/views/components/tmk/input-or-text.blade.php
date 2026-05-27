{{--x-tmk.input-or-text.blade.php--}}
@props(['type' => 'text', 'rows' => 3])

@if($type === 'textarea')
    <textarea {{ $attributes->merge(['class' => 'border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm', 'rows' => $rows]) }}></textarea>
@else
    <input {{ $attributes->merge(['class' => 'border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm', 'type' => $type]) }}>
@endif
