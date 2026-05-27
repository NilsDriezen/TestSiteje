@props([
    'cookie' => 15      // default value is 15
])

{{-- show this (debug) code only in development APP_ENV=local  --}}
@env('local')
    <x-tmk.section
        x-data="{ show: true }"
        @dblclick="show = !show"
        class="bg-yellow-50 mt-8 cursor-pointer">
        <p class="font-bold">What's inside my basket?</p>
        <div x-show="show" x-cloak="">
            <hr class="my-4">
            <p class="text-rose-800 font-bold">Cart::getCart():</p>
            <pre class="text-sm">@json(Cart::getCart(), JSON_PRETTY_PRINT)</pre>
            <hr class="my-4">
            <p class="text-rose-800 font-bold">Cart::getCookies():</p>
            <pre class="text-sm">@json(Cart::getCookies(), JSON_PRETTY_PRINT)</pre>
            <hr class="my-4">
            <p class="text-rose-800 font-bold">Cart::getOneCookie({{$cookie}}):</p>
            <pre class="text-sm">@json(Cart::getOneCookie((int)$cookie), JSON_PRETTY_PRINT)</pre>
            <hr class="my-4">
            <p><span class="text-rose-800 font-bold pr-2">Cart::getKeys():</span>@json(Cart::getKeys(), JSON_PRETTY_PRINT)</p>
            <p><span class="text-rose-800 font-bold pr-2">Cart::getTotalPrice():</span>@json(Cart::getTotalPrice(), JSON_PRETTY_PRINT)</p>
            <p><span class="text-rose-800 font-bold pr-2">Cart::getTotalQty():</span>@json(Cart::getTotalQty(), JSON_PRETTY_PRINT)</p></div>
    </x-tmk.section>
@endenv
