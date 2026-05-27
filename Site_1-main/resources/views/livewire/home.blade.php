
<div>
    @if (session('toast'))
        <script>
            window.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: '{{ session('toast.type') }}',
                    title: '{{ session('toast.message') }}',
                    showConfirmButton: false,
                    timer: 3000
                });
            });
        </script>
    @endif


    {{-- Top section of the website (2 images + text) --}}
        <div class="home">
            <img src="{{ $template_webpage->picture_1 }}" alt="Home1" class="top-image align-self: flex-start; pb-2">
            <div class="home-content">
                <div class="content">
                    {{-- Displaying the formatted text with HTML line breaks --}}
                    <p>{!! nl2br(e($template_webpage->content)) !!}</p>
                </div>
                <img src="{{ $template_webpage->picture_2 }}" alt="Home2" class="side-image">
            </div>
        </div>


        <div x-data="{ slide: 0 }">
        <!-- Define the open variable in a parent element -->
        <div x-data="{ open: false }">
            <!-- Review button -->
            <div class="flex justify-end pt-4">
                <button @click="open = true" class="bg-gray-100 border rounded shadow p-2 hover:bg-gray-500 text-black font-bold py-2 px-4 rounded m-4">
                    Review Schrijven
                </button>
            </div>

            <!-- Modal -->
            <div x-show="open" x-cloak class="fixed z-10 inset-0 overflow-y-auto flex items-center justify-center" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                <!-- Semi-transparent black background -->
                <div class="fixed inset-0 bg-black bg-opacity-50" aria-hidden="true"></div>

                <!-- Modal content -->
                <div @click.away="open = false" class="inline-block align-bottom rounded-lg text-left overflow-hidden shadow-xl border border-gray-300 transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full bg-white">
                    <div class="px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <x-tmk.errorbag></x-tmk.errorbag>
                        <div class="flex flex-col items-start w-full">
                            <!-- Input field for the name attribute -->
                            <x-tmk.input-or-text id="newLineName" placeholder="Voeg naam toe"
                                                 wire:model="newLineName"
                                                 wire:keydown.escape="resetValues()"
                                                 class="w-full shadow-md placeholder-gray-300 mb-3"
                                                 :disabled="$isAnonymous">
                                @error('newLineName')
                                <span class="text-red-500">{{ $message }}</span>
                                @enderror
                            </x-tmk.input-or-text>
                            <!-- Textarea for the message attribute -->
                            <x-tmk.input-or-text type="textarea" id="newLineMessage"
                                                 placeholder="Voeg bericht toe"
                                                 wire:model="newLineMessage"
                                                 wire:keydown.escape="resetValues()"
                                                 class="w-full shadow-md placeholder-gray-300 mb-3">
                                @error('newLineMessage')
                                <span class="text-red-500">{{ $message }}</span>
                                @enderror
                            </x-tmk.input-or-text>


                            <!-- Anonymous checkbox -->
                            <div class="form-check margin-bottom: 1rem;">
                                <x-checkbox class="form-check-input" id="anonymousCheckbox" wire:model="isAnonymous" />
                                <label class="form-check-label" for="anonymousCheckbox">Ik wil dit anoniem posten</label>
                            </div>

                            <!-- Create button -->
                            <x-button wire:click="createOrUpdate" class="flex justify-center mt-1">Voeg toe</x-button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Displaying reviews --}}
        @foreach($reviews as $index => $review)
            <div x-show="slide === {{ $index }}" class="relative p-6 bg-gray-100 border rounded shadow flex flex-col justify-center items-center mx-auto">
                {{-- Left arrow --}}
                <button
                    class="absolute left-0 top-1/2 transform -translate-y-1/2 mx-1 p-2 hover:text-gray-400 text-4xl"
                    @click="slide = slide === 0 ? {{ count($reviews) - 1 }} : slide - 1"
                >
                    &lt;
                </button>

                <div class="px-10">
                    <!-- Displaying review message with HTML line breaks -->
                    <p class="text-lg mb-2">{!! nl2br(e($review->message)) !!}</p>
                    <h4 class="font-bold text-sm ml-2 justify-start">{{ $review->name }}</h4>
                </div>

                {{-- Right arrow --}}
                <button
                    class="absolute right-0 top-1/2 transform -translate-y-1/2 mx-1 p-2 hover:text-gray-400 text-4xl"
                    @click="slide = slide === {{ count($reviews) - 1 }} ? 0 : slide + 1"
                >
                    &gt;
                </button>
            </div>
        @endforeach
    </div>
</div>

