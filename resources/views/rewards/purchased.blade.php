<x-app-layout>
    <div class="bg-white shadow sm:m-10 m-5">
        <div class="p-2">
            @if(!empty($success))
                <div
                    class="flex items-center bg-green-100 text-green-700 text-sm font-bold px-4 py-3 successMessage rounded"
                    role="alert">
                    <p>{{ $success }}</p>
                </div>
            @endif
        </div>
        <div class="block md:flex mx-10 py-10 px-5">
            <div class="lg:flex md:flex-initial">
                <div class="xs:display md:hidden lg:hidden">
                    <h2 class="font-bold break-all">
                        @if($redemption->is_processed)
                            {{ auth()->id() == $redemption->user_id ? 'You' : $redemption->user->name }}
                            exchanged {{ getReplacedWordOfKudos() }} for a {{$reward->title}}!
                        @else
                            {{ auth()->id() == $redemption->user_id ? 'You' : $redemption->user->name }} sent exchange
                            request
                            of {{ getReplacedWordOfKudos() }} for {{$reward->title}}!
                        @endif
                    </h2><br/>
                </div>
                <div class=" md:w-60 sm:w-auto">
                    <br>
                    @if($reward->is_custom)
                        @include('components.custom_card', ['r' => $reward, 'title'=>$reward->title])
                    @elseif($reward->photo_path)
                        <img class="w-30" src="{{$reward->photo_path}}"><br>
                    @endif
                </div>
                <div class="flex-1 md:mt-10 lg:ml-24 md:ml-0 mt-6">
                    <div class="xs:hidden ">
                        <h2 class="font-bold break-all">
                            @if($redemption->is_processed)
                                {{ auth()->id() == $redemption->user_id ? 'You' : $redemption->user->name }}
                                exchanged {{ getReplacedWordOfKudos() }} for a {{$reward->title}}!
                            @else
                                {{ auth()->id() == $redemption->user_id ? 'You' : $redemption->user->name }} sent
                                exchange request
                                of {{ getReplacedWordOfKudos() }} for {{$reward->title}}!
                            @endif
                        </h2><br/>
                    </div>


                    @if(!$redemption->is_processed)
                        <div
                            class="rounded-md border-red-500 border-2 text-red-500 py-1 text-center bg-red-50 font-bold w-44">
                            Approval Pending
                        </div>
                    @endif

                    <div class="mt-2 text-sm font-sans font-light text-grey-dark break-words">
                        @if($reward->is_custom)
                            {{ $reward->description }}
                        @else
                            {!! $reward->description !!}
                        @endif

                    </div>
                    @if($reward->is_custom && $reward->use_set_amount)

                    @else
                        <div class="mt-2 text-sm font-sans font-light text-grey-dark font-bold">
                            {{--                            Value: {{currencyNumber($redemption->value,json_decode(json_decode($redemption->data)->tango_data)->items[0]->currencyCode ? :'USD')}}--}}
                            {{-- Value: {{currencyNumber($redemption->value, $redemption->tango_currency ? $redemption->tango_currency : 'USD')}} --}}
                            Value: {{currencyNumber($redemption->value,json_decode(json_decode($redemption->data)->tango_data)->items[0]->currencyCode ? :'USD')}}
                        </div>
                    @endif

                    @if($redemption->tango_claim_code)
                        <div class="mt-2 text-sm font-sans font-light text-grey-dark font-bold">Redemption Code: <span
                                class="italic font-normal">{!! $redemption->tango_claim_code !!}</span></div>
                    @endif

                    @if($redemption->tango_pin)
                        <div class="mt-2 text-sm font-sans font-light text-grey-dark font-bold">Pin: <span
                                class="italic font-normal">{!! $redemption->tango_pin !!}</span></div>
                        <div class="mt-2 text-sm font-sans font-light text-grey-dark font-bold">Card Number: <span
                                class="italic font-normal">{!! $redemption->tango_card_number !!}</span></div>
                    @endif

                    <div class="mt-2 text-sm font-sans font-light text-grey-dark ">
                        Cost: {{number_format($redemption->cost)}} {{ getReplacedWordOfKudos() }}
                    </div>

                    <div
                        class="mt-2 text-sm font-sans font-light text-grey-dark italic">Redeemed
                        on {{ $redemption->created_at->format("F jS, Y") }}
                    </div>

                    <br>

                    @if($redemption->tango_directions)
                        <div class="mt-2 text-sm font-sans font-light text-grey-dark font-semibold">
                            Merchant Directions:<br>
                            <span class="italic font-normal">{!! $redemption->tango_directions !!}</span>
                        </div>
                    @endif

                    @if($redemption->is_custom && $redemption->redemption_instructions)
                        <div class="mt-2 text-sm font-sans font-light text-grey-dark font-semibold">
                            Redemption Instructions: <br>
                            <span class="italic font-normal">{{ $redemption->redemption_instructions }}</span>
                        </div>
                    @endif

                    @if(!$redemption->is_custom && $redemption->redemption_instructions)
                        <div class="mt-2 text-sm font-sans font-light text-grey-dark font-semibold">
                            Redemption Instructions: <br>
                            <span class="italic font-normal">{!! $redemption->redemption_instructions !!}</span>
                        </div>
                    @endif

                    @if($redemption->tango_order_id)
                        <div class="mt-2 text-xs font-sans font-light text-grey-dark font-semibold">
                            Tango Reference ID: <br>
                            <span class="italic font-normal">{{$redemption->tango_order_id}}</span>
                        </div>
                    @endif

                    @if($redemption->redemption_code)
                        <div class="mt-2 text-xs font-sans font-light text-grey-dark font-semibold">
                            {{ appName() }} Redemption Code:
                            <br>
                            <span class="italic font-normal">{{$redemption->redemption_code}}</span>
                        </div>
                    @endif

                    <div class="mt-2 text-xs italic font-sans font-light text-grey-dark">
                        {{ appName() }} may not be held liable for the redemption of redeemed rewards.
                    </div>

                    @if($redemption->is_rejected || $redemption->marked_as_unable_to_furfill)
                        <div class="mt-5 text-sm font-sans font-light text-red-500 font-bold">
                            Redemption failed for below reason:

                            <br>
                            <span class="italic font-normal text-gray-900">{{$redemption->rejection_reason}}</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    <!-- <div class="block sm:flex mx-2 py-10 px-5 sm:hidden">
            <div class="col-span-6 sm:col-span-4 position-fixed flex">
                <div class="float-left">
                    <br>
                    @if($reward->is_custom)
        @include('components.custom_card', ['r' => $reward, 'title'=>$reward->title])
    @elseif($reward->photo_path)
        <img src="{{$reward->photo_path}}"><br>
                    @endif
        <br>
                            <h2 class="font-bold break-all">
@if($redemption->is_processed)
        {{ auth()->id() == $redemption->user_id ? 'You' : $redemption->user->name }}
            exchanged {{ getReplacedWordOfKudos() }} for a {{$reward->title}}!
                        @else
        {{ auth()->id() == $redemption->user_id ? 'You' : $redemption->user->name }} sent exchange request
                            of {{ getReplacedWordOfKudos() }} for {{$reward->title}}!
                        @endif
        </h2><br/>


@if(!$redemption->is_processed)
        <div
            class="rounded-md border-red-500 border-2 text-red-500 py-1 text-center bg-red-50 font-bold w-44">
            Approval Pending
        </div>
@endif

        <div class="mt-2 text-sm font-sans font-light text-grey-dark break-words">
@if($reward->is_custom)
        {{ $reward->description }}
    @else
        {!! $reward->description !!}
    @endif

        </div>
@if($reward->is_custom && $reward->use_set_amount)

    @else
        <div class="mt-2 text-sm font-sans font-light text-grey-dark font-bold">
{{--            Value: {{currencyNumber($redemption->value,json_decode(json_decode($redemption->data)->tango_data)->items[0]->currencyCode ? :'USD')}}</div>--}}
            Value: {{currencyNumber($redemption->value, $redemption->tango_currency ? $redemption->tango_currency : 'USD')}}
                    @endif

    @if($redemption->tango_claim_code)
        <div class="mt-2 text-sm font-sans font-light text-grey-dark font-bold">Redemption Code: <span
                class="italic font-normal">{!! $redemption->tango_claim_code !!}</span></div>
                    @endif

    @if($redemption->tango_pin)
        <div class="mt-2 text-sm font-sans font-light text-grey-dark font-bold">Pin: <span
                class="italic font-normal">{!! $redemption->tango_pin !!}</span></div>
                        <div class="mt-2 text-sm font-sans font-light text-grey-dark font-bold">Card Number: <span
                                class="italic font-normal">{!! $redemption->tango_card_number !!}</span></div>
                    @endif

        <div class="mt-2 text-sm font-sans font-light text-grey-dark ">
            Cost: {{number_format($redemption->cost)}} {{ getReplacedWordOfKudos() }}
        </div>

        <div
            class="mt-2 text-sm font-sans font-light text-grey-dark italic">Redeemed
            on {{ $redemption->created_at->format("F jS, Y") }}
        </div>

        <br>

@if($redemption->tango_directions)
        <div class="mt-2 text-sm font-sans font-light text-grey-dark font-semibold">
            Merchant Directions:<br>
            <span class="italic font-normal">{!! $redemption->tango_directions !!}</span>
                        </div>
                    @endif

    @if($redemption->is_custom && $redemption->redemption_instructions)
        <div class="mt-2 text-sm font-sans font-light text-grey-dark font-semibold">
            Redemption Instructions: <br>
            <span class="italic font-normal">{{ $redemption->redemption_instructions }}</span>
                        </div>
                    @endif

    @if(!$redemption->is_custom && $redemption->redemption_instructions)
        <div class="mt-2 text-sm font-sans font-light text-grey-dark font-semibold">
            Redemption Instructions: <br>
            <span class="italic font-normal">{!! $redemption->redemption_instructions !!}</span>
                        </div>
                    @endif

    @if($redemption->tango_order_id)
        <div class="mt-2 text-xs font-sans font-light text-grey-dark font-semibold">
            Tango Reference ID: <br>
            <span class="italic font-normal">{{$redemption->tango_order_id}}</span>
                        </div>
                    @endif

    @if($redemption->redemption_code)
        <div class="mt-2 text-xs font-sans font-light text-grey-dark font-semibold">
{{ appName() }} Redemption Code:
                            <br>
                            <span class="italic font-normal">{{$redemption->redemption_code}}</span>
                        </div>
                    @endif

        <div class="mt-2 text-xs italic font-sans font-light text-grey-dark">
{{ appName() }} may not be held liable for the redemption of redeemed rewards.
                    </div>

                    @if($redemption->is_rejected || $redemption->marked_as_unable_to_furfill)
        <div class="mt-5 text-sm font-sans font-light text-red-500 font-bold">
            Redemption failed for below reason:

            <br>
            <span class="italic font-normal text-gray-900">{{$redemption->rejection_reason}}</span>
                        </div>
                    @endif
        </div>
    </div>
</div> -->

        @if($redemption->tango_link)
            <div class="text-right">
                @php
                    $file = $redemption->tango_link;
                    $file_headers = @get_headers($file);
                    if(!$file_headers || $file_headers[0] == 'HTTP/1.1 404 Not Found') {
                    $exists = false;
                    }
                    else {
                    $exists = true;
                    }
                @endphp
                @if($exists == true)
                    <x-clear-link-button href="{{$redemption->tango_link}}"
                                         class="bg-blue-300 hover:bg-blue-200 mx-10 m-4"
                                         target="_blank">
                        View Gift Card!
                    </x-clear-link-button>
                @endif
            </div>
        @endif
    </div>
</x-app-layout>
<script>
    $("document").ready(function () {
        setTimeout(function () {
            $("div.successMessage").remove();
        }, 2500);
    });
</script>





