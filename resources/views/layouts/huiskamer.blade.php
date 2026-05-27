<!doctype html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="{{ $description ?? 'Welkom bij Huiskamer' }}">
    <x-layout.favicons/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>{{ $title ?? 'Huiskamer' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <style>
        .main-content {
            min-height: calc(100vh - 203px)
        }
    </style>
</head>
<body class="font-sans antialiased">
<div class="container mx-auto p-4 pb-0 flex-1 px-4">
    {{--  Navigation  --}}
    @livewire('layout.header')
    {{--    content--}}

    <main class="container mx-auto p-4 pb-0 flex-1 px-4 main-content">

        {{--        Title--}}
        <h1 class="text-3xl mb-4 text-gray-800">
            {{ $subtitle ?? $title ?? "" }}
        </h1>
        <h3 class="text-xl mb-4 text-gray-800">
            {{ $description ?? "" }}
        </h3>
        {{--        main content--}}
        {{ $slot }}
    </main>
    {{--    footer--}}
    @livewire('layout.footer')
</div>
@stack('script')
@livewireScripts
</body>
</html>
