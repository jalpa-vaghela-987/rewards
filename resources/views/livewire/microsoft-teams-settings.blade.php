<x-jet-form-section submit="saveMicrosoftTeamsSettings">
    <x-slot name="title">
        {{ appName() }} Can Publish {{ getReplacedWordOfKudos() }} on Microsoft Teams!
    <!-- updateProfileInformation -->
    </x-slot>

    <x-slot name="description">
        {{ appName() }} offers a Microsoft Teams integration allowing you to share {{ getReplacedWordOfKudos() }} on a channel of your choice for everyone to see. Integrating with Microsoft Teams allows users to view {{ getReplacedWordOfKudos() }} and encourages users to chime in after without ever leaving their daily work driver. {{ appName() }} highly recommends this integration to increase employee engagement.
    </x-slot>

    <x-slot name="form">
        <!-- Kudos -->
        <div class="col-span-6 sm:col-span-4 flex">
            <input id="enable_microsoft_teams" name="enable_microsoft_teams" type="checkbox"
                   class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                   wire:model.defer="enable_microsoft_teams">
            <label for="enable_microsoft_teams" class="ml-2 block text-sm text-gray-900">
                {{ __('Enable Microsoft Teams Notification?') }}
            </label>
            <x-jet-input-error for="enable_microsoft_teams" class="mt-2"/>
        </div>

        <div class="w-full col-span-6 sm:col-span-4">
            <p class="mb-4">
                {{ appName() }} makes integrating with Microsoft Teams easy! <a
                    href="https://docs.microsoft.com/en-gb/microsoftteams/platform/webhooks-and-connectors/how-to/add-incoming-webhook#add-an-incoming-webhook-to-a-teams-channel"
                    target="_blank"
                    class="text-blue-600">
                    Click Here
                </a> Simply follow the process.
            </p>

            @if($microsoft_teams_webhook)
                <p class="mb-5 text-green-600 font-medium">
                    {{ appName() }} has been successfully integrated with Microsoft Teams. Please contact <a
                        href="emailto:support@perksweet.com" class="text-blue-600">support@perksweet.com</a> if you have
                    any issues.
                </p>
            @endif

            <x-jet-input id="microsoft_teams_webhook" type="text" class="mt-1 block w-full"
                         wire:model.defer="microsoft_teams_webhook"/>

            <x-jet-input-error for="microsoft_teams_webhook" class="mt-2"/>

            <div class="italic text-sm mt-2">{{ appName() }} will not be able to read messages or modify any content.
                {{ appName() }} will only be authorized to contribute messages to the channel specified
            </div>
        </div>
        <br><br>


    </x-slot>

    <x-slot name="actions">
        <x-jet-action-message class="mr-3 text-green-500" on="saved">
            {{ __('Microsoft Teams setting updated successfully') }}
        </x-jet-action-message>

        <x-jet-button wire:target="photo">
            {{ __('Save') }}
        </x-jet-button>
    </x-slot>
</x-jet-form-section>
