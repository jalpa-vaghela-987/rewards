<div>
    <div class="mt-5">
        <div>
            <div class="col-span-6 sm:col-span-4 mb-5">
                <div class="w-full">
                    <div>
                        <div class="italic text-sm">
                            Add to balance
                        <!--  <br> Default Card: {{ucfirst($card_brand)}} ending with {{$last4}}. -->
                        </div>

                        <div class="flex">
                            <div class="mt-1 relative rounded-md shadow-sm w-full sm:w-2/4">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 sm:text-sm sm:m-0 -mt-1">$</span>
                                </div>

                                <x-jet-input id="amount" type="number" name="price" id="price" min="10" max="10000"
                                             step="1"
                                             class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-7 pr-12 sm:text-sm border-gray-300 rounded-md"
                                             placeholder="1,000"
                                             pattern="^\d+(?:\.\d{1,2})?$" wire:model.defer="amount"
                                             wire:keyup.enter="setUpStripe"
                                />
                            </div>

                            <button class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md font-semibold text-xs text-white uppercase tracking-widest shadow-sm hover:text-gray-100 focus:outline-none  focus:shadow-outline-blue active:text-gray-100 active:bg-gray-50 transition ease-in-out duration-150 bg-green-500 text-white ml-2 hover:opacity-75"
                                    wire:click="setUpStripe" wire:loading.class="opacity-25">
                                <span wire:target="setUpStripe" wire:loading wire:loading.class="mr-0.5">
                                    <i class="fa fa-spinner fa-spin"></i>
                                </span> {{ __('Proceed') }}
                            </button>
                        </div>
                    </div>
                </div>

                <x-jet-input-error for="amount" class="mt-2"/>
            </div>
        </div>
    </div>

    <!-- Confirmation Modal -->
    <x-confirmation-modal wire:model="confirmingSend">
        <x-slot name="title">
            Continue to Checkout!
        </x-slot>

        <x-slot name="content">
            <div class="mt-5">
                <span class="font-bold">Submitting here will not charge {{ $company->name}}.</span><br><br>
                {{ appName() }} uses Stripe for payments for enhanced security. PerkSweet does not store any payment information.<br><br>
            <!-- {{ ucfirst($card_brand) }} card ending with {{ $last4 }}. -->
            </div>

            <div class="mt-0">
                Following the transaction, {{$company->name}} will have a total balance of
                ${{number_format((floatval($balance)+floatval($amount)),2)}}.
            </div>

            <div></div>

            <div class="mt-3 italic">
                Thank you for using {{ appName() }}.
            </div>
        </x-slot>

        <x-slot name="footer">
            <div class="sm:flex sm:flex-row sm:justify-end inline">
                <div class="sm:mr-2 sm:mb-0 mb-2">
                    <x-jet-secondary-button class="w-full sm:w-auto" style="display: inline !important;" wire:click="$toggle('confirmingSend')" wire:loading.attr="disabled">
                        {{ __('Not Now') }}
                    </x-jet-secondary-button>
                </div>

                <div>
                    {!! htmlspecialchars_decode($this->button) !!}
                </div>
            </div>
        </x-slot>
    </x-confirmation-modal>
</div>
