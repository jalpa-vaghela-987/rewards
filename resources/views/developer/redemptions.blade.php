<x-app-layout>


    <div class="container mx-auto px-4 py-10 md:py-12">
        <div class="p-8 bg-white my-10 border border-gray-300 rounded rounded-t-lg ">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Entire {{ appName() }} Redemption History
            </h2>

            <div name="description">
                <div class="col-start-1 col-span-12 my-6">
                    {{ $ts->links() }}
                </div>

                <div class="grid grid-cols-12 w-full my-5 py-3 rounded">
                    <h3 class="text-lg col-start-1 col-span-12 mb-3 italic border-b border-gray-400 pb-2">
                        Transaction History
                    </h3>

                    <div class="col-span-12 grid grid-cols-12">
                        @forelse($ts as $t)
                               <div
                                class="col-start-1 col-span-1 mx-2 my-0 text-left text-sm  py-0 @if($t->amount > 0) text-green-500 @else text-red-500 @endif">
                                @if($t->amount > 0) {{number_format($t->amount)}} @else {{ "(".number_format(abs($t->amount)).")" }} @endif</div>
                            <div class="col-start-2 col-span-2 mx-2 my-0 text-left text-xs  py-0 truncate">
                                {{$t->user->company->name}}
                                </div>

                            <div class="col-start-4 col-span-4 mx-2 text-xs text-gray-600 text-left  my-0 py-0"><a
                                    >
                                    @if($t->type == 1)
                                    {{$t->point->reciever->name}} received @if($t->point->is_super) super @endif {{ getReplacedWordOfKudos() }} from {{$t->point->giver->name}}
                                    @elseif($t->type == 2)
                                    {{$t->user->name}} {{$t->note}}
                                    @else
                                    {{$t->note}}
                                    @endif
                                </a></div>
                            <div
                                class="md:col-start-9 col-span-4 mx-2 italic text-xs text-right  py-0 my-0">{{ Timezone::convertToLocal($t->created_at, 'F jS, Y \- g:i A') }}</div>
                            <div class="col-start-1 col-span-12 border-b border-gray-300 border-dashed my-0"></div>
                        @empty
                            No Transaction History
                        @endforelse
                    </div>
                </div>
                 {{ $ts->links() }}
            </div>
        </div>
    </div>

</x-app-layout>
