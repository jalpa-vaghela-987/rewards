<div class="mb-4">
    <x-jet-form-section submit="updateConversionRate">
        <x-slot name="title"></x-slot>

        <x-slot name="description"></x-slot>

        <x-slot name="form">
            <div class="text-sm text-gray-900">
                {{ $reward_currency }} => {{ $base_currency }}
            </div>

            <div class="text-sm text-gray-900">
                <x-jet-input id="base_fx" type="text" required class="w-full block" wire:model="base_fx" />
                <x-jet-input-error for="base_fx" class="mt-2"/>
            </div>
        </x-slot>

        <x-slot name="actions">
            <x-jet-action-message class="mr-3 text-green-500" on="saved">
                {{ __('Conversion rate updated successfully.') }}
            </x-jet-action-message>

            <x-jet-button>
                {{ __('Save') }}
            </x-jet-button>
        </x-slot>
    </x-jet-form-section>
</div>
