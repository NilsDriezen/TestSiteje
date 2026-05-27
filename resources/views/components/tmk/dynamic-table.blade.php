<!-- DynamicTable.blade.php -->

@props(['columns', 'orderBy', 'orderAsc', 'lines'])

<div class="">
    {{--    // Sectie om de tabel te maken op basis van de kolomnamen (uitgezonderd timestamps--}}
    <x-tmk.section class="py-0">
        <x-tmk.filter :lines="$lines"/>

        <table class="min-w-full border border-gray-300 {{ $attributes->get('class') }}">
            <thead>
            <tr class="bg-gray-100 text-gray-700 [&>th]:p-2">
                @foreach ($columns as $column)
                    <x-tmk.sort-table-header columnName="{{ $column }}" orderBy="{{ $orderBy }}"
                                             orderAsc="{{ $orderAsc }}"/>
                @endforeach
                <!-- Extra kolomkop voor de potlood/vuilbakknop -->
                    @if (!$lines->isEmpty())
                        <th id="actions">Bewerk</th>
                    @endif
            </tr>
            </thead>
            <tbody>
            {{ $slot }}
            </tbody>
        </table>

        {{-- No records found --}}
        @if($lines  ->isEmpty())
            <x-tmk.alert type="danger" class="w-full">
                Niets gevonden!
            </x-tmk.alert>
        @endif

        <div class="my-4">
            {{ $lines->links() }} {{-- Pagination Links --}}
        </div>
    </x-tmk.section>
</div>

