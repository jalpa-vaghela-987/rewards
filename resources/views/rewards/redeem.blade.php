<x-app-layout>
    <div class="">
        <div class="border-b-2 block md:flex mx-5 py-10  px-5 rounded  my-10">
            <x-form-section id="redeemForm" submit="{{route('redeem.reward',['reward' => $reward])}}">
                <x-slot name="title">
                    <div class="break-all">
                        Redeem {{$reward->title}}
                    </div>
                </x-slot>

                <x-slot name="description">
                    <div>You can redeem rewards using {{ getReplacedWordOfKudos() }} you have earned!</div>
                    @if($reward->is_custom)
                        @include('components.custom_card',['r' => $reward, 'title'=>$reward->title])
                    @else
                        <img src="{{$reward->photo_path}}" class="shadow-xl sm:m-2 mx-0 my-10 rounded-xl">
                    @endif
                </x-slot>

                <x-slot name="form">
                    <div class="col-span-6 sm:col-span-12">
                        <h2 class="font-bold break-words">
                            {{$reward->title}}



                            @if($reward->approval_needed)
                                <span class="font-medium">
                                (Manual Approval)
                            </span>
                            @endif
                        </h2>
                        <div class="mt-2 text-sm font-sans font-light text-grey-dark break-words">
                            @if($reward->is_custom)
                                {{ $reward->description }}
                            @else
                                {!! $reward->description !!}
                            @endif
                        </div>

                        <br><br>

                        @if($reward->is_custom && $reward->use_set_amount)

                        @else
                            <div class="mt-2 text-sm font-sans font-light text-grey-dark hidden">
                                Minimum Amount: {{currencyNumber(max($reward->min_value,5),$currency)}}
                            </div>


                            @if($reward->is_custom || (Auth::user()->company->balance > 0))

                                <div class="mt-2 text-sm font-sans font-light text-grey-dark hidden">
                                    Maximum Amount: {{currencyNumber(max($reward->max_value,5),$currency)}}

                                </div>
                            @else

                            @endif


                            <div
                                class="mt-2 text-sm font-sans font-light text-grey-dark">{{ getReplacedWordOfKudos() }}
                                Conversion
                                Rate: {{number_format(getCustomizeNumberOfKudos()/$conversionRate,1)}} {{ getReplacedWordOfKudos() }}
                                equals {{currencyNumber(1,$currency)}}
                            </div>

                            @php
                                $tangoData = json_decode($reward->tango_data);
                            @endphp
                            @if($currency !== "USD")
                                <div class="mt-2 text-sm font-sans font-light text-grey-dark font-bold hidden">
                                    {{ $currency }} TO USD :
                                    {{ $conversionRate }}
                                </div>
                            @endif
                        <!-- <div class="mt-2 text-sm font-sans font-light text-grey-dark font-bold value_helper hidden">
                                Value: <span class="dollar_value">0.00</span> <span>{{ $currency }}</span>
                            </div> -->
                        @endif
                        @if($reward->enable_inventory_tracking)
                            <div class="mt-2 text-sm font-sans font-light text-grey-dark">
                                Remaining Rewards: {{number_format($reward->stock_amount)}}
                            </div>
                        @endif



                        @if($reward->is_custom && $reward->use_set_amount)
                            <div class="mt-4 mb-2" style="display: inline-flex">
                                <span class="mr-1">
                                    <x-jet-label for="value" value='{{ getReplacedWordOfKudos() . " to Redeem :" }}'/>
                                </span>
                                <span>
                                    <input type="hidden" name="amount" step="1" min="0" value="{{$reward->cost}}"/>
                                    <div class="w-full font-bold">{{number_format($reward->cost)}}</div>
                                </span>
                                <x-jet-input-error for="amount" class="mt-2 mb-2"/>
                            </div>
                        @else

                            @php

                                //checks if min_allowed is less than $4 USD and uses $4 USD if so (Amazon has no min)
                               //dd($reward->min_value/$conversionRate);

                               if($reward->min_value/$conversionRate < 3) $reward->min_value = round(3*$conversionRate);


                               $min_allowed = round(max($reward->min_value,5)*(getCustomizeNumberOfKudos())/$conversionRate,6);
                               if($reward->max_value) $max_allowed = round(min(max($reward->max_value,0),9999999)*(getCustomizeNumberOfKudos())/$conversionRate,6);
                               else $max_allowed = $min_allowed;



                               $values_allowed = collect([]);

                               // short algo to get good amounts based on conversion rate

                               // most relevant 5 multiple

                               $unit_number = 5;
                               for($aa = 1; $aa<5;$aa++){
                                   if(($min_allowed/getCustomizeNumberOfKudos()*$conversionRate)/pow(10,($aa)) > 1) $unit_number = pow(10,($aa))*5;
                               }
                               $c_unit_number = round($unit_number*(getCustomizeNumberOfKudos())/$conversionRate,6);

                               //dd([$min_allowed/getCustomizeNumberOfKudos()*$conversionRate,$min_allowed,$unit_number,$c_unit_number]);

                               for($i = 1;$i<7;$i++){
                                   if($i*$c_unit_number <= $max_allowed && $i*$c_unit_number >= $min_allowed){
                                       $values_allowed->push($i*$c_unit_number);
                                   }
                               }

                            @endphp


                            <div class="mt-4" x-data="{
                                amount: {{$min_allowed}},
                                conversionRate: parseFloat({{ $conversionRate ?? 1 }}),
                                updateAmount(e) {
                                    let kudosAmount = e.target.value;

                                    amount = parseFloat(
                                        parseFloat(kudosAmount / ({{ getCustomizeNumberOfKudos() }})*this.conversionRate)
                                    ).toFixed(0);
                                    $('.value_helper').show();
                                    $('.dollar_value').show();

                                    if(parseInt(kudosAmount)) {
                                       $('.dollar_value').html(amount);
                                    } else {
                                        $('.dollar_value').html('0.00');
                                    }

                                    $('#value').trigger('input');

                                    $('#redeemForm').on('submit', function(e) {
                                        if($('#ConfirmModal').is(':hidden')) e.preventDefault();
                                        $('#ConfirmModal').show();
                                    })
                                }
                            }">
                                <x-jet-label for="value" value='{{ getReplacedWordOfKudos() . " to Redeem:"}}'/>
                            <!--  <x-jet-input id="value" class="block mt-1 w-full kudos_input" type="number"
                                             name="amount" step="1" min="{{round(max($reward->min_value,5)*(getCustomizeNumberOfKudos())/$conversionRate)}}"
                                             max="{{round(min(max($reward->max_value,0),9999999)*(getCustomizeNumberOfKudos())/$conversionRate)}}"
                                             @keyup="updateAmount"
                                             value="{{old('amount')}}"/> -->


                                <select name="amount" @change="updateAmount"
                                        class="border-gray-300 focus:border-indigo-300 focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mr-3 my-1 sm:w-48 md:w-auto lg:w-auto kudos_input"
                                >
                                    @foreach($values_allowed as $amt)
                                        <option
                                            x-data="{{currencyNumber(round(max($amt,5)*(getCustomizeNumberOfKudos())/$conversionRate),$currency)}}"
                                            value="{{ round($amt) }}" {{ $amt === $min_allowed  ? 'selected': '' }}>
                                            {{ number_format($amt) }} {{ getReplacedWordOfKudos() }}
                                            = {{currencyNumber(round(max($amt,5)/(getCustomizeNumberOfKudos())*$conversionRate),$currency)}}
                                        </option>
                                    @endforeach
                                </select>


                            </div>
                        @endif
                        @if(Auth::user()->points/(getCustomizeNumberOfKudos())*$conversionRate < (max($reward->min_value,5)))
                            <div class="italic text-sm font-light text-red-600">
                                Redemption amount is below minimum
                            </div>

                        @else
                            <div class="italic text-sm font-light">You currently
                                have {{number_format(Auth::user()->points)}} {{ getReplacedWordOfKudos() }} available to
                                redeem
                            </div>
                        @endif

                        @if ($errors->any())
                            <div class="alert alert-danger text-red-600">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <div class="flex items-center justify-end py-3 text-right   sm:rounded-bl-md sm:rounded-br-md">
                            @if($reward->is_custom)

                                @if(!Auth::user()->points < $reward->cost)
                                    @if(!$reward->enable_inventory_tracking || $reward->stock_amount > 0)
                                        <button
                                            class="redeem inline-flex items-center px-4 py-2 bg-pink-400 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-pink-300 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150 w-24 redeem mr-5">
                                            Redeem
                                        </button>
                                    @endif
                                @endif
                            @else
                                @if(!Auth::user()->points/(getCustomizeNumberOfKudos())*$conversionRate < max($reward->min_value,5))
                                    @if(!Auth::user()->company->balance*$conversionRate < $reward->min_value)
                                        <button
                                            class="redeem inline-flex items-center px-4 py-2 bg-pink-400 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-pink-300 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150 w-24 redeem mr-5">
                                            Redeem
                                        </button>
                                    @endif
                                @endif
                            @endif
                        </div>
                        <div class="mt-3" style="max-height: 265px; text-overflow: ellipsis; overflow: scroll;">
                            @if($reward->tango_redemption_instructions)
                                <div class="mt-2 text-sm font-sans text-grey-dark font-semibold mt-3">Merchant Provided
                                    Redemption Instructions
                                </div>
                                <div
                                    class="mt-2 text-xs italic font-sans font-light text-grey-dark text-justify">
                                    {!! $reward->tango_redemption_instructions !!}
                                </div>
                            @elseif($reward->custom_redemption_instructions)
                                <div class="mt-2 text-sm font-sans text-grey-dark font-semibold mt-3">
                                    Custom Redemption Instructions
                                </div>
                                <div
                                    class="mt-2 text-xs italic font-sans font-light text-grey-dark text-justify break-words">
                                    {!! $reward->custom_redemption_instructions !!}
                                </div>
                            @endif
                            @if($reward->tango_disclaimer || $reward->tango_terms)
                                <div class="mt-2 text-sm font-sans text-grey-dark font-semibold">Merchant Provided Terms
                                    &amp; Disclaimer
                                </div>
                                <div
                                    class="mt-2 text-xs font-sans italic font-light text-grey-dark text-justify">{!! $reward->tango_disclaimer !!}</div>
                                <div
                                    class="mt-2 text-xs italic font-sans font-light text-grey-dark text-justify">{!! $reward->tango_terms !!}</div>
                            @endif


                            <div
                                class="mt-2 text-xs italic font-sans font-light text-grey-dark border-t border-gray-100">
                                {{ appName() }} may not be held liable for any reward redemption.
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="reward_id" value="{{$reward->id}}">
                </x-slot>

                <x-slot name="actions">

                    @if($reward->is_custom)

                        @if(Auth::user()->points < $reward->cost)

                            <div class="text-xs italic text-red-600 w-full text-left p-2 m-2">
                                You do not have enough {{ getReplacedWordOfKudos() }} to redeem this reward. You can
                                receive {{ getReplacedWordOfKudos() }} from
                                co-workers for going above & beyond!
                            </div>

                        @else
                            @if(!$reward->enable_inventory_tracking || $reward->stock_amount > 0)
                                <x-jet-button type="submit" class="w-24 second mr-5 hidden">
                                    {{ __('Redeem!') }}
                                </x-jet-button>
                            @else
                                <div class="text-xs italic text-red-600 w-full text-left p-2 m-2">
                                    It looks like your company is out of this type of reward. Please contact a company
                                    administrator to update the reward inventory on {{ appName() }} to allow this
                                    redemption
                                    or choose another reward.
                                </div>
                            @endif


                        @endif
                    @else

                        @if(Auth::user()->points/(getCustomizeNumberOfKudos())*$conversionRate < max($reward->min_value,5))

                            <div class="text-xs italic text-red-600 w-full text-left p-2 m-2">
                                You do not have enough {{ getReplacedWordOfKudos() }} to redeem this reward. You can
                                receive {{ getReplacedWordOfKudos() }} from
                                co-workers for going above & beyond!
                            </div>



                        @else
                            @if(Auth::user()->company->balance*$conversionRate < $reward->min_value)
                                <div class="text-xs italic text-red-600 w-full text-left p-2 m-2">
                                    Your company does not currently have enough {{ appName() }} partner credits to allow
                                    partner rewards. <br>
                                    Please notify an administrator to increase your company credits to the enable these
                                    redemptions for all users.
                                </div>
                            @elseif(Auth::user()->company->check_for_fraud())
                                <div class="text-xs italic text-red-600 w-full text-left p-2 m-2">
                                    {{Auth::user()->company->check_for_fraud()}}
                                </div>
                            @else
                                <x-jet-button type="submit" class="w-24 second mr-5  hidden">
                                    {{ __('Redeem!') }}
                                </x-jet-button>
                            @endif
                        @endif

                    @endif

                </x-slot>

            </x-form-section>


        </div>
    </div>

    <script type="text/javascript">

        $('#redeemForm').on('submit', function (e) {
            if ($('#ConfirmModal').is(":hidden")) e.preventDefault();
            $('#ConfirmModal').show();

        })

        $('.kudos_input').trigger('keyup');

    </script>

    <x-confirmation-modal-box id="ConfirmModal">
        <x-slot name="title">
            <div class="break-all">
                Redeem {{$reward->title}}?
            </div>
        </x-slot>
        <x-slot name="content">
            Confirming here will process the transaction and cannot be undone. <br>By redeeming you are agreeing to the
            terms and disclaimer set by the merchant and/or your company.

        </x-slot>
        <x-slot name="footer">

            <x-jet-button class="bg-green-600 text-white hover:text-white ml-3"
                          onClick="$('#redeemForm').find('form').submit()">
                {{ __('Redeem!') }}
            </x-jet-button>

            <x-jet-secondary-button onclick="$('#ConfirmModal').hide();">
                {{ __('Nevermind') }}
            </x-jet-secondary-button>
        </x-slot>
    </x-confirmation-modal-box>

    <script>
        $(".redeem").click(function () {
            $(".second").click();
            return false;
        });
    </script>
</x-app-layout>
