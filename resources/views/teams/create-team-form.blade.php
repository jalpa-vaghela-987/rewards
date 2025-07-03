<div class="container">

<x-jet-form-section submit="createTeam">

    <x-slot name="title">
        {{ __('Team Details') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Create a new team to collaborate with others on projects.') }}
    </x-slot>
    <div class="col-span-12">
    <x-slot name="form">
        <div class="col-span-12 md:col-span-6">
            <x-jet-label value="{{ __('Team Owner') }}"/>

            <div class="flex items-center mt-2 md:mt-4">
                <img class="w-12 h-12 rounded-full object-cover" src="{{ $this->user->profile_photo_url }}"
                     alt="{{ $this->user->name }}">

                <div class="ml-4 leading-tight">
                    <div>{{ $this->user->name }}</div>
                    <div class="text-gray-700 text-sm">{{ $this->user->email }}</div>
                </div>
            </div>
        </div>

        <div class="col-span-12 md:col-span-6">
            <x-jet-label for="name" value="{{ __('Team Name') }}"/>
            <x-jet-input id="name" type="text" class="mt-1 block w-full" wire:model.defer="state.name" autofocus maxlength="25"/>
            <x-jet-input-error for="name" class="mt-2"/>
        </div>
    </x-slot>

    <x-slot name="actions">
        <x-jet-button>
            {{ __('Create') }}
        </x-jet-button>
    </x-slot>
    </div>
</x-jet-form-section>
</div>
