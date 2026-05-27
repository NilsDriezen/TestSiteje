<div class="md:w-3/4">



    <x-tmk.newlinesName
        :columns="$columns"
        :editing="$editing"
        :textarea-columns="$textareaColumns"
        :hidden-columns="['id']"
        :boolean-columns="$booleanColumns"
        :newLineActive="$newLineActive"
     >


    </x-tmk.newlinesName>
    <!-- Usage of the DynamicTable component -->
    <x-tmk.dynamic-table :columns="$columns" :orderBy="$orderBy" :orderAsc="$orderAsc" :lines="$lines" :boolean-columns="$booleanColumns">
        @foreach($lines as $line)

            <tr class="border-t border-gray-300" wire:key="{{ $line->id }}">
                @foreach($columns as $column)

                    @if(in_array($column, $booleanColumns))
                        <td class="px-2">
                                <input type="checkbox" disabled {{ $line->$column ? 'checked' : '' }}>
                        </td>
                    @else
                    <td class="px-2">   {{ Str::limit($line->$column, 50, '...') }}</td>
                    @endif
                @endforeach
                <td class="w-20">
                    <!--   Potlood/vuilbakknop -->
                    <x-tmk.action-button-group :lineId="$line->id" :lineName="$line->name ?? 'line'"/>
                </td>
            </tr>
        @endforeach
    </x-tmk.dynamic-table>

    {{--log linksboven--}}
{{--    <x-tmk.livewire-log :columns="$columns" :lines="$lines"/>--}}
</div>
