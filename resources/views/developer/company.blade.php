<x-app-layout>


    <div class="container mx-auto px-4 py-10 md:py-12">
        <div class="p-8 bg-white my-10 border border-gray-300 rounded rounded-t-lg ">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight truncate">
                {{$company->name}} Summary
            </h2>

            <div name="description">
                <a class="text-blue-500 underline mt-1" href="/developer/companies">View All Companies</a><br>

                <div class="grid grid-cols-12 w-full my-5 py-3 rounded">
                    <h3 class="text-lg col-start-1 col-span-12 mb-3 italic border-b border-gray-400 pb-2">Transaction
                        History</h3>
                    <div class="col-span-12 grid grid-cols-12">

                        <div
                            class="col-start-1 col-span-3 mx-2 my-0 text-left text-sm  py-0">
                            Name & Email
                        </div>
                        <div class="col-start-4 col-span-1 mx-2 my-0 text-left text-xs  py-0">
                            Level
                        </div>

                        <div class="col-start-5 col-span-1 mx-2 text-xs text-gray-600 text-left  my-0 py-0"><a
                            >
                                Role
                            </a></div>
                        <div class="col-start-6 col-span-1 mx-2 text-xs text-gray-600 text-left  my-0 py-0">
                            {{ getReplacedWordOfKudos() }}
                        </div>
                        <div class="col-start-7 col-span-1 mx-2 text-xs text-gray-600 text-left  my-0 py-0">
                            {{ getReplacedWordOfKudos() }} to Give
                        </div>
                        <div
                            class="md:col-start-8 col-span-2 mx-2 italic text-xs text-right  py-0 my-0">Last Login
                        </div>
                        <div
                            class="md:col-start-10 col-span-2 mx-2 italic text-xs text-right  py-0 my-0">Account Created
                        </div>
                        <div class="col-start-1 col-span-12 border-b border-gray-800 my-0"></div>


                        @forelse($company->users->where('active',1) as $u)
                            <div class="col-start-1 col-span-3 mx-2 my-0 text-left text-sm  py-0">
                                <b>{{$u->name}}</b>
                            </div>
                            <div class="col-start-1 col-span-3 mx-2 my-0 text-left text-sm  py-0">
                                <i>{{$u->email}}</i>
                            </div>
                            <div class="col-start-4 col-span-1 mx-2 my-0 text-left text-xs  py-0">
                                {{$u->level}}
                            </div>

                            <div class="col-start-5 col-span-1 mx-2 text-xs text-gray-600 text-left  my-0 py-0">
                                @if($u->role == 1) Admin
                                @else Standard
                                @endif</div>
                            <div class="col-start-6 col-span-1 mx-2 text-xs text-gray-600 text-left  my-0 py-0">
                                {{number_format($u->points)}}</div>
                            <div class="col-start-7 col-span-1 mx-2 text-xs text-gray-600 text-left  my-0 py-0">
                                {{number_format($u->points_to_give)}}</div>
                            <div
                                class="md:col-start-8 col-span-2 mx-2 italic text-xs text-right  py-0 my-0">
                                @if($u->last_login)
                                    {{ Timezone::convertToLocal(\Carbon\Carbon::parse($u->last_login), 'F jS, Y \- g:i A') }}
                                @else
                                    N/A
                                @endif

                            </div>
                            <div
                                class="md:col-start-10 col-span-2 mx-2 italic text-xs text-right  py-0 my-0">{{ Timezone::convertToLocal($u->created_at, 'F jS, Y \- g:i A') }}</div>
                            <div class="col-start-1 col-span-12 border-b border-gray-300 border-dashed my-0"></div>
                        @empty
                            No Users
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
