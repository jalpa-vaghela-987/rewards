<x-jet-form-section submit="saveConnectSettings">
    <x-slot name="title">
    {{ __(appName().' Connect Settings') }}
    <!-- updateProfileInformation -->
    </x-slot>

    <x-slot name="description">
        {{ __('Allow users to enroll in '. appName() .' Connect, an automatic one-on-one zoom meeting scheduler within your company.') }}
    </x-slot>

    <x-slot name="form">
        <!-- Kudos -->
        <div class="col-span-6 sm:col-span-4 flex">
            <input id="enable_connect" name="enable_connect" type="checkbox" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded" wire:model.defer="enable_connect">
            <label for="enable_connect" class="ml-2 block text-sm text-gray-900">
                {{ __('Enable '. appName() .' Connect') }}
            </label>
            <x-jet-input-error for="enable_connect" class="mt-2"/>
        </div>

    </x-slot>

    <x-slot name="actions">
        <x-jet-action-message class="mr-3 text-green-500" on="saved">
            {{ __(appName().' connect setting updated successfully') }}
        </x-jet-action-message>

        <x-jet-button wire:target="photo">
            {{ __('Save') }}
        </x-jet-button>
    </x-slot>
</x-jet-form-section>
