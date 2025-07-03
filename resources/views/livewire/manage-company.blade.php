<div>
    <div class="container mx-auto px-4 py-10 md:py-12">
        <div>
            <div class="container mx-auto px-4 py-5 md:py-10">
                <div class="w-full">
                    @livewire('update-company', ['company' => $company])
                    <x-jet-section-border/>
                </div>
            </div>

            <div class="container mx-auto px-4 py-5 md:py-10">
                <div class="w-full">
                    @livewire('update-kudos-settings')
                    <x-jet-section-border/>
                </div>
            </div>

            <div class="container mx-auto px-4">
                <div class="w-full">
                    @livewire('manage-connect-settings')
                    <x-jet-section-border/>
                </div>
            </div>

            <div class="container mx-auto px-4">
                <div class="w-full">
                    @if (!$viewMoreAdvancedSettings)
                        <a class="w-max col-start-1 col-span-12 mb-1 italic text-blue-800 text-sm mt-1 pt-1"
                           href="javascript:void(0)"
                           wire:click="$toggle('viewMoreAdvancedSettings')">
                            View More Advanced Settings
                        </a>
                    @else
                        <a class="w-max col-start-1 col-span-12 mb-1 italic text-blue-800 text-sm mt-1 pt-1"
                           href="javascript:void(0)"
                           wire:click="$toggle('viewMoreAdvancedSettings')">
                            Hide More Advanced Settings
                        </a>
                    @endif
                </div>
            </div>


            @if ($viewMoreAdvancedSettings)

                <div class="container mx-auto px-4 py-5 md:py-10">
                    <div class="w-full">
                        @livewire('slack-settings')
                        <x-jet-section-border/>
                    </div>
                </div>

                <div class="container mx-auto px-4 py-5 md:py-10">
                    <div class="w-full">
                        @livewire('microsoft-teams-settings')
                        <x-jet-section-border/>
                    </div>
                </div>

                <div class="container mx-auto px-4 py-5 md:py-10">
                    <div class="w-full">
                        @livewire('customize-name-of-kudos')
                        <x-jet-section-border/>
                    </div>
                </div>

                <div class="container mx-auto px-4 py-5 md:py-10">
                    <div class="w-full">
                        @livewire('whitelabel-company', ['company' => $company])
                        <x-jet-section-border/>
                    </div>
                </div>

                <div class="container mx-auto px-4 py-5 md:py-10">
                    <div class="w-full">
                        @livewire('delete-company', ['company' => $company])
                    </div>
                </div>
            @endif

        </div>
    </div>
</div>
