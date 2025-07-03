<x-app-layout>
    <div>
        <style>
            [x-cloak] {
                display: none;
            }
        </style>

        <div class="container mx-auto px-4 py-10 md:py-12">
            <div class="flex-cols sm:flex">
                <div class="w-full sm:w-1/3 mr-5">
                    <x-jet-section-title>
                        <x-slot name="title">
                            {{ __('Choose Recipients!') }}
                        </x-slot>

                        <x-slot name="description">
                            {{ __('Choose who you would like to be allowed to contribute to the card.') }}

                        </x-slot>
                    </x-jet-section-title>
                </div>

                @livewire('card-people', ['card' => $card])
            </div>
        </div>
    </div>
</x-app-layout>
