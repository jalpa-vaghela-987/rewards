<x-app-layout>


    <div class="container mx-auto px-4 py-10 md:py-12">
        <div class="p-8 bg-white my-10 border border-gray-300 rounded rounded-t-lg ">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Transaction History for {{Auth::user()->name}}
            </h2>

            <div name="description">

                You currently have <b>{{ number_format(Auth::user()->points) }}</b> {{ getReplacedWordOfKudos() }} available
                <br>
                <span
                    class="italic text-sm">You may use these {{ getReplacedWordOfKudos() }} to buy awesome rewards!</span><br>
                <div class="grid grid-cols-12 w-full my-5 py-3 rounded">
                    <h3 class="text-lg col-start-1 col-span-8 mb-3 italic border-b border-gray-400  pb-2">Transaction
                        History</h3>
                    <a class="wrapper text-sm col-span-4  pb-2 mb-3 border-b border-gray-400 text-right text-blue-700" href="/export-wallet">
                    <span class="text-lg ">
                        <i class="fas fa-upload text-xl cursor-pointer  text-gray-700 "></i>
                         Export
                    </span>

                    </a>
{{--                    <a class="col-span-4  pb-2 mb-3 text-lg italic border-b border-gray-400 text-right text-blue-700"--}}
{{--                       href="/export-wallet">Export </a>--}}
                    <div class="col-span-12 grid grid-cols-12">
                        @forelse($transactions as $t)
                            <div
                                class="col-start-1 col-span-2 mx-2 text-left text-sm  py-2 @if($t->amount > 0) text-green-500 @else text-red-500 @endif">
                                @if($t->amount > 0) {{number_format($t->amount)}} @else {{ "(".number_format(abs($t->amount)).")" }} @endif</div>
                            <div class="col-start-3 col-span-6 mx-2 text-xs text-blue-600 text-left  py-2">
                                <a href="{{$t->link}}">
                                    @if($t->type == 2)
                                        {{$t->user->name}} {{$t->note}}
                                    @else
                                        {{$t->note}}
                                    @endif
                                </a></div>
                            <div
                                class="md:col-start-9 col-span-4 mx-2 italic text-xs text-right  py-2">
                                {{ Timezone::convertToLocal($t->created_at, 'F jS, Y \- g:i A') }}</div>
                            <div class="col-start-1 col-span-12 border-b border-gray-300 border-dashed mb-1"></div>
                        @empty
                           <div class="col-start-1 col-span-12 border-b border-gray-300 border-dashed mb-1">
                                No Transaction History</div>
                        @endforelse

                    </div>

                </div>
                {{$transactions->links()}}
            </div>
        </div>
    </div>

</x-app-layout>
