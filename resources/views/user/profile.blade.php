<x-app-layout>
    <div class="container mx-auto px-4 py-10">
        <div class="profile-page max-w-2xl mx-auto bg-white shadow rounded-md overflow-hidden">
            <div class="">
                @if(auth()->user()->id == $user->id || auth()->user()->role == 1)
                    <a class="ml-5 mt-10"
                       href="{{ route('profile.show', ['user' => auth()->id() != $user->id ? $user : null ]) }}">
                         <span class="tooltip mt-5" title="Edit Profile">
                            <i class="fas fa-pen fa-lg text-gray-900 mt-5"></i>
                            <span class="italic text-sm text-gray-500"></span>
                        </span>
                    </a>
                @endif
                <div class="float-right m-5 italic text-gray-500">
                <!-- {{$user->progress}} -->
                </div>
            </div>

            <div class="w-full pt-5 lg:pt-8">
                <div class="w-24 h-24 md:w-32 md:h-32 m-auto">
                    <img
                        alt=""
                        src="{{ $user->profile_photo_url }}"
                        class="shadow rounded-full m-auto h-full w-full object-cover object-center"
                    />
                </div>
            </div>

            <div class="text-center mt-2">
                <h3 class="text-3xl md:text-4xl font-semibold leading-normal text-gray-800 my-4">
                    {{$user->name}}

                    <a class="ml-1 text-xl align-middle tooltip" href="mailto:{{ $user->email }}" title="{{ $user->email }}">
                        <i class="fa fa-envelope text-indigo-400 hover:text-indigo-700"></i>
                    </a>
                </h3>
                <div class="text-sm leading-normal mt-0 text-gray-500 font-bold uppercase">
                    <i class="fas briefcase mr-2 text-lg text-gray-500"></i>
                    {{$user->position}}
                </div>
            </div>

            <div class="w-full text-center px-4 lg:px-8 my-2">
                <div class="m-2">{{$user->name}} is a member of {{count($user->allTeams())}}
                    @if(count($user->allTeams())==1) team: @else teams: @endif
                </div>
                @foreach($user->allTeams()->sortBy('name') as $t)
                    <div class="mr-2 my-2 inline-block">
                        <x-clear-link-button href="{{url('team/'.$t->id)}}">
                            {{$t->name}}
                        </x-clear-link-button>
                    </div>
                @endforeach
            </div>

            <div class="w-full text-center px-4 lg:px-8 my-6 mb-4 justify-center space-x-5">
                @if(isset($user->birthday))
                    <span class="tooltip" title="Birthday">
                        <i class="fa fa-birthday-cake text-pink-400 ml-3"></i>
                        <span class="italic text-sm text-gray-500">{{ $user->birthday->format('F jS') }}</span>
                    </span>

{{--                    <div class="italic text-sm text-gray-500 m-2">--}}
{{--                        <span class="tooltip" title="Birthday">--}}
{{--                            <i class="fa fa-birthday-cake text-pink-400 ml-3"></i> {{ $user->birthday->format('F jS') }}--}}
{{--                        </span>--}}
{{--                    </div>--}}
                @endif

                @if(isset($user->anniversary))
                    <span class="tooltip" title="Start Date">
                        <i class="fas fa-university text-gray-900"></i>
                        <span class="italic text-sm text-gray-500">{{ $user->anniversary->format('F jS, Y') }}</span>
                    </span>
                @endif

                @if(auth()->id() !== $user->id)
                    <a href="{{ route('kudos-show', ['user' => $user->id]) }}">
                        <i class="fa-solid fa-hands-clapping text-blue-500 tooltip" title="Give {{ getReplacedWordOfKudos() }}"></i>
                    </a>

                    <a href="{{ route('card.create', ['user' => $user->id]) }}">
                        <i class="fa fa-object-group text-red-500 tooltip" title="Send Group Card"></i>
                    </a>
                @endif
            </div>

            <div class="px-5 text-center">
                @if(Auth::user()->id != $user->id)
{{--                    <x-link-button href="/kudos/{{$user->id}}">--}}
{{--                        Prepare {{ getReplacedWordOfKudos() }} &amp; Proceed...--}}
{{--                    </x-link-button>--}}

                    @if($user->hasTeams())
                        @php $on_team = 0 @endphp

                        @foreach($user->teams as $t)
                            @if(Auth::user()->currentTeam && $t->id == Auth::user()->currentTeam->id)
                                @php $on_team = 1 @endphp
                            @endif
                        @endforeach
                    @endif
                @endif</div>

            <div class="text-gray-500 italic text-center w-full p-5 pb-8">
                <div class="flex justify-center">
                    <img class="h-5 mx-2" src="{{ appFavicon() }}"> {{$user->name}} joined {{ appName() }} in {{$user->created_at->format("F Y")}}
                </div>
            </div>

            @if(Auth::user()->id == $user->id)
                <div class="p-3 border-gray-300 text-center border-t">
                    <div class="italic text-sm text-gray-400">
                        Only you can see your current {{ getReplacedWordOfKudos() }}
                    </div>
                    {{--                    <div class="text-center mt-3">--}}
                    {{--                        {{ getReplacedWordOfKudos() }}: {{number_format($user->points)}} <br>--}}
                    {{--                        {{ getReplacedWordOfKudos() }} available to give away: {{number_format($user->points_to_give)}} <br>--}}
                    {{--                    </div>--}}
                </div>
            @endif
        </div>

    <!-- {{$user->email}} -->

        <!-- /// dashboard portion of the page -->

        <div class="grid grid-cols-1 md:grid-cols-1 lg:mx-60 sm:mx-10 p-5">
            @foreach($user->grab_associated_points()->take(200)->sortByDesc("created_at") as $point)
                @include('components.social-card',['point'=>$point])
            @endforeach
        </div>
    </div>

</x-app-layout>
