<!-- resources/views/components/ActionButtonGroup.blade.php -->
<div>
    <div class="border border-gray-300 rounded-md overflow-hidden m-2 grid grid-cols-2 h-10">

        <button wire:click="editLine({{ $lineId }})" @click="showForm = true"
                class="text-gray-400 hover:text-sky-100 hover:bg-gray-500 transition border-r border-gray-300">
            <x-phosphor-pencil-line-duotone class="inline-block w-5 h-5"/>
        </button>
        <button @click="$dispatch('swal:confirm', {
        title: 'Verwijder {{ $lineName }}?',
        cancelButtonText: 'NEE!',
        confirmButtonText: 'JA, VERWIJDER',
        next: {
            event: 'delete-line',
            params: {
                id: {{ $lineId }}
            }
        }
    })"
                class="text-gray-400 hover:text-red-100 hover:bg-red-500 transition">
            <x-phosphor-trash-duotone class="inline-block w-5 h-5"/>
        </button>


    </div>
</div>
