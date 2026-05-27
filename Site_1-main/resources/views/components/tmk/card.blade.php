<div class="border shadow-2xl">
    <h2 class="p-2 bg-gray-800 text-white">
        {{ $title ?? 'Card title' }}
    </h2>
    <div class="p-4">
        {{ $slot }}
    </div>
    <div class="p-2 bg-gray-800 text-white">
        {{ $footer ?? 'Card footer' }}
    </div>
</div>
