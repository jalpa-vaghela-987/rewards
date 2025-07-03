<x-app-layout>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    @php
        $now = \Carbon\Carbon::now();
        $now2 = \Carbon\Carbon::now();
        $now3 = \Carbon\Carbon::now();

        foreach(App\Models\Redemption::all()->where('usd_amount',null) as $ree){
            $ree->usd_amount = round($ree->cost/100,2);
            $ree->save();
        }

        // time layering
         $c3 = Carbon\Carbon::now()->subMonths(5)->firstOfMonth();
         $redemptions_5 = $company->redemptions->flatten()->unique()
             ->where('created_at',">=",$c3->format('Y-m-d'))
             ->where('is_custom',0)
             ->where('created_at',"<",$c3->addMonth()->firstOfMonth()->format('Y-m-d'))
             ->pluck('usd_amount')
             ->sum();

         $redemptions_4 = $company->redemptions->flatten()->unique()
             ->where('created_at', ">=", $c3->format('Y-m-d'))
             ->where('is_custom',0)
             ->where('created_at', "<", $c3->addMonth()->firstOfMonth()->format('Y-m-d'))
             ->pluck('usd_amount')
             ->sum();

         $redemptions_3 = $company->redemptions->flatten()->unique()
             ->where('created_at',">=",$c3->format('Y-m-d'))
             ->where('is_custom',0)
             ->where('created_at',"<",$c3->addMonth()->firstOfMonth()->format('Y-m-d'))
             ->pluck('usd_amount')
             ->sum();

         $redemptions_2 = $company->redemptions->flatten()->unique()
             ->where('created_at',">=",$c3->format('Y-m-d'))
             ->where('is_custom',0)
             ->where('created_at',"<",$c3->addMonth()->firstOfMonth()->format('Y-m-d'))
             ->pluck('usd_amount')
             ->sum();

         $redemptions_1 = $company->redemptions->flatten()->unique()
             ->where('created_at',">=",$c3->format('Y-m-d'))
             ->where('is_custom',0)
             ->where('created_at',"<",$c3->addMonth()->firstOfMonth()->format('Y-m-d'))
             ->pluck('usd_amount')
             ->sum();

         $redemptions_0 = $company->redemptions->flatten()->unique()
             ->where('created_at',">=",$c3->format('Y-m-d'))
             ->where('is_custom',0)
             ->where('created_at',"<",$c3->addMonth()->firstOfMonth()->format('Y-m-d'))
             ->pluck('usd_amount')
             ->sum();
    @endphp

    <div class="container mx-auto sm:px-4 py-10 md:py-12">
        <div>
            <div class="mt-10 sm:mt-0 mb-5">
                <x-div-section>
                    <x-slot name="title">
                        {{ appName() }} Billing Dashboard
                    </x-slot>

                    <x-slot name="description">
                        The {{ appName() }} billing dashboard allows admin users to stay up to date with billing on the
                        platform.

                        <br><br>
                        All values are in USD unless otherwise specified
                        <br><br>

                        @if($company && !$company->subscribed('default'))
                            @if(!request()->routeIs('developer.billing'))
                                <x-secondary-link-button href="{{url('/stripe/checkout/'.Auth::user()->id)}}">
                                    Activate Subscription!
                                </x-secondary-link-button>
                                <br>
                            @endif

                            <div class="text-md font-semibold m-2">
                                {{(30 - $company->created_at->diffInDays(now()))}} Days
                                Remaining in Trial!
                            </div>
                        @else
                            <x-secondary-link-button href="/billing-portal">
                                Manage Subscription & Payment Info
                            </x-secondary-link-button>
                        @endif

                        <br><br>
                    </x-slot>

                    <x-slot name="form">
                        <div class="col-span-12 ">
                            <div class="col-span-12">
                                <div
                                    class="text-center bg-green-50 border border-gray-200 py-1 m-1 rounded px-2 w-2/3 sm:w-1/3 mb-5 pb-3 shadow ">
                                    <div class="underline">
                                        Current Balance
                                    </div>

                                    <div class="text-center text-lg text-gray-800 mt-1 font-bold">
                                        ${{number_format($company->balance, 2)}}
                                    </div>
                                </div>

                                <div class="col-span-12 pt-4 mt-3 border-t border-gray-200">
                                    <div class="max-w-xl text-sm text-gray-600 font-bold">
                                        Manage {{ appName() }} Partner Redemption Balance

                                        <div class="text-xs font-light mt-1">
                                            This balance allows users to redeem {{ getReplacedWordOfKudos() }} for
                                            {{ appName() }} partner gift cards. {{ appName() }} recommends keeping a
                                            sufficient
                                            minimum
                                            balance in the account to prevent any delay in redeeming rewards.
                                        </div>
                                    </div>
                                </div>

                                <br>

                                <livewire:refill-company-balance :company="$company"/>
                            </div>

                            <div
                                class="col-span-12 sm:col-span-12 flex grid lg:grid-cols-4 md:grid-cols-2 grid-cols-1 border-t border-gray-200 pt-3 mt-2">

                                <div class="col-span-12 ">
                                    <div class="text-sm text-gray-600 font-bold">
                                        {{ appName() }} Redemption Amount Totals

                                        <div class="text-xs font-light mt-1">
                                            Redemptions consist of the amount of spend from
                                            rewards going directly to your employees in the form of rewards or gift
                                            cards.
                                        </div>
                                    </div>
                                </div>
                                <div class="col-span-12 mt-5"></div>

                                <div class="col-span-12 grid sm:grid-cols-4 grid-cols-2">
                                    <div class="text-center bg-blue-50 border border-gray-200 py-1 m-1 rounded px-2 ">
                                        <div class="underline">
                                            Current Redemptions
                                        </div>
                                        <div class="max-w-xl text-lg text-gray-800 mt-1">
                                            ${{number_format((float)$redemptions_0,2)}}
                                        </div>
                                        <div>
                                            <div class="italic text-xs mt-1">{{$now2->format("F Y")}}</div>
                                        </div>
                                    </div>

                                    <div class="text-center bg-blue-50 border border-gray-200 py-1 m-1 rounded px-2 ">
                                        <div class="underline">
                                            {{$now2->subMonths(1)->format("F")}} Redemptions
                                        </div>
                                        <div class="max-w-xl text-lg text-gray-800 mt-1">
                                            ${{number_format((float)$redemptions_1,2)}}

                                        </div>
                                        <div>
                                            <div class="italic text-xs mt-1">{{$now2->format("F Y")}}</div>
                                        </div>
                                    </div>

                                    <div class="text-center bg-blue-50 border border-gray-200 py-1 m-1 rounded px-2 ">
                                        <div class="underline">
                                            {{$now2->subMonths(1)->format("F")}} Redemptions
                                        </div>
                                        <div class="max-w-xl text-lg text-gray-800 mt-1">
                                            ${{number_format((float)$redemptions_2,2)}}

                                        </div>
                                        <div>
                                            <div class="italic text-xs mt-1">{{$now2->format("F Y")}}</div>
                                        </div>
                                    </div>

                                    <div class="text-center bg-blue-50 border border-gray-200 py-1 m-1 rounded px-2 ">
                                        <div class="underline">
                                            {{$now2->subMonths(1)->format("F")}} Redemptions
                                        </div>
                                        <div class="max-w-xl text-lg text-gray-800 mt-1">
                                            ${{number_format((float)$redemptions_3,2)}}

                                        </div>
                                        <div>
                                            <div class="italic text-xs mt-1">{{$now2->format("F Y")}}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </x-slot>
                </x-div-section>
            </div>

            <div class="mt-10 sm:mt-0 mb-5">
                @livewire('funding-history',['company' => $company])
            </div>

            <!-- Add Team Member -->
            <div class="mt-10 sm:mt-0 ">
                @livewire('reward-redemption-activity', ['company' => $company])
            </div>
        </div>
    </div>

<!-- <script type="text/javascript">

    const stripe = Stripe({{env('STRIPE_KEY')}});

    const elements = stripe.elements();
    const cardElement = elements.create('card');

    cardElement.mount('#card-element');



    const cardHolderName = document.getElementById('card-holder-name');
    const cardButton = document.getElementById('card-button');

    cardButton.addEventListener('click', async (e) => {
        const { paymentMethod, error } = await stripe.createPaymentMethod(
            'card', cardElement, {
                billing_details: { name: cardHolderName.value }
            }
        );

        if (error) {
            // Display "error.message" to the user...
        } else {
            console.log("success!")
            // The card has been verified successfully...
        }
    });

    </script> -->

    <!--
                       <div class="col-span-12 pt-3 mt-2">
                        <div class="col-span-6 sm:col-span-4">
                                <x-jet-label for="Card Holder Name" value=""/>
                                <input id="card-holder-name" type="text" placeholder="Card Holder Name"
                                class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-3/4">
                        </div>

                        <div class="col-span-4 sm:col-span-3 sm:w-3/4 p-2 my-3 border border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                            <div id="card-element"></div>
                        </div>

                        <button id="card-button" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md font-semibold text-xs text-white uppercase tracking-widest shadow-sm hover:text-gray-100 focus:outline-none  focus:shadow-outline-blue active:text-gray-100 active:bg-gray-50 transition ease-in-out duration-150 bg-green-500 text-white">
                            Confirm Card Information
                        </button>


                    </div>   -->

</x-app-layout>
