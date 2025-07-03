<x-app-layout>
    <style>
        #example::-webkit-scrollbar {
            display: none;
        }
    </style>

    <script src="https://cdn.rawgit.com/nnattawat/flip/master/dist/jquery.flip.min.js"></script>

    <div class="container px-4 py-10 mx-auto md:py-12">
        <div class="p-8 my-10 bg-white border border-gray-300 rounded rounded-t-lg ">
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                {{ getReplacedWordOfKudos() }} Summary for {{auth()->user()->name}}
            </h2>

            <div name="description">
                You currently have <b>{{ number_format(auth()->user()->points) }}</b> {{ getReplacedWordOfKudos() }}
                available to redeem for amazing rewards.
                <br>
                <span class="text-sm italic">
                    You may use these {{ getReplacedWordOfKudos() }} to buy awesome rewards!
                </span>
                <br>
                <div class="grid w-full grid-cols-12 py-3 my-5 rounded">
                    <h3 class="col-span-8 col-start-1 pb-2 mb-3 text-lg italic border-b border-gray-400">
                        Recent Transaction History
                    </h3>
                    <a class="wrapper text-sm col-span-4  pb-2 mb-3 border-b border-gray-400 text-right text-blue-700"
                       href="/export-wallet">
                    <span class="text-lg ">
                        <i class="fas fa-upload text-xl cursor-pointer  text-gray-700 "></i>
                         Export
                    </span>

                    </a>
                    {{--                    <a class="col-span-4  pb-2 mb-3 text-lg italic border-b border-gray-400 text-right text-blue-700"--}}
                    {{--                       href="/export-wallet">Export </a>--}}
                    @forelse(App\Models\Transaction::where('user_id',auth()->user()->id)->orderBy('created_at','desc')->take(7)->get() as $t)
                        <div
                            class="col-start-1 col-span-2 mx-2 text-left text-sm py-2 @if($t->amount > 0) text-green-500 @else text-red-500 @endif">
                            @if($t->amount > 0)
                                {{number_format($t->amount)}}
                            @else
                                {{ "(".number_format(abs($t->amount)).")" }}
                            @endif
                        </div>

                        <div class="col-span-6 col-start-3 py-2 mx-2 ml-5 text-xs text-left text-blue-600 sm:ml-0">
                            <a href="{{$t->link}}">
                                @if($t->type == 2)
                                    {{$t->user->name}} {{$t->note}}
                                @else
                                    {{$t->note}}
                                @endif
                                {{--                                {{$t->note}}--}}
                            </a>
                        </div>

                        <div class="col-span-4 py-2 mx-2 text-xs italic text-right md:col-start-9">
                            {{ Timezone::convertToLocal($t->created_at, 'F jS, Y \- g:i A') }}
                        </div>

                        <div class="col-span-12 col-start-1 mb-1 border-b border-gray-300 border-dashed"></div>
                    @empty
                        <div class="col-span-12 col-start-1">No Transactions Found</div>
                    @endforelse

                    @if(App\Models\Transaction::where('user_id',auth()->user()->id)->count())
                        <a class="col-span-12 col-start-1 pt-2 mt-2 mb-1 text-sm italic text-blue-800 border-t border-gray-400"
                           href="/transactions">
                            View Full Transaction History
                        </a>
                    @endif
                </div>

            </div>
        </div>


@if(Auth::user()->company->show_multiple_currencies)
        <div class="">
            <form action="" method="GET">
                <x-jet-label class="font-bold" for="currency" value="{{ __('Select Gift Card Currency') }}"/>
                <select name="currency"
                        class="border-gray-300 focus:border-indigo-300 focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mr-5 my-1 w-40 sm:w-38 md:w-28 lg:w-44"
                        onchange="this.form.submit()">
                    @foreach(\App\Models\Tango::all()->where('disable',0)->where('active',1)->pluck("currency")->flatten()->unique()->sort()->values()->all() as $currency)
                        <option
                            value="{{ $currency }}" {{ request('currency') === $currency  ? 'selected': '' }}>
                            {{ $currency }}
                        </option>
                    @endforeach
                </select>
            </form>
        </div>
@endif

        <h2 class="pt-5 my-2 text-lg font-semibold leading-tight text-gray-800 ">
            Redeem Rewards!
        </h2>
        <h2 class="pt-2 my-1 text-sm italic leading-tight text-gray-800 border-t border-gray-500">
            Hover over the gift card to preview.
        </h2>

        @if(auth()->user()->company->rewards()->where('is_custom', 1)->where('active', 1)->where('disabled', 0)->where('currency',request("currency"))->count())
            <h2 class="pt-2 my-1 text-sm italic leading-tight text-gray-800 ">
                Custom Company Rewards
            </h2>
            <div class="grid justify-center grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">

                @foreach(auth()->user()->company->rewards()->where('is_custom',1)->where('active',1)->where('currency',request("currency"))->where('disabled',0)->orderBy('title')->get() as $r)

                    <div class="self-start gift_card3">
                        @include('components.custom_card', ['r' => $r,'title' => data_get($r, 'title')])
                        <div
                            class="self-start max-w-xs m-1 mx-3 overflow-hidden overflow-x-hidden bg-white shadow-xl rounded-xl gift_card_info back"
                            style="min-width: 150px;">
                            <div style="min-height: 100px;">
                                <div class="px-3 pt-2 pb-6 text-center">
                                    <a class="py-5 font-sans text-black break-words cursor-auto text-xls bold" href="">
                                       {{ $r->title }}
                                    </a>

                                    <div class="text-center text-xs italic">
                                         <span> {{ number_format($r->cost) }} {{getReplacedWordOfKudos()}}  |</span>
                                        @if($r->approval_needed)
                                            <span>Manual Approval</span>
                                        @else
                                            <span>Instant Approval</span>
                                        @endif
                                                <span> | {{ request('currency') ?? "USD" }}</span>
                                    </div>

                                    <div class="w-full border-b-2"></div>
                                <!-- <p class="mt-2 font-sans text-sm italic font-light text-grey-dark">Value: ${{$r->value}}</p>
                <p class="mt-2 font-sans text-sm italic font-light text-grey-dark">Cost: {{ number_format($r->cost) }} {{ getReplacedWordOfKudos() }}</p> -->
                                    <div id="example"
                                         class="mt-2 font-sans text-xs italic font-light break-words text-grey-dark"
                                         style="height: 150px; text-overflow: ellipsis; overflow: scroll;">
                                        {!! $r->description !!}
                                    </div>
                                </div>
                            </div>
                            <div class="text-right">
                                <x-link-button class="my-3 ml-5 mr-5" href="/rewards/{{$r->id}}">
                                    {{ __('View More') }}
                                </x-link-button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif


        @if(auth()->user()->company->allow_tango_cards)
            <h2 class="pt-2 my-1 text-sm italic leading-tight text-gray-800 border-t border-gray-500">
{{--                Rewards Provided by {{ appName() }} Partners--}}
                Rewards Provided by {{ appName() }} Partners
            </h2>
            @if(auth()->user()->company->allow_tango_cards)
                <div class="w-full text-xs italic">The merchants represented are not sponsors of the rewards
                    or
                    otherwise affiliated with {{ appName() }}. The logos and other identifying marks attached are
                    trademarks
                    of and owned by each represented company and/or its affiliates. Please visit each
                    company's website
                    for additional terms and conditions.
                </div>
            @endif
            @if(auth()->user()->company->balance < 5)
                <div class="w-full text-xs italic font-semibold text-red-500">
                    Your company does not currently have enough {{ appName() }} partner credits to allow partner
                    rewards. <br>
                    Please notify an administrator to increase your company credits to the enable these
                    redemptions for
                    all users.<br>

                    {{ appName() }} also allows your company to create custom rewards. Common examples include: t-shirt, water bottle,
                    lunch with the CEO, but the options are limitless!


                @if(auth()->user()->role === 1)
                        <br>
                        <x-link-button href="{{route('billing')}}" class="mt-3">
                            Add Credit Here
                        </x-link-button>

                        <x-secondary-link-button href="/rewards/create/new" class="mt-3">
                            Create Custom Reward
                        </x-secondary-link-button>


                    @endif
                </div>
            @elseif(auth()->user()->company->check_for_fraud())
                <div class="w-full text-xs italic font-semibold text-red-500">
                    {{auth()->user()->company->check_for_fraud()}}
                </div>
            @endif

            @if(auth()->user()->company->balance > 5)
                <div class="grid justify-center grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                    @foreach($rewards as $r)
                        <div class="self-start gift_card">
                            <div class="front">
                                <img src="{{$r->photo_path ?? ''}}" class="m-5 shadow-xl rounded-xl">
                            </div>

                            <div
                                class="self-start max-w-xs m-1 mx-3 overflow-hidden overflow-x-hidden bg-white shadow-xl rounded-xl gift_card_info back"
                                style="min-width: 150px;">
                                <div style="min-height: 100px;">
                                    <div class="px-3 pt-2 pb-6 text-center">
                                        <a class="py-5 font-sans text-black text-xls bold"
                                           href="">{{ $r->title }}</a>
                                        <div class="text-center text-xs italic">
                                            @if($r->approval_needed)
                                                <span>Manual Approval</span>
                                            @else
                                                <span>Instant Approval</span>
                                            @endif

                                            @if($r->currency)
                                                <span> | {{ $r->currency }}</span>
                                            @endif
                                        </div>
                                        <div class="w-full border-b-2"></div>

                                        <div id="example"
                                             class="mt-2 font-sans text-xs italic font-light text-grey-dark break-words"
                                             style="height: 150px; text-overflow: ellipsis; overflow: scroll;">
                                            {!! $r->description !!}
                                        </div>
                                    </div>
                                </div>
                                <x-link-button class="my-3 ml-5 mr-5" href="/rewards/{{$r->id}}">
                                    {{ __('View More') }}
                                </x-link-button>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        @endif


        <div class="my-10 space-y-5 border-b-2 border-gray-300"></div>

        <h2 class="p-1 my-3 text-xl font-semibold leading-tight text-gray-800 sm:p-2">
            View Previously Redeemed Rewards!
        </h2>

        @if(count($redeemedRewards))
            <div class="grid justify-center grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">

                @foreach($redeemedRewards as $red)
                    @php
                        $r = json_decode($red->data);
                    @endphp

                    <div class="self-start gift_card2">
                        @if($red->is_custom)
                            <div>
                                @include('components.custom_card',['r'=>$r,'red' => $red, 'title'=>$r->title])
                                <div class="front pt-56">
                                    @if(!$red->is_processed)
                                        <div class="flex justify-center items-center">
                                            <div class="rounded-md border-red-500 border-2 text-red-500 py-1 text-center bg-red-50 font-bold w-44">
                                                Approval Pending
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>

                        @else
                            <div class="front">
                                <img src='{{$r->photo_path ?? ""}}' class="m-2 shadow-xl rounded-xl">

                                @if(!$red->is_processed)
                                <div class="flex justify-center items-center">
                                    <div class="rounded-md border-red-500 border-2 text-red-500 py-1 text-center bg-red-50 font-bold w-44">
                                        Approval Pending
                                    </div>
                                </div>
                                @endif
                            </div>
                        @endif
                        <div
                            class="self-start max-w-xs m-1 mx-3 overflow-hidden overflow-x-hidden bg-white shadow-xl rounded-xl gift_card_info back"
                            style="min-width: 150px;">
                            <div style="min-height: 100px;">
                                <div class="px-3 pt-2 pb-6 text-center">
                                    <a class="py-5 font-sans text-black cursor-auto text-xls bold"
                                       href="">{{ $r->title ?? "" }}</a>
                                    <div class="w-full border-b-2"></div>
                                    @if($red->value)
                                        <div class="mt-2 font-sans text-sm italic font-light text-grey-dark">
                                            Value: ${{number_format($red->value,2)}}
                                        </div>
                                    @endif
                                    <div class="mt-2 font-sans text-sm italic font-light text-grey-dark">
                                        Cost: {{ number_format($red->cost) }} {{ getReplacedWordOfKudos() }}</div>
                                    <div class="mt-2 font-sans text-xs italic font-light text-gray-500">
                                        Exchanged on {{ $red->created_at->format('F jS, Y') }}</div>


                                    <div id="example" class="mt-2 font-sans text-xs italic font-light text-grey-dark break-words"
                                         style="height: 150px; text-overflow: ellipsis;overflow: scroll; ">
                                        @if($red->is_custom)
                                            {{ $r->description ?? "" }}
                                        @else
                                            {!! $r->description ?? "" !!}
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="text-right">
                                <x-link-button class="my-3 ml-5 mr-5" href="/redeem/{{$red->id}}">
                                    {{ __('View!') }}
                                </x-link-button>
                                @if($red->tango_link)
                                    @php
                                        $file = $red->tango_link;
                                        $file_headers = @get_headers($file);
                                        if(!$file_headers || $file_headers[0] == 'HTTP/1.1 404 Not Found') {
                                        $exists = false;
                                        }
                                        else {
                                        $exists = true;
                                        }
                                    @endphp
                                    @if($exists == true)
                                        <x-secondary-link-button class="my-3 ml-5 mr-5" target="_blank"
                                                                 href="{{$red->tango_link ?? ''}}">
                                            {{ __('Merchant Link') }}
                                        </x-secondary-link-button>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>

                @endforeach

            </div>
        @else
            <div class="mx-2 mb-12">
                Looks like you still have not redeemed any rewards.
                Be a superstar to gain {{ getReplacedWordOfKudos() }} and exchange them for amazing rewards!
            </div>
        @endif


        <script type="text/javascript">
            $(document).ready(function () {
                $('.gift_card').flip({
                    trigger: 'hover'
                });
                $('.gift_card2').flip({
                    trigger: 'hover'
                });
                $('.gift_card3').flip({
                    trigger: 'hover'
                });
            });
        </script>
    </div>

    <livewire:wallet-welcome/>
</x-app-layout>
