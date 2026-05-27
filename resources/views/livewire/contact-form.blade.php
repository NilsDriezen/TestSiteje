
<form
    wire:submit="sendEmail()"
>
    <div class="grid grid-cols-2 gap-4">
        <div class="col-span-2 md:col-span-1">
            <x-label for="name" value="Naam"/>
            <x-input type="text" id="name" name="name" class="block mt-1 w-full"
                     wire:model.live.debounce.500ms="name"
                     placeholder="Jouw naam"/>
            <x-input-error for="name" class="mt-2"/>
        </div>
        <div class="col-span-2 md:col-span-1">
            <x-label for="email" value="Email"/>
            <x-input type="email" id="email" name="email" placeholder="Jouw email"
                     wire:model.live.debounce.500ms="email"
                     class="block mt-1 w-full"/>
            <x-input-error for="email" class="mt-2"/>
        </div>
        <div class="col-span-2">
            <x-label for="message" value="Bericht"/>
            <x-tmk.form.textarea id="message" name="message" rows="5" placeholder="Jouw bericht"
                                 wire:model.live.debounce.500ms="message"
                                 class="block mt-1 w-full">
            </x-tmk.form.textarea>
            <x-input-error for="message" class="mt-2"/>
        </div>
        <div class="col-span-2">
            <x-tmk.form.button
                                disabled="{{ !$canSubmit }}"
                class="col-span-2">Verstuur bericht</x-tmk.form.button>
        </div>
    </div>
</form>
