<x-app-layout>
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


        // total kudos outstanding
        $total_kudos = $company->users->pluck('points')->sum();
        $total_kudos_to_give = $company->users->pluck('points_to_give')->sum();


        $total_kudos_sent = $company->users->pluck('recievers')->flatten()->unique()->pluck('amount')->sum();


        //layering redemptions to kudos plot
        $total_kudos_redeemed = ((float)$company->transactions->unique()->where('type','=','2')->pluck('amount')->sum())*-1;

        // time layering
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

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


    <div class="container mx-auto sm:px-4 py-10 md:py-12">

        <div>

            <!-- Add Team Member -->
            <div class="mt-10 sm:mt-0">
                <x-jet-form-section submit="addNewUser">
                    <x-slot name="title">
                        {{ substr($company->name, 0, 20) }} Engagement Dashboard
                    </x-slot>

                    <x-slot name="description">
                        The {{ appName() }} engagement dashboard allows admin users to monitor activity, generate
                        reports, and
                        dive deeper into the platform.
                    </x-slot>

                    <x-slot name="form">
                        <div class="col-span-12 ">
                            <div class="max-w-xl text-sm text-gray-600 font-bold">
                                Current {{ getReplacedWordOfKudos() }} Status
                            </div>
                        </div>
                        <div class="col-span-12 sm:col-span-12 flex grid lg:grid-cols-4 md:grid-cols-2 grid-cols-1">
                            <div class="text-center bg-blue-50 shadow border border-gray-200 py-1 m-1 rounded px-2 ">
                                <div class="max-w-xl text-xl text-gray-800 font-bold mt-2">
                                    {{number_format($total_kudos)}}
                                </div>
                                <div>
                                    <div class="italic text-xs"> Outstanding {{ getReplacedWordOfKudos() }}</div>
                                </div>
                            </div>

                            <div class="text-center bg-pink-50 shadow border border-gray-200 py-1 m-1 rounded px-2 ">
                                <div class="max-w-xl text-xl text-gray-800 font-bold mt-2">
                                    {{number_format($total_kudos_to_give)}}
                                </div>
                                <div>
                                    <div class="italic text-xs"> {{ getReplacedWordOfKudos() }} available to give</div>
                                </div>
                            </div>

                            <div class="text-center bg-gray-50 shadow border border-gray-200 py-1 m-1 rounded px-2 ">
                                <div class="max-w-xl text-xl text-gray-800 font-bold mt-2">
                                    {{number_format($total_kudos_sent)}}
                                </div>
                                <div>
                                    <div class="italic text-xs"> {{ getReplacedWordOfKudos() }} sent</div>
                                </div>
                            </div>


                            <div class="text-center bg-green-50 shadow border border-gray-200 py-1 m-1 rounded px-2 ">
                                <div class="max-w-xl text-xl text-gray-800 font-bold mt-2">
                                    {{number_format($total_kudos_redeemed)}}
                                </div>
                                <div>
                                    <div class="italic text-xs">{{ getReplacedWordOfKudos() }} redeemed</div>
                                </div>
                            </div>
                        </div>


                        <!--  for the stats -->

                        <div class="col-span-12 ">
                            <div class="max-w-xl text-sm text-gray-600 font-bold">
                                {{ __('Engagement Statistics') }}
                            </div>
                        </div>
                        <div class="col-span-12 sm:col-span-12 flex grid lg:grid-cols-4 md:grid-cols-2 grid-cols-1">
                            <div class="text-center bg-blue-50 shadow border border-gray-200 py-1 m-1 rounded px-2 ">
                                <div class="max-w-xl text-xl text-gray-800 font-bold mt-2">
                                    @if($total_kudos_sent>0)
                                        {{number_format(100*((float)$total_kudos_redeemed)/((float)$total_kudos_sent),2)}}
                                        %
                                    @else
                                        N/A
                                    @endif
                                </div>
                                <div>
                                    <div class="italic text-xs">of sent {{ getReplacedWordOfKudos() }} have been
                                        redeemed
                                    </div>
                                </div>
                            </div>

                            <div class="text-center bg-pink-50 shadow border border-gray-200 py-1 m-1 rounded px-2 ">
                                <div class="max-w-xl text-xl text-gray-800 font-bold mt-2">
                                    {{number_format(100*$company->users->where('last_login',">",\Carbon\Carbon::now()->subDays(60))->count()/$company->users->unique()->count(),2)}}
                                    %
                                </div>
                                <div>
                                    <div class="italic text-xs">users logged in within 60 days</div>
                                </div>
                            </div>

                            <div class="text-center bg-gray-50 shadow border border-gray-200 py-1 m-1 rounded px-2 ">
                                <div class="max-w-xl text-xl text-gray-800 font-bold mt-2">
                                    @if ($company->users->unique()->count())
                                        {{
                                            number_format(100*
                                            ($company->users
                                            ->pluck('recievers')
                                            ->flatten()->unique()
                                            ->where('created_at',">=",\Carbon\Carbon::now()->subDays(60))
                                            ->pluck('reciever')
                                            ->flatten()
                                            ->unique()
                                            ->where('company_id',$company->id)
                                            ->count()

                                                /$company->users->unique()->count()),2)
                                        }}%
                                    @endif
                                </div>
                                <div>
                                    <div class="italic text-xs">users received {{ getReplacedWordOfKudos() }} within 60
                                        days
                                    </div>
                                </div>
                            </div>


                            <div class="text-center bg-green-50 shadow border border-gray-200 py-1 m-1 rounded px-2 ">
                                <div class="max-w-xl text-xl text-gray-800 font-bold mt-2">
                                    @if ($company->users->unique()->count())
                                        {{
                                        number_format(100*
                                        ($company->users
                                        ->pluck('recievers')
                                        ->flatten()->unique()
                                        ->where('created_at',">=",\Carbon\Carbon::now()->subDays(60))
                                        ->pluck('giver')
                                        ->flatten()
                                        ->unique()
                                        ->where('company_id',$company->id)
                                        ->count()

                                        / $company->users->unique()->count()),2)
                                    }}%
                                    @endif
                                </div>
                                <div>
                                    <div class="italic text-xs">users sent {{ getReplacedWordOfKudos() }} within 60
                                        days
                                    </div>
                                </div>
                            </div>
                        </div>
                    </x-slot>
                </x-jet-form-section>
            </div>


            <!-- Add Team Member -->
            <div class="mt-10 sm:mt-0 mb-5"></div>

            <div class="mt-10 sm:mt-0 ">

                @livewire('kudo-activity',['company'=>$company])

            </div>


                <div class="mt-10 sm:mt-0 mb-5"></div>

                <x-jet-form-section submit="addNewUser">
                    <x-slot name="title">
                        Monitor {{ getReplacedWordOfKudos() }} by Team
                    </x-slot>

                    <x-slot name="description">
                        View amount of {{ getReplacedWordOfKudos() }} received by each team!
                    </x-slot>

                    <x-slot name="form">
                        <div class="col-span-12 border-t border-gray-200">
                            <div class="max-w-xl text-sm text-gray-600 font-bold pt-3 ">
                                {{ getReplacedWordOfKudos() }} Received by Team
                            </div>
                        </div>

                        @if($company->anyTeamHavingUsersMoreThan(2))
                            <div class="col-span-12 md:col-start-2 md:col-span-8 text-center">
                                <canvas id="myChart2"></canvas>
                            </div>
                        @else
                            <div class="text-center text-gray-500 p-5 text-sm border border-gray-200 col-span-12">
                                No {{ getReplacedWordOfKudos() }} have been sent yet, check back in when you have more
                                activity!
                            </div>
                        @endif
                    </x-slot>
                </x-jet-form-section>
            </div>
        </div>
    </div>



    <script type="text/javascript">

        const data2 = {
            labels: [
                @foreach(Auth::user()->company->teams as $t)
                    '{{$t->name}}',
                @endforeach
            ],
            datasets: [
                {
                    label: 'Dataset 1',
                    data: [@foreach(Auth::user()->company->teams as $t)
                        @if($t->users()->count() > 2)
                        {{$t->users->pluck('recievers')->flatten()->unique()->pluck('amount')->sum()}},
                        @endif

                        @endforeach],
                    backgroundColor: ["#BFDBFE", "#FECACA", "#10B981",
                        "#D97706", "#10B981", "#818CF8", "#DB2777", "#D1D5DB", "#DB2777", "#F87171", "#4338CA", "#EFF6FF", "#FDF2F8", "#ECFDF5", "#FEF3C7", "#F3F4F6", "#EDE9FE", "#F9A8D4", "#BFDBFE", "#FECACA", "#F87171",
                        "#D97706", "#10B981", "#818CF8", "#DB2777", "#D1D5DB", "#DB2777", "#4338CA",
                        "#BFDBFE", "#FECACA", "#F87171",
                        "#D97706", "#10B981", "#818CF8", "#DB2777", "#D1D5DB", "#DB2777", "#4338CA", "#EFF6FF", "#FDF2F8", "#ECFDF5", "#FEF3C7", "#F3F4F6", "#EDE9FE", "#F9A8D4", "#BFDBFE", "#FECACA", "#F87171",
                        "#D97706", "#10B981", "#818CF8", "#DB2777", "#D1D5DB", "#DB2777", "#4338CA"],
                }
            ]
        };


        const config2 = {
            type: 'pie',
            data: data2,
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    }
                }
            },
        };

        var myChart2 = new Chart(
            document.getElementById('myChart2'),
            config2
        );


    </script>
</x-app-layout>
