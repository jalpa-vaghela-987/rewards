<div>
    <x-jet-action-section>
        <x-slot name="title">
            {{ __('Delete Company') }}
        </x-slot>

        <x-slot name="description">
            {{ __('Permanently delete your company.') }}
        </x-slot>

        <x-slot name="content">
            <div class="max-w-xl text-sm text-gray-600">
                {{ __('Once your company is deleted, all of its resources and data will be permanently deleted. Before deleting your company, please download any data or information that you wish to retain.') }}
            </div>

            <div class="max-w-xl text-sm text-red-600 mt-4">
                Please email <a href="mailto:support@perksweet.com">"support@perksweet.com"</a> to delete a company account.
            </div>

{{--            <div class="mt-5 text-right">--}}
{{--                <x-jet-danger-button wire:click="confirmCompanyDeletion" wire:loading.attr="disabled">--}}
{{--                    {{ __('Delete Company') }}--}}
{{--                </x-jet-danger-button>--}}
{{--            </div>--}}

            <!-- Delete Company Confirmation Modal -->
{{--            <x-jet-dialog-modal wire:model="confirmingCompanyDeletion">--}}
{{--                <x-slot name="title">--}}
{{--                    {{ __('Delete Account') }}--}}
{{--                </x-slot>--}}

{{--                <x-slot name="content">--}}
{{--                    {{ __('Are you sure you want to delete your company? Once your company is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your company.') }}--}}

{{--                    <div class="mt-4" x-data="{}" x-on:confirming-delete-company.window="setTimeout(() => $refs.password.focus(), 250)">--}}
{{--                        <x-jet-input type="password" class="mt-1 block w-3/4"--}}
{{--                                     placeholder="{{ __('Password') }}"--}}
{{--                                     x-ref="password"--}}
{{--                                     wire:model.defer="password"--}}
{{--                                     wire:keydown.enter="deleteCompany" />--}}

{{--                        <x-jet-input-error for="password" class="mt-2" />--}}
{{--                    </div>--}}
{{--                </x-slot>--}}

{{--                <x-slot name="footer">--}}
{{--                    <x-jet-secondary-button wire:click="$toggle('confirmingCompanyDeletion')" wire:loading.attr="disabled">--}}
{{--                        {{ __('Nevermind') }}--}}
{{--                    </x-jet-secondary-button>--}}

{{--                    <x-jet-danger-button class="ml-2" wire:click="deleteCompany" wire:loading.attr="disabled">--}}
{{--                        {{ __('Delete Account') }}--}}
{{--                    </x-jet-danger-button>--}}
{{--                </x-slot>--}}
{{--            </x-jet-dialog-modal>--}}
        </x-slot>
    </x-jet-action-section>

</div>
