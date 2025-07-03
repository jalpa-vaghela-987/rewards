<div>
    <div class="mt-10 sm:mt-0 mb-5">
        <div class="md:grid md:grid-cols-3 md:gap-6">
            <div class="md:col-span-1 mb-6">
            </div>

            <div class="mt-5 md:mt-0 md:col-span-2">
                <div>
                    <div class="bg-white shadow px-4 py-5 sm:rounded-md">
                        <div class="grid
                                         grid-cols-6 gap-6
                                    ">
                            <div class="col-span-12 ">
                                <div class="col-span-12 border-t border-gray-200 pt-3 pb-2">
                                    <div class="col-start-1  max-w-xl text-sm text-gray-600 font-bold">
                                        Custom & Partner Reward Redemption Activity
                                    </div>
                                    <div class="md:col-start-9 col-span-4 mx-2 italic text-xs text-right font-bold text-blue-700">
                                        <a href="/export">
                                    <span class="text-sm ">
                                            <i class="fas fa-upload text-sm cursor-pointer  text-gray-700 "></i>
                                        Export
                                    </span>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-span-12 sm:col-span-12 -mt-1">
                                    <div class="w-full">
                                        <div
                                            class="col-span-12 grid grid-cols-none overflow-y-scroll border border-gray-200 space-y-0.5 lg:max-h-120 sm:max-h-240"
                                        >
                                            @forelse($company_activity as $t)
                                                <div
                                                    class="col-start-1 lg:col-span-1 sm:col-span-2 mx-2 my-0 text-left text-sm  py-0
                                            @if($t->amount > 0)
                                                        text-green-500
@else
                                                        text-red-500
@endif">
                                                    @if($t->amount > 0)
                                                        {{(number_format((float)$t->amount/100,2))}}

                                                    @else
                                                        ${{ "(".(number_format(abs((float)$t->amount/100),2)).")" }}
                                                    @endif
                                                </div>
                                                <div class="text-xs  sm:col-span-1 col-start-2 lg:col-span-1 text-gray-600 ">
                                                    @if($t->redemption)
                                                        {{currencyNumber($t->redemption->value,$t->redemption->currency)}}&nbsp;&nbsp;
                                                    @else
                                                        {{(number_format((float)$t->amount,2))}}&nbsp;&nbsp;
                                                    @endif
                                                </div>
                                                <div class="text-xs  sm:col-span-2 col-start-3 lg:col-span-2 text-gray-600 ">
                                                    {{ json_decode(json_decode($t->data)->data)->type === "default" ? "Partner Reward" : json_decode(json_decode($t->data)->data)->type }}
                                                </div>

                                                <div
                                                    class=" col-span-2 sm:col-start-3 lg:col-span-3 mx-2 text-xs text-gray-600 my-0 py-0 lg:col-start-5">
                                                    <a class="break-words">
                                                        @if($t->type == 1)
                                                            {{$t->point->reciever->name}} received
                                                            @if($t->point->is_super)
                                                                super
                                                            @endif {{ getReplacedWordOfKudos() }}
                                                            from {{$t->point->giver->name}}
                                                        @elseif($t->type == 2)
                                                            {{$t->user->name}} {{$t->note}}
                                                        @else
                                                            {{$t->note}}
                                                        @endif
                                                    </a>
                                                </div>
                                                <div class="text-xs col-start-7 sm:col-span-2 text-gray-600 ">
                                                    {{$t->user->email}}
                                                </div>

                                                <div
                                                    class="col-start-9 lg:col-span-3 sm:col-span-2 mx-2 italic text-xs text-right  py-0 my-0">
                                                    {{ Timezone::convertToLocal($t->created_at, 'F jS, Y \- g:i A') }}
                                                </div>

                                                <div
                                                    class="col-start-1 col-span-12 border-b border-gray-300 border-dashed my-0"></div>

                                            @empty
                                                <div class="col-span-12 text-gray-500 pl-48">
                                                    No Custom & Partner Reward Redemption Activity Records Found ....
                                                </div>
                                            @endforelse
                                        </div>
                                        <br>

                                    </div>
                                    {{$company_activity->links()}}
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

</div>
