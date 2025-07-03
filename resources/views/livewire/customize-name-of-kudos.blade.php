<x-jet-form-section submit="updateCustomizedNameOfKudos">
    <x-slot name="title">
        {{ __('Customize Name of Kudos') }}
    </x-slot>

    <x-slot name="description">
        Update customized name of "Kudos"
    </x-slot>

    <x-slot name="form">
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="customized_name_of_kudos" value='Customized Name Of "KUDOS"'/>
            <x-jet-input id="customized_name_of_kudos" type="text" required class="mt-1 block w-full"
                         wire:model.defer="customized_name_of_kudos"/>
            <x-jet-input-error for="customized_name_of_kudos" class="mt-2"/>
        </div>
    </x-slot>

    <x-slot name="actions">
        <x-jet-action-message class="mr-3 text-green-500" on="saved">
            {{ __('Company settings updated successfully.') }}
        </x-jet-action-message>

        <x-jet-button>
            {{ __('Save') }}
        </x-jet-button>
    </x-slot>
</x-jet-form-section>
