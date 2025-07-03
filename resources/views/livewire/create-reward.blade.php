<div class="mt-10 mx-5 mb-10">
    <x-jet-form-section submit="updateReward">
        <x-slot name="title">
            Create Custom Reward!
            <!-- updateProfileInformation -->
        </x-slot>

        <x-slot name="description">
            {{ appName() }} allows admin users to create custom rewards that can be redeemed internally! These custom rewards
            can include local partner gift cards, perks, travel, and gift cards from corporate credit card points.
        </x-slot>

        <x-slot name="form">
            <!-- Kudos -->
            <div class="col-span-6 sm:col-span-4">
                <x-jet-label for="title" value="{{ __('Custom Reward Title') }}"/>
                <x-jet-input id="title" type="text" min="0" max="100" maxlength="100" class="mt-1 block w-full"
                             wire:model="title"/>
                <x-jet-input-error for="title" class="mt-2"/>
            </div>

            <div class="col-span-6 sm:col-span-4">
                <x-jet-label for="description" value="{{ __('Custom Reward Description') }}"/>
                <textarea id="description"
                          class="mt-1 block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                          style="min-height: 100px;" wire:model="description" maxlength="2000" >
                </textarea>
                <x-jet-input-error for="description" class="mt-2"/>
            </div>

<!--             <div class="col-span-6 sm:col-span-4">
                <div class="flex">
                    <input id="use_set_amount" name="use_set_amount" type="checkbox"
                           class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                           wire:model="use_set_amount">
                    <label for="use_set_amount" class="ml-2 block text-sm text-gray-900">
                        {{ __('Use a Set Value for the Reward?') }}
                    </label>
                </div>
                <div class="italic text-xs my-1">Choosing a set value is perfect for rewards without a specific monetary
                    redemption value.<br>
                    Examples: $10 Store Gift Card, Specific Company Swag, Extra Vacation Day, All Expense Paid Trip,
                    ect.
                </div>
                <x-jet-input-error for="use_set_amount" class="mt-2"/>
            </div>
 -->
            <div class="col-span-6 sm:col-span-4">
                <div class="" x-data="{photoName: null, photoPreview: null}">
                    <input type="file"
                           class="hidden"
                           wire:model="photo"
                           x-ref="photo"
                           accept="image/*"
                           x-on:change="
                            photoName = $refs.photo.files[0].name;
                            const reader = new FileReader();
                            reader.onload = (e) => {
                                photoPreview = e.target.result;
                            };
                            reader.readAsDataURL($refs.photo.files[0]);"/>

                    <x-jet-label for="photo" value="{{ __('Logo') }}"/>

                    <div class="mt-2 w-40 h-40 relative" x-show="photoPreview">
                        <div class="absolute -right-1 -top-4 cursor-pointer"
                             x-on:click="$wire.set('photo', null); photoPreview=false;">
                            <span class="fa-stack">
                                <i class="fas fa-circle fa-stack-2x text-gray-300"></i>
                                <i class="fas fa-times fa-stack-1x fa-inverse"></i>
                            </span>
                        </div>

                        <span class="block h-full"
                              x-bind:style="'background-size: contain; background-repeat: no-repeat; background-position: center center; background-image: url(\'' + photoPreview + '\');'">
                        </span>
                    </div>

                    <x-jet-secondary-button class="mt-2 mr-2" type="button" x-on:click.prevent="$refs.photo.click()">
                        {{ __('Select Picture') }}
                    </x-jet-secondary-button>
                </div>
            </div>

        <div class="col-span-6 sm:col-span-4">
                    <x-jet-label  for="currency" value="{{ __('Select Gift Card Currency') }}"/>
                <select name="currency"
                        class="border-gray-300 focus:border-indigo-300 focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mr-5 my-1 w-40 sm:w-38 md:w-28 lg:w-44"
                        wire:model="currency">
                    @foreach(\App\Models\Tango::all()->where('disable',0)->where('active',1)->pluck("currency")->flatten()->unique()->sort()->values()->all() as $currency2)
                        <option value="{{ $currency2 }}">
                            {{ $currency2 }}
                        </option>
                    @endforeach
                </select>

            </div>

            <div class="col-span-6 sm:col-span-4" style="height: 500px;">
                <x-jet-label value="{{ __('Reward Preview:') }}"/>
                <div class="grid grid-cols-1 justify-center">
                    <div class="w-full italic mx-4">Front</div>
                    <div class="gift_card self-start">
                        @if ($photo ?? "")
                            <div
                                style="min-height: 190px; max-height: 190px; height: 190px !important; min-width: 300px; max-width: 300px; width: 300px; !important;"
                                class="border border-gray-400 shadow-xl rounded-xl m-auto m-2 sm:m-4 overflow-hidden bg-gray-100 front self-start mt-1">
                                @php
                                    if($reward && !(filter_var($photo, FILTER_VALIDATE_URL) === FALSE)) {
                                        $url = $photo;
                                    } else {
                                        $url = $photo->temporaryUrl();
                                    }
                                @endphp

                                <img class="shadow-xl rounded-xl w-full h-full" src="{{ $url }}">

{{--                                <img class="shadow-xl rounded-xl w-full h-full" src="{{ $reward ? $photo : $photo->temporaryUrl() }}">--}}
                            </div>
                        @else
                            <div
                                style="min-height: 190px; max-height: 190px; height: 190px !important; min-width: 300px; max-width: 300px; width: 300px; !important;"
                                class="border border-gray-400 shadow-xl rounded-xl m-auto m-2 sm:m-4 overflow-hidden bg-gray-100 front self-start mt-1">
                                <div class="font-handwriting text-xl mx-auto mt-3 w-full text-center flex flex-col break-words">
                                    {{ $title ?? "Reward Title" }}
                                </div>

                                <div class="w-full" style="height: 115px;">
                                    <img class="object-contain mx-auto mt-2" style="height:50px;"
                                         src="{!! Auth::user()->company->logo_path !!}"/>
                                </div>

                                <div class="italic w-full text-sm mt-auto ml-3">
                                    {{ substr(Auth::user()->company->name, 0, 50) }} Custom Reward
                                </div>
                            </div>
                        @endif

                        <div class="w-full italic mx-4 mt-7">Back</div>
                        <div class="back overflow-y-hidden border border-gray-200 shadow-xl rounded sm:m-4 mt-1"
                             style="min-height: 190px;  height: 190px !important; max-width: 300px; width: 100%; !important;">
                            <div style="min-height: 100px;">
                                <div class="text-center px-3 pb-6 pt-2">
                                    <a class="text-black text-xls bold font-sans py-5 cursor-auto break-words"
                                       href="javascript:void(0);">
                                        {{$title ?? "Title Here"}}
                                    </a>
                                    <div class="w-full border-b-2"></div>
                                    <div class="mt-2 text-xs font-sans font-light text-grey-dark italic break-words"
                                         style="height: 150px; text-overflow: ellipsis;">
                                        {{$description}}
                                    </div>
                                </div>
                            </div>
                            <x-link-button class="ml-5 mr-5 my-3">
                                {{ __('Redeem') }}
                            </x-link-button>
                        </div>
                    </div>

                </div>

            </div>

            @if($use_set_amount)
                <div class="col-span-6 sm:col-span-4">
                    <x-jet-label for="cost" value="{{ __('Cost of Reward (in ' . getReplacedWordOfKudos() . ')') }}"/>
                    <x-jet-input id="cost" type="number" min="0" max="100000" class="mt-1 block w-full"
                                 wire:model="cost"/>
                    <div class="italic text-xs my-1">
                       Typically, {{number_format(getCustomizeNumberOfKudos()/getCurrencyRate($currency),1)}} {{ getReplacedWordOfKudos() }} on {{ appName() }}
                                    is worth {{currencyNumber(1,$currency)}}
                        
                    </div>
                    @if($cost>0)
                        <div class="italic text-xs my-1">Based on {{ appName() }}'s current {{ getReplacedWordOfKudos() }} conversion rate of {{number_format(getCustomizeNumberOfKudos()/getCurrencyRate($currency),1)}} {{ getReplacedWordOfKudos() }}
                            per {{currencyNumber(1,$currency)}}, this reward should cost <span
                                class="font-semibold">~{{currencyNumber(convertKudos($cost, $currency),$currency)}}</span></div>
                    @endif
                    <x-jet-input-error for="cost" class="mt-2"/>
                </div>
            @else


                <div class="col-span-6 sm:col-span-4">
                    <x-jet-label for="min_kudos_value" value="{{ __('Custom Reward Cost Minimum (in ' . getReplacedWordOfKudos() . ')') }}"/>
                    <x-jet-input id="min_kudos_value" type="number" min="100" max="100000" class="mt-1 block w-full"
                                 wire:model="min_kudos_value"/>
                    <x-jet-input-error for="min_kudos_value" class="mt-2"/>
                </div>

                <div class="col-span-6 sm:col-span-4">
                    <x-jet-label for="max_kudos_value" value="{{ __('Custom Reward Cost Maximum (in Kudos)') }}"/>
                    <x-jet-input id="max_kudos_value" type="number" min="0" max="1000000" class="mt-1 block w-full"
                                 wire:model="max_kudos_value"/>
                    <x-jet-input-error for="max_kudos_value" class="mt-2"/>
                </div>

                <div class="col-span-6 sm:col-span-4">
                    <x-jet-label for="kudos_conversion_rate"
                                 value="{{ __('Kudos Required per Dollar (Kudos Conversion Rate)') }}"/>
                    <x-jet-input id="kudos_conversion_rate" type="number" min="10" max="10000" class="mt-1 block w-full"
                                 wire:model="kudos_conversion_rate"/>
                    <div class="italic text-xs my-1">{{ appName() }} by default provides $1.00 of the reward for every 100
                        Kudos. <br> {{ appName() }} allows for flexibility in the conversion rate to incentivize or
                        disincentize specific rewards. If you would like to incentize this reward you can allow a rate
                        of 80 Kudos to redeem $1.00. The recipient will receive a better value on this redemption
                        relative to other rewards. For example, when the recipient redeems for a $5.00 reward this would
                        only require 400 Kudos. <br>If you are unsure about this field, we recommend leaving this value
                        as the default 100 for a standard reward conversion rate.
                    </div>
                    @if($min_kudos_value && $max_kudos_value)
                        <div class="italic font-semibold text-xs my-1">
                            @if($kudos_conversion_rate>10)
                                Users will be able to redeem this reward for any amount between
                                ${{
                number_format(((float)$min_kudos_value)/(float)$kudos_conversion_rate,2)
            }}
                                and
                                ${{
             number_format(((float)$max_kudos_value)/(float)$kudos_conversion_rate,2)
             }}
                                <br>
                                For every 100 Kudos, the user will receive
                                ${{number_format(((float)100)/(float)$kudos_conversion_rate,2)}} of the reward.
                            @endif
                        </div>
                    @endif
                    <x-jet-input-error for="kudos_conversion_rate" class="mt-2"/>
                </div>
            @endif


            <div class="col-span-6 sm:col-span-4">
                <x-jet-label for="redemption_instructions" value="{{ __('Reward Redemption Instructions') }}"/>
                <textarea id="redemption_instructions"
                          class="mt-1 block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                          style="min-height: 100px;" wire:model="redemption_instructions">
            </textarea>
                <div class="italic text-xs my-1">Outline the internal process required by the recipient to redeem this
                    reward.
                </div>
                <x-jet-input-error for="redemption_instructions" class="mt-2"/>
            </div>

            <div class="col-span-6 sm:col-span-4">
                <div class="flex">
                    <input id="enable_inventory_tracking" name="enable_inventory_tracking" type="checkbox"
                           class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                           wire:model="enable_inventory_tracking">
                    <label for="enable_inventory_tracking" class="ml-2 block text-sm text-gray-900">
                        {{ __('Enable Inventory Tracking') }}
                    </label>
                </div>
                <div class="italic text-xs my-1">Utilize the {{ appName() }} inventory tracking system. {{ appName() }} allows you
                    to mark a reward as redeemed to prevent redemptions when the rewards are no longer available.
                </div>
                <x-jet-input-error for="enable_inventory_tracking" class="mt-2"/>
            </div>

            @if($enable_inventory_tracking)
                <div class="col-span-6 sm:col-span-4">
                    <x-jet-label for="stock_amount" value="{{ __('Inventory Amount') }}"/>
                    <x-jet-input id="stock_amount" type="number" min="0" max="1000" class="mt-1 block w-full"
                                 wire:model="stock_amount"/>
                    <div class="italic text-xs my-1">Inventory is tracked using reward units, not reward value. Max:
                        1,000
                    </div>
                    <x-jet-input-error for="stock_amount" class="mt-2"/>
                </div>

            @endif

            <div class="col-span-6 sm:col-span-4">
                <div class="flex">
                    <input id="disabled" name="disabled" type="checkbox"
                           class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                           wire:model.defer="disabled">
                    <label for="disabled" class="ml-2 block text-sm text-gray-900">
                        {{ __('Disable Reward') }}
                    </label>
                </div>
                <div class="italic text-xs my-1">Users will not be able to redeem a disabled reward, but past
                    redemptions will not be changed. Disabling this reward will not delete it.
                </div>
                <x-jet-input-error for="disabled" class="mt-2"/>
            </div>
        </x-slot>

        <x-slot name="actions">
            <x-jet-action-message class="mr-3 text-green-500" on="saved">
                {{ __('Saved.') }}
            </x-jet-action-message>

            <x-jet-button wire:target="photo">
                {{ __('Save') }}
            </x-jet-button>
        </x-slot>
    </x-jet-form-section>


</div>
