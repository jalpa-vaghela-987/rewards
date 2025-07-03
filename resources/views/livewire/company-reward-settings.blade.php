<div>
    <form wire:submit.prevent="saveCompanyRewardSettings">
        <div class="bg-white py-5 sm:rounded-tl-md sm:rounded-tr-md">
            <div class="grid grid-cols-6 gap-6">
                <div class="col-span-6 sm:col-span-4">
                    <div class="flex">
                        <input id="allow_tango_cards" name="allow_tango_cards" type="checkbox"
                               class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                               wire:model="allow_tango_cards">
                        <label for="allow_tango_cards" class="ml-2 block text-sm text-gray-900">
                            {{ __('Allow '. appName() .' Partner Rewards') }}
                        </label>
                    </div>
                    <div class="italic text-xs my-0">Enabling this field allows users to redeem
                        {{ getReplacedWordOfKudos() }}
                        for rewards provided by {{ appName() }} partners.
                    </div>
                    <div class="italic text-xs my-2">
                        Users will <span class="font-bold">{{$allow_tango_cards ? "" : "not"}}</span> be able to redeem
                        rewards provided by {{ appName() }} partners
                    </div>
                    <x-jet-input-error for="allow_tango_cards" class="mt-2"/>
                </div>
            </div>
        </div>



        <div class="flex items-center justify-end px-4 py-3 text-right sm:px-6 sm:rounded-bl-md sm:rounded-br-md">
            <x-jet-action-message class="mr-3 text-green-500" on="saved">
                {{ __('Saved.') }}
            </x-jet-action-message>

            <x-jet-button>
                {{ __('Save') }}
            </x-jet-button>
        </div>
    </form>
</div>
