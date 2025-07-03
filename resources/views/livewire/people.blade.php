<div class="overflow-x-hidden">
    <div class="md:flex w-full mt-3 m-1 overflow-x-hidden">
        <div class="flex w-full md:block md:w-1/5 m-3">
            <div>
                @if(auth()->user()->company->logo_path)
                    <img class="object-contain" style="height:100px;width:100px;"
                         src="{!! auth()->user()->company->logo_path !!}"
                         alt="{{ auth()->user()->company->name }}"/>
                @else
                    <h2 class="text-xl">{{auth()->user()->company->name}}</h2>
                @endif
                <div class="italic ml-2">{{$users->count()}} Members</div>
                <div class="italic ml-2">Created on {{auth()->user()->company->created_at->format('F jS, Y') }}</div>
            </div>
            <div>
                <div class="font-semibold ml-2">Company Administrators:</div>
                <div class="ml-2">
                    @foreach($users->where('role',1)->sortBy('name') as $user)
                        <div>
                            <a class="text-sm hover:bg-gray-100 p-1 text-blue-700"
                               href="{{route('profile.user',['user' => $user->id])}}">
                                {{$user->name}}
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="flex-1  m-3 ml-5 md:m-0 md:ml-5 p-3 bg-white shadow rounded border border-gray-200">
            <div class="m-1 p-1 w-full border-b-2 border-gray-300">
                <h2 class="text-xl">
                    Members of {{auth()->user()->company->name}} using {{ appName() }}
                </h2>
            </div>
            <div
                class="grid grid-cols-1 xs:grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-4 w-2/4 overflow-y-scroll overflow-x-hidden w-full"
                style="max-height: 70vh;">
                @foreach($users as $user)
                    <div class="m-2">
                        @include('people.card', ['user' => $user])
                    </div>
                @endforeach
            </div>
        </div>

        <div class="sm:flex block w-full md:block md:w-1/5 m-3">
            <div class="sm:flex flex-col md:w-full sm:w-6/12 w-full">
                <b>Upcoming Birthdays & Work Anniversaries</b>

                <ul role="list" class="divide-y divide-gray-200 p-2 m-2 overflow-y-scroll" style="max-height: 70vh;">
                    @forelse($upcomingSpecialDays as $upcomingSpecialDay)
                        <li class="py-4 flex">
                            <img class="h-10 w-10 rounded-full" src="{{ $upcomingSpecialDay->profile_photo_url }}" alt="">
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-900 font-bold">
                                    <a href="{{route('profile.user',['user' => $upcomingSpecialDay->id])}}">
                                        {{ $upcomingSpecialDay->name }}
                                    </a>

                                    <a class="text-sm tooltip" href="mailto:{{ $upcomingSpecialDay->email }}" title="{{ $upcomingSpecialDay->email }}">
                                        <i class="fa fa-envelope text-indigo-400 hover:text-indigo-700"></i>
                                    </a>
                                </p>

                                <p class="text-sm font-medium text-gray-900 italic">{{ $upcomingSpecialDay->position }}</p>

                                @if($upcomingSpecialDay->special_day === 'birthday')
                                <p class="text-sm text-gray-500 tooltip" title="Birthday">
                                    <i class="fa-fw fa fa-birthday-cake text-pink-400"></i> {{ Carbon\Carbon::parse($upcomingSpecialDay->special_day_at)->format('F jS') }}
                                </p>
                                @endif

                                @if($upcomingSpecialDay->special_day === 'anniversary')
                                <p class="text-sm text-gray-500 tooltip" title="Work Anniversary">
                                    <i class="fa-fw fas fa-university text-gray-900"></i>
                                    {{ Carbon\Carbon::parse($upcomingSpecialDay->special_day_at)->format('F jS') }}
                                    ({{ \Carbon\Carbon::parse($upcomingSpecialDay->special_day_at)->diffInYears() + 1 }} Years)
                                </p>
                                @endif
                            </div>
                        </li>
                    @empty
                        <li class="py-4 flex">
                            No Results Found
                        </li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>

    @foreach($teams as $team)
        @if($team->users()->count())
            <div class="md:flex w-full mt-3 m-1 overflow-hidden mt-5 p-3 border-t border-gray-200">
                <div class="flex w-full md:block md:w-1/5 m-3">
                    <div>
                        <h1 class="text-lg">
                            {{$team->name}}
                        </h1>

                        <div class="italic ml-2">
                            {{$team->users()->count()}} Members
                        </div>

                        <div class="italic ml-2">
                            Created on {{$team->created_at->format('F jS, Y') }}
                        </div>
                    </div>

                    <div>
                        <div class="font-semibold ml-2">
                            Team Administrators:
                        </div>

                        <div class="ml-2">
                            @foreach($team->users()->where('active',1)->orderBy('name')->get() as $a)
                                @if($a->hasTeamRole($team, 'admin'))
                                    <div>
                                        <a class="text-sm hover:bg-gray-100 p-1 text-blue-700"
                                           href="{{route('profile.user',['user' => $a->id])}}">
                                            {{$a->name}}
                                        </a>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>

                <div
                    class="flex-1 m-3 ml-5 md:m-0 md:ml-5 p-3  bg-white shadow rounded border border-gray-200 overflow-hidden">
                    <div class="m-1 p-1 w-full border-b-2 border-gray-300">
                        <h2 class="text-xl">
                            Members of {{$team->name}}
                        </h2>
                    </div>

                    <div
                        class="grid grid-cols-1 xs:grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-4 p-2 overflow-y-auto overflow-x-hidden  w-2/4w-full gap-4"
                        style="max-height: 70vh;">
                        @foreach($team->users()->where('active',1)->orderBy('name')->get() as $user)
                            @include('people.card', ['user' => $user])
                        @endforeach
                    </div>
                </div>

                <div class="flex w-full md:block md:w-1/5 m-3">
                    <div class="sm:flex flex-col md:w-full sm:w-6/12 w-full">

                        @php
                           // $users = \App\Models\User::whereIn('id', $team->users()->pluck('user_id'))
                             //   ->hasUpcomingSpecialDay()
                               // ->get(['id', 'name', 'email', 'position', 'email', 'birthday', 'anniversary']);

                        @endphp

                        <b>Upcoming Birthdays and Work Anniversaries</b>

                        <ul role="list" class="divide-y divide-gray-200 p-2 m-2 overflow-x-hidden overflow-y-scroll" style="max-height: 70vh;">

                            @forelse($this->getUpcomingSpecialDaysUsersForTeam($team) as $upcomingSpecialDay)

                                <li class="py-4 flex">
                                    <img class="h-10 w-10 rounded-full" src="{{ $upcomingSpecialDay->profile_photo_url }}"
                                         alt="">
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-gray-900 font-bold">
                                            <a href="{{route('profile.user',['user' => $upcomingSpecialDay->id])}}">
                                                {{ $upcomingSpecialDay->name }}
                                            </a>

                                            <a href="mailto:{{ $upcomingSpecialDay->email }}" title="{{ $upcomingSpecialDay->email }}" class="text-sm text-gray-500 tooltip">
                                                <i class="fa fa-envelope text-indigo-400 hover:text-indigo-700"></i>
                                            </a>
                                        </p>

                                        <p class="text-sm font-medium text-gray-900 italic">{{ $upcomingSpecialDay->position }}</p>

                                        @if($upcomingSpecialDay->special_day === 'birthday')
                                            <p class="text-sm text-gray-500 tooltip" title="Birthday">
                                                <i class="fa-fw fa fa-birthday-cake text-pink-400"></i> {{ Carbon\Carbon::parse($upcomingSpecialDay->special_day_at)->format('F jS') }}
                                            </p>
                                        @endif

                                        @if($upcomingSpecialDay->special_day === 'anniversary')
                                            <p class="text-sm text-gray-500 tooltip" title="Work Anniversary">
                                                <i class="fa-fw fas fa-university text-gray-900"></i>
                                                {{ Carbon\Carbon::parse($upcomingSpecialDay->special_day_at)->format('F jS') }}
                                                ({{ \Carbon\Carbon::parse($upcomingSpecialDay->special_day_at)->diffInYears() + 1 }} Years)
                                            </p>
                                        @endif
                                    </div>
                                </li>
                            @empty
                                <li class="py-4 flex">
                                    No Results Found
                                </li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>
        @endif
    @endforeach
</div>
