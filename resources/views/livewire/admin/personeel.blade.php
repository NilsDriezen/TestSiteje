<div>
    {{-- Filter --}}
    {{--<x-tmk.section class="mb-4 flex gap-2">--}}
    <x-tmk.section class="mb-4 grid grid-cols-10 gap-4">
        {{--flex-1 relative--}}
        <div class="col-span-10 relative md:col-span-5 lg:col-span-3 flex-grow flex-shrink">
            <x-input id="search" type="text" placeholder="Filter op voornaam of achternaam"
                     class="w-full shadow-md placeholder-gray-300"
                     wire:model="search"
                     wire:model.live="search"
                     wire:model.live.debounce.500ms="search"
            />
            @if(!empty($search))
            <button
                @click="$wire.set('search', '')"
                class="w-5 absolute right-4 top-3 bg-gray-100 hover:bg-green-50">
                <x-phosphor-x/>
            </button>
            @endif
        </div>
        <div class="col-span-10 md:col-span-5 lg:col-span-2 flex-grow flex-shrink flex items-center">
            <x-label for="status" class="mt-3 mr-4 ml-4 mb-4">Status</x-label>
            <select
                wire:model.live="status"
                wire:model.debounce.500ms="status"
                id="status"
                class="col-span-9 md:col-span-4 flex-grow flex-shrink rounded border-gray-300">
                <option value="">Alle</option>
                <option value="true">Actief</option>
                <option value="false">Inactief</option>
            </select>
        </div>

        <div class="col-span-10 md:col-span-5 lg:col-span-2 flex-grow flex-shrink flex items-center">
            <x-label for="perPage" class="mt-3 mr-4 ml-4 mb-4">Per pagina</x-label>
            <x-tmk.form.select id="perPage"
                                 class="col-span-9 md:col-span-4 flex-grow flex-shrink" wire:model="perPage">
                               {{--class="block mt-1 w-full" wire:model="perPage">--}}
                <option value="3">3</option>
                <option value="5">5</option>
                <option value="10">10</option>
                <option value="15">15</option>
                <option value="20">20</option>
            </x-tmk.form.select>
        </div>

        <div class="col-span-10 md:col-span-5 lg:col-span-3 flex-grow flex-shrink flex items-baseline sm:justify-end lg:justify-end">
            <x-button wire:click="newUser" class="block mt-1">
                Nieuw Personeelslid
            </x-button>
        </div>
    </x-tmk.section>

    {{--Personeelstabel--}}
    <x-tmk.section>

        <table class="text-center w-full border border-gray-300">
            <colgroup>
                <col class="w-5 hidden">
                <col class="w-20">
                <col class="w-40">
                <col class="w-5">
                <col class="w-5">
                <col class="w-5">
                <col class="w-5">
            </colgroup>
            <thead>

            <tr class="bg-gray-100 text-gray-700 [&>th]:p-2">
                <th class="hidden">#</th>
                {{--<th>Naam</th>--}}
                <th wire:click="resort('name')">
                    <span
                        data-tippy-content="Sorteer op voornaam">Naam</span><x-heroicon-s-chevron-up
                        class="w-5 text-slate-400
                             {{$orderAsc ?: 'rotate-180'}}
                             {{$orderBy === 'name' ? 'inline-block' : 'hidden'}}"/></th>
                <th>Email</th>
                <th class="text-left">GSM</th>
                <th>Actief</th>
                <th>Admin</th>
                <th class="w-20">

                </th>
            </tr>
            </thead>
            <tbody>
            @forelse($users as $user)
                <tr wire:key="{{ $user->id }}"
                    class="border-t border-gray-300">
                    <td hidden>{{ $user->id }}</td>
                    <td>{{ $user->first_name }} {{ $user->last_name }}</td>
                    {{--<td>{{ $user->email }}</td>--}}
                    <td><a class="text-sky-600 underline" href="mailto:{{ $user->email }}">{{ $user->email}}</a></td>
                    <td class="text-left">{{ $user->phone_number }}</td>
                    <td><input type="checkbox" disabled {{ $user->active ? 'checked' : '' }}  class="rounded"></td>
                    <td><input type="checkbox" disabled {{ $user->admin ? 'checked' : '' }}  class="rounded"></td>
                    <td class="w-20">
                        <div class="border border-gray-300 rounded-md overflow-hidden m-2 grid grid-cols-2 h-10">
                            <button
                                class="text-gray-400 hover:text-sky-100 hover:bg-sky-500 transition border-r border-gray-300"
                                wire:click="editUser({{ $user->id }})">
                                <x-phosphor-pencil-line-duotone class="inline-block w-5 h-5"/>
                            </button>

                            <button @click="$dispatch('swal:confirm', {
                                    title: 'Verwijder {{ $user->first_name }} {{ $user->last_name}}?',
                                    cancelButtonText: 'NEE!',
                                    confirmButtonText: 'JA, VERWIJDER DIT PERSONEEELSLID!',
                                    next: {
                                        event: 'delete-user',
                                        params: {
                                            id: {{ $user->id }}
                                        }
                                    }
                                })"
                                    class="text-gray-400 hover:text-red-100 hover:bg-red-500 transition">
                                <x-phosphor-trash-duotone class="inline-block w-5 h-5"/>
                            </button>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="border-t border-gray-300 p-4 text-center text-gray-500">
                        <div class="font-bold italic text-sky-800">Geen personeel gevonden</div>
                    </td>
                </tr>
            @endforelse
            </tbody>

            <div class="my-4">
                {{ $users->links() }}
            </div>
        </table>



    </x-tmk.section>

    {{--modal--}}
    <x-dialog-modal id="personeelModal" wire:model.live="showModal">
        <x-slot name="title">
            <h2>{{ is_null($personeelForm->id) ? 'Nieuw Gebruiker' : 'Wijzig Gebruiker' }}</h2>
        </x-slot>
        <x-slot name="content">
            {{-- Error messages --}}
            @if ($errors->any())
                <x-tmk.alert type="danger">
                    <x-tmk.list>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </x-tmk.list>
                </x-tmk.alert>
            @endif
            <div class="flex flex-row gap-4 mt-4">
                <div class="flex-1 flex-col gap-2">
                    <x-label for="first_name">Voornaam</x-label>
                    <x-input id="first_name" type="text" wire:model="personeelForm.first_name" class="w-full"/>
                    <x-label for="last_name">Achternaam</x-label>
                    <x-input id="last_name" type="text" wire:model="personeelForm.last_name" class="w-full"/>
                    <x-label for="email">E-mail</x-label>
                    <x-input id="email" type="email" wire:model="personeelForm.email" class="w-full"/>
                    <x-label for="phone_number">Telefoonnummer</x-label>
                    <x-input id="phone_number" type="text" wire:model="personeelForm.phone_number" class="w-full"/>
                    <x-label for="password">Wachtwoord</x-label>
                    <x-input id="password" type="password" wire:model="personeelForm.password" class="w-full"/>
                    <x-label for="password_confirmation">Bevestig Wachtwoord</x-label>
                    <x-input id="password_confirmation" type="password" wire:model="personeelForm.password_confirmation" class="w-full"/>
                    <div>
                        <table class="w-1/2">

                            <tr>
                                <td><input wire:model="personeelForm.active" type="checkbox" {{ $personeelForm->active ? 'checked' : '' }}  class="rounded"></td>
                                <td>
                                    <label for="admin" class="ml-2 block text-sm text-gray-900">Actief</label>
                                </td>
                            </tr>
                            <tr>
                                <td><input wire:model="personeelForm.admin" type="checkbox" {{ $personeelForm->admin ? 'checked' : '' }}  class="rounded"></td>

                                <td>
                                    <label for="admin" class="ml-2 block text-sm text-gray-900">Admin</label>
                                </td>
                            </tr>
                        </table>
                    </div>


                </div>
            </div>
        </x-slot>
        <x-slot name="footer">
            <x-secondary-button @click="$wire.showModal = false">Annuleer</x-secondary-button>

            @if (is_null($personeelForm->id))

                <x-tmk.form.button color="success"
                                   wire:click="createUser"
                                   class="ml-2">Aanmaken
                </x-tmk.form.button>
            @else

                <x-tmk.form.button color="info"
                                   wire:click="updateUser({{ $personeelForm->id }})"
                                   class="ml-2">Opslaan
                </x-tmk.form.button>
            @endif
        </x-slot>
    </x-dialog-modal>
</div>

