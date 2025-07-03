<x-jet-action-section>
    <x-slot name="title">
        {{ __('Mails - Opt (in/out)') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Manage emails to be notified to you in future or not.') }}
    </x-slot>

    <x-slot name="content">
        <h3 class="text-lg font-medium text-gray-900">
            @if ($this->enabled)
                {{ __('You have enabled email notifications.') }}
            @else
                {{ __('You have disabled email notifications.') }}
            @endif
        </h3>

        <div class="mt-3 max-w-xl text-sm text-gray-600">
            <p>
                {{ __('You can disable email notifications(opt out), if you dont want to receive emails from '.config('app.name').' in future.') }}
            </p>
        </div>

        <div class="mt-5">
            @if (! $this->enabled)
                <x-jet-confirms-password wire:then="toggleEmailNotification">
                    <x-jet-button type="button" style="display: flex !important;" class="ml-auto" wire:loading.attr="disabled">
                        {{ __('Enable') }}
                    </x-jet-button>
                </x-jet-confirms-password>
            @else
                <x-jet-confirms-password wire:then="toggleEmailNotification">
                    <x-jet-danger-button wire:loading.attr="disabled" style="display: flex !important;" class="ml-auto">
                        {{ __('Disable') }}
                    </x-jet-danger-button>
                </x-jet-confirms-password>
            @endif
        </div>
    </x-slot>
</x-jet-action-section>
