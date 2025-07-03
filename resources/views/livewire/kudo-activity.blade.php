<div>
    @php
        //gets the amount (# not volume) of kudos sent each of the last 6 months
        $c = Carbon\Carbon::now();
        $c2 = Carbon\Carbon::now()->subMonths(5)->firstOfMonth();
        $kudos_5 = $company->users->pluck('recievers')->flatten()->unique()
            ->where('created_at',">=",$c2->format('Y-m-d'))
            ->where('created_at',"<",$c2->addMonths(1)->firstOfMonth()->format('Y-m-d'))
            ->pluck('amount')->sum();
        $kudos_4 = $company->users->pluck('recievers')->flatten()->unique()
            ->where('created_at',">=",$c2->format('Y-m-d'))
            ->where('created_at',"<",$c2->addMonths(1)->firstOfMonth()->format('Y-m-d'))
            ->pluck('amount')->sum();
        $kudos_3 = $company->users->pluck('recievers')->flatten()->unique()
            ->where('created_at',">=",$c2->format('Y-m-d'))
            ->where('created_at',"<",$c2->addMonths(1)->firstOfMonth()->format('Y-m-d'))
            ->pluck('amount')->sum();
        $kudos_2 = $company->users->pluck('recievers')->flatten()->unique()
            ->where('created_at',">=",$c2->format('Y-m-d'))
            ->where('created_at',"<",$c2->addMonths(1)->firstOfMonth()->format('Y-m-d'))
            ->pluck('amount')->sum();
        $kudos_1 = $company->users->pluck('recievers')->flatten()->unique()
            ->where('created_at',">=",$c2->format('Y-m-d'))
            ->where('created_at',"<",$c2->addMonths(1)->firstOfMonth()->format('Y-m-d'))
            ->pluck('amount')->sum();
        $kudos_0 = $company->users->pluck('recievers')->flatten()->unique()
            ->where('created_at',">=",$c2->format('Y-m-d'))
            ->where('created_at',"<",$c2->addMonths(1)->firstOfMonth()->format('Y-m-d'))
            ->pluck('amount')->sum();



        $c3 = Carbon\Carbon::now()->subMonths(5)->firstOfMonth();
        $redemptions_5 = $company->redemptions->flatten()->unique()
            ->where('created_at',">=",$c3->format('Y-m-d'))
           ->where('created_at',"<",$c3->addMonths(1)->firstOfMonth()->format('Y-m-d'))
            ->pluck('cost')->sum();
        $redemptions_4 = $company->redemptions->flatten()->unique()
            ->where('created_at',">=",$c3->format('Y-m-d'))
           ->where('created_at',"<",$c3->addMonths(1)->firstOfMonth()->format('Y-m-d'))
            ->pluck('cost')->sum();
        $redemptions_3 = $company->redemptions->flatten()->unique()
            ->where('created_at',">=",$c3->format('Y-m-d'))
           ->where('created_at',"<",$c3->addMonths(1)->firstOfMonth()->format('Y-m-d'))
            ->pluck('cost')->sum();
        $redemptions_2 = $company->redemptions->flatten()->unique()
            ->where('created_at',">=",$c3->format('Y-m-d'))
           ->where('created_at',"<",$c3->addMonths(1)->firstOfMonth()->format('Y-m-d'))
            ->pluck('cost')->sum();
        $redemptions_1 = $company->redemptions->flatten()->unique()
            ->where('created_at',">=",$c3->format('Y-m-d'))
           ->where('created_at',"<",$c3->addMonths(1)->firstOfMonth()->format('Y-m-d'))
            ->pluck('cost')->sum();
        $redemptions_0 = $company->redemptions->flatten()->unique()
            ->where('created_at',">=",$c3->format('Y-m-d'))
           ->where('created_at',"<",$c3->addMonths(1)->firstOfMonth()->format('Y-m-d'))
            ->pluck('cost')->sum();
    @endphp
    <div class="mt-10 sm:mt-0 mb-5">
        <div class="md:grid md:grid-cols-3 md:gap-6">
            <div class="md:col-span-1 mb-6">
                <div class="px-4 md:px-0">
                    <h3 class="text-lg font-medium text-gray-900">Track {{ getReplacedWordOfKudos() }} Over Time</h3>

                    <p class="mt-1 text-sm text-gray-600">
                        Monitor engagement and the flow of {{ getReplacedWordOfKudos() }} over time. Monitor the amount
                        of {{ getReplacedWordOfKudos() }} sent vs.
                        redeemed.
                    </p>
                </div>
            </div>

            <div class="mt-5 md:mt-0 md:col-span-2">
                <div>
                    <div class="bg-white shadow px-4 py-5 sm:rounded-b-md ">
                        <div class="grid grid-cols-6 gap-6">
                            <div class="col-span-12 ">
                                <div class="col-span-12 border-t border-gray-200 mb-6">
                                    <div class="max-w-xl text-sm text-gray-600 font-bold pt-3 ">
                                        {{ getReplacedWordOfKudos() }} Activity Over Time
                                    </div>
                                </div>


                                <!-- User Search -->
                                <div class="col-span-12  text-center mb-6">
                                    <canvas id="myChart"></canvas>
                                </div>
                                <div class="col-span-12 border-t border-gray-200 pt-3 mb-6">
                                    <div class="col-span-12 grid grid-cols-12 ">
                                        <div class="col-start-1 col-span-9 text-sm text-gray-600 font-bold">
                                            {{ getReplacedWordOfKudos() }} Activity
                                        </div>
                                        <div class="col-start-10 col-span-3 italic text-xs text-right font-bold text-blue-700 ">
                                            <a href="/exportData">
                                                <span class="text-sm ">
                                                    <i class="fas fa-upload text-sm cursor-pointer  text-gray-700 "></i>
                                                    Export
                                                </span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-span-12 sm:col-span-12 -mt-1">
                                    <div class="w-full">
                                        <div
                                            class="col-span-12 grid grid-cols-12 overflow-y-scroll border border-gray-200  lg:max-h-120 sm:max-h-240">
                                            @forelse($companies->unique() as $t)
                                                <div
                                                    class="col-start-1 col-span-2 mx-2 my-0 text-left text-sm  py-0 @if($t->amount > 0) text-green-500 @else text-red-500 @endif">
                                                    @if($t->amount > 0)
                                                        {{number_format($t->amount)}} @else {{ "(".number_format(abs($t->amount)).")" }} @endif
                                                </div>

                                                <div
                                                    class="col-start-3 col-span-6 mx-2 text-xs text-gray-600 text-left  my-0 py-0">
                                                    <a>
                                                        @if($t->type == 1 && $t->point->reciever && $t->point->giver)
                                                            {{$t->point->reciever->name}}
                                                            received @if($t->point->is_super)
                                                                super @endif {{ getReplacedWordOfKudos() }}
                                                            from {{$t->point->giver->name}}
                                                        @elseif($t->type == 2)
                                                            {{$t->user->name}} {{$t->note}}
                                                        @else
                                                            {{$t->note}}
                                                        @endif
                                                    </a>
                                                </div>

                                                <div
                                                    class="md:col-start-9 col-span-4 mx-2 italic text-xs text-right  py-0 my-0">
                                                    {{ Timezone::convertToLocal($t->created_at, 'F jS, Y \- g:i A') }}
                                                </div>

                                                <div
                                                    class="col-start-1 col-span-12 border-b border-gray-300 border-dashed my-0">
                                                </div>
                                            @empty
                                                <div class="text-center text-gray-500 p-5 text-sm col-span-12">
                                                    No {{ getReplacedWordOfKudos() }} Sent Yet !
                                                </div>
                                            @endforelse

                                        </div>
                                        <br>
                                        {{$companies->links()}}
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
<script type="text/javascript">

    console.log('{!! false !!}');

    const labels = [
        '{{$c->subMonths(5)->format("F")}}',
        '{{$c->addMonths(1)->format("F")}}',
        '{{$c->addMonths(1)->format("F")}}',
        '{{$c->addMonths(1)->format("F")}}',
        '{{$c->addMonths(1)->format("F")}}',
        '{{$c->addMonths(1)->format("F")}}',
    ];

    const data = {
        labels: labels,
        datasets: [{
            label: '{{ getReplacedWordOfKudos() }} Sent',
            backgroundColor: '#DB2777',
            borderColor: '#DB2777',
            data: [{{($kudos_5)}}, {{($kudos_4)}}, {{($kudos_3)}},
                {{($kudos_2)}}, {{($kudos_1)}}, {{($kudos_0)}}],
        },
            {
                label: '{{ getReplacedWordOfKudos() }} Redemptions',
                backgroundColor: '#3B82F6',
                borderColor: '#3B82F6',
                data: [{{($redemptions_5)}}, {{($redemptions_4)}}, {{($redemptions_3)}},
                    {{($redemptions_2)}}, {{($redemptions_1)}}, {{($redemptions_0)}}],
            }


        ]
    };

    const config = {
        type: 'line',
        data,
        options: {}
    };

    var myChart = new Chart(
        document.getElementById('myChart'),
        config
    );

</script>
