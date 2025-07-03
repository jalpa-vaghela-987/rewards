<x-jet-form-section submit="saveSlackSettings">
    <x-slot name="title">
        {{ appName() }} Can Publish {{ getReplacedWordOfKudos() }} on Slack!
    <!-- updateProfileInformation -->
    </x-slot>

    <x-slot name="description">
        {{ appName() }} offers a Slack integration allowing you to share {{ getReplacedWordOfKudos() }} on a channel of your choice for everyone to see. Integrating with Slack allows users to view {{ getReplacedWordOfKudos() }} and encourages users to chime in after without ever leaving their daily work driver. {{ appName() }} highly recommends this integration to increase employee engagement.
    </x-slot>

    <x-slot name="form">
        <!-- Kudos -->
        <div class="col-span-6 sm:col-span-4 flex">
            <input id="enable_slack" name="enable_slack" type="checkbox" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded" wire:model.defer="enable_slack">
            <label for="enable_slack" class="ml-2 block text-sm text-gray-900">
                {{ __('Enable Slack Notification?') }}
            </label>
            <x-jet-input-error for="enable_slack" class="mt-2"/>
        </div>

    <!-- <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="slack_webhook" value="{{ __('Webhook to Slack (see instructions below)') }}"/>
            <x-jet-input type="text" id="slack_webhook" class="mt-1 w-full"
                         wire:model.defer="slack_webhook" />
            <x-jet-input-error for="slack_webhook" class="mt-2"/>
        </div> -->
        <div class="w-full col-span-6 sm:col-span-4">
            <p class="mb-4">
                {{ appName() }} makes integrating with Slack easy! Simply create a new channel, click the "Add To Slack" button
                below, and allow {{ appName() }} to contribute to the channel.
            </p>

            @if($slack_webhook)
            <p class="mb-5 text-green-600 font-medium">
                {{ appName() }} has been successfully integrated with Slack. Please contact <a href="emailto:support@perksweet.com" class="text-blue-600">support@perksweet.com</a> if you have any issues.
            </p>
            @endif

            <a href="https://slack.com/oauth/v2/authorize?scope=incoming-webhook&client_id=2127807122293.2116129614375&state={{Auth::user()->id}}"
               target="_blank">
                <img alt="Add to Slack" height="40" width="139"
                     src="https://platform.slack-edge.com/img/add_to_slack.png"
                     srcset="https://platform.slack-edge.com/img/add_to_slack.png 1x, https://platform.slack-edge.com/img/add_to_slack@2x.png 2x"/>
            </a>

            <x-jet-input-error for="slack_webhook" class="mt-2"/>

            <div class="italic text-sm mt-2">{{ appName() }} will not be able to read messages or modify any content.
                {{ appName() }} will only be authorized to contribute messages to the channel specified
            </div>
        </div>
        <br><br>


    </x-slot>

    <x-slot name="actions">
        <x-jet-action-message class="mr-3 text-green-500" on="saved">
            {{ __('Slack setting updated successfully') }}
        </x-jet-action-message>

        <x-jet-button wire:target="photo">
            {{ __('Save') }}
        </x-jet-button>
    </x-slot>
</x-jet-form-section>
