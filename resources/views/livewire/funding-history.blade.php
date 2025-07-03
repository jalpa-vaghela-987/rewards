<div class="">
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
                                <div class="max-w-xl text-sm text-gray-600 font-bold">
                                    Funding History
                                </div>
                                <div
                                    class="md:col-start-9 col-span-4 mx-2 italic text-xs text-right font-bold text-blue-700">
                                    <a href="/export-funding">
                                    <span class="text-sm ">
                                            <i class="fas fa-upload text-sm cursor-pointer  text-gray-700 "></i>
                                        Export
                                    </span>
                                    </a>

                                </div>
                                <div class="col-span-12 sm:col-span-12 -mt-1 pt-2">
                                    <div class="w-full">
                                        <div
                                            class="col-span-12 grid grid-cols-12 overflow-y-scroll border border-gray-200 space-y-0.5 lg:max-h-120 sm:max-h-240">

                                            @forelse($funding as $t)
                                                <div
                                                    class="col-start-1 sm:col-span-2 lg:col-span-2 mx-2 my-0 text-left text-sm  py-0 @if($t->type == 1) text-green-500 @else text-red-500 @endif">
                                                    @if($t->type == 1)
                                                        ${{(number_format((float)$t->amount,2))
                                            }}
                                                    @else
                                                        ${{ "(".(number_format(abs((float)$t->amount),2)).")" }}
                                                    @endif
                                                </div>
                                                <div
                                                    class="col-start-3 sm:col-span-1  lg:col-span-2 mx-2 text-xs text-gray-600 text-left col-span-2 my-0 py-0">
                                                    @if($t->redemption)
                                                        {{currencyNumber($t->redemption->value,$t->redemption->currency)}}
                                                    @else
                                                        {{(number_format((float)$t->amount,2))}}
                                                    @endif
                                                </div>

                                                <div
                                                    class="lg:col-start-5 sm:col-start-6 col-span-5 lg:col-span-5 sm:col-span-6 mx-2 text-xs text-gray-600 text-left  my-0 py-0">
                                                    <a class="break-words">
                                                        @if($t->type == 1)
                                                            {{$t->user->name}} funded
                                                            ${{(number_format((float)$t->amount,2))}}
                                                            to {{ appName() }}
                                                        @else
                                                            {{$t->user->name}} redeemed {{ getReplacedWordOfKudos() }}
                                                            for
                                                            @if($t->redemption)
                                                                {{currencyNumber($t->redemption->value,$t->redemption->currency)}}
                                                            @else
                                                                ${{(number_format((float)$t->amount,2))}}
                                                            @endif
                                                            of Partner Rewards
                                                        @endif
                                                    </a>
                                                </div>

                                                <div
                                                    class="md:col-start-10 col-span-3 mx-2 italic text-xs text-right  py-0 my-0">
                                                    {{ Timezone::convertToLocal($t->created_at, 'F jS, Y \- g:i A') }}
                                                </div>

                                                <div
                                                    class="col-start-1 col-span-12 border-b border-gray-300 border-dashed my-0"></div>
                                            @empty
                                                <div class="col-span-12 text-gray-500 pl-48">
                                                    No Funding History Records Found ....
                                                </div>
                                            @endforelse
                                        </div>
                                        <br>
                                        {{$funding->links()}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
