<x-jet-form-section submit="updateKudos">
    <x-slot name="title">
    {{ __('Manage Company Settings') }}
    <!-- updateProfileInformation -->
    </x-slot>

    <x-slot name="description">
        Update {{ getReplacedWordOfKudos() }} monthly allowance amounts.
    </x-slot>

    <x-slot name="form">


        <!-- Kudos -->
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="level_1_points_to_give"
                         value="Level 1 User Monthly {{ getReplacedWordOfKudos() }} Allowance"/>
            <x-jet-input id="level_1_points_to_give" type="number" min="0" max="100000" step="1" class="mt-1 block w-full"
                         wire:model.defer="level_1_points_to_give"/>
            <x-jet-input-error for="level_1_points_to_give" class="mt-2"/>
        </div>
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="level_2_points_to_give"
                         value="Level 2 User Monthly {{ getReplacedWordOfKudos() }} Allowance"/>
            <x-jet-input id="level_2_points_to_give" type="number" min="0" max="100000" step="1" class="mt-1 block w-full"
                         wire:model.defer="level_2_points_to_give"/>
            <x-jet-input-error for="level_2_points_to_give" class="mt-2"/>
        </div>

        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="level_3_points_to_give"
                         value="Level 3 User Monthly {{ getReplacedWordOfKudos() }} Allowance"/>
            <x-jet-input id="level_3_points_to_give" type="number" min="0" max="100000" step="1" class="mt-1 block w-full"
                         wire:model.defer="level_3_points_to_give"/>
            <x-jet-input-error for="level_3_points_to_give" class="mt-2"/>
        </div>

        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="level_4_points_to_give"
                         value="Level 4 User Monthly {{ getReplacedWordOfKudos() }} Allowance"/>
            <x-jet-input id="level_4_points_to_give" type="number" min="0" max="100000" step="1" class="mt-1 block w-full"
                         wire:model.defer="level_4_points_to_give"/>
            <x-jet-input-error for="level_4_points_to_give" class="mt-2"/>
        </div>

        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="level_5_points_to_give"
                         value="Level 5 User Monthly {{ getReplacedWordOfKudos() }} Allowance"/>
            <x-jet-input id="level_5_points_to_give" type="number" min="0" max="100000" step="1" class="mt-1 block w-full"
                         wire:model.defer="level_5_points_to_give"/>
            <x-jet-input-error for="level_5_points_to_give" class="mt-2"/>
        </div>

        <div class="col-span-6 py-1">
            <div class="border-t border-gray-200"></div>
        </div>

        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="standard_kudos_value" value="Standard {{ getReplacedWordOfKudos() }} Value"/>
            <x-jet-input id="standard_kudos_value" type="number" min="0" max="100000" step="1" class="mt-1 block w-full"
                         wire:model.defer="standard_kudos_value"/>
            <x-jet-input-error for="standard_kudos_value" class="mt-2"/>
        </div>

        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="super_kudos_value" value="Super {{ getReplacedWordOfKudos() }} Value"/>
            <x-jet-input id="super_kudos_value" type="number" min="0" max="100000" step="1" class="mt-1 block w-full"
                         wire:model.defer="super_kudos_value"/>
            <x-jet-input-error for="super_kudos_value" class="mt-2"/>
        </div>

        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="birthday_kudos_value" value="Birthday {{ getReplacedWordOfKudos() }} Value"/>
            <x-jet-input id="birthday_kudos_value" type="number" min="0" max="100000" step="1" class="mt-1 block w-full"
                         wire:model.defer="birthday_kudos_value"/>
            <x-jet-input-error for="birthday_kudos_value" class="mt-2"/>
        </div>

        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="anniversary_kudos_value" value="Anniversary {{ getReplacedWordOfKudos() }} Value"/>
            <x-jet-input id="anniversary_kudos_value" type="number" min="0" max="100000" step="1" class="mt-1 block w-full"
                         wire:model.defer="anniversary_kudos_value"/>
            <x-jet-input-error for="anniversary_kudos_value" class="mt-2"/>
        </div>

        <div class="col-span-6 py-1">
            <div class="border-t border-gray-200"></div>
        </div>

        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="default_kudos_amount" value="Starting {{ getReplacedWordOfKudos() }} Amount"/>
            <x-jet-input id="default_kudos_amount" type="number" min="0" max="100000" step="1" class="mt-1 block w-full"
                         wire:model.defer="default_kudos_amount"/>
            <x-jet-input-error for="default_kudos_amount" class="mt-2"/>
        </div>
{{--

        <div class="col-span-6 py-1">
            <div class="border-t border-gray-200"></div>
        </div>


        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="customized_number_of_kudos"
                         value="Customized Number of {{ getReplacedWordOfKudos() }} = $1.00"/>
            <x-jet-input id="customized_number_of_kudos" type="number" step="0.0001" min=".01" class="mt-1 block w-full"
                         required
                         wire:model="customized_number_of_kudos"/>

            <div class="italic text-red-500 text-xs mt-2">Warning: Please be advised this will change the value of all
                existing {{ getReplacedWordOfKudos() }} on the platform, Please contact support for any questions
            </div>

            <x-jet-input-error for="customized_number_of_kudos" class="mt-2"/>
        </div>

--}}
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
