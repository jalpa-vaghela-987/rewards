<x-app-layout>
    <div class="container mx-auto px-4 py-10 md:py-12">
        <div class="flex flex-wrap justify-center">
            <div class="w-full md:w-1/2 lg:w-1/3">
                <x-jet-section-title>
                    <x-slot name="title">
                        {{ __(appName().' Connect') }}
                    </x-slot>

                    <x-slot name="description">
                        {{ __('Finding the time to engage with coworkers can be challenging. '. appName() .' can help. With our opt-in seamless one-on-one scheduling system, employees will have the opportunity to grow existing connections and facilitate new ones. Users will get rewarded too!') }}

                        <div class="my-5">
                            @if(Auth::user()->meetingConfig)
                                <x-link-button href="{{route('connect.register')}}">
                                    Modify Specifications
                                </x-link-button>
                                 @if(Auth::user()->meetingConfig->active)
                                    <div class="italic">You are currently opted-in</div>
                                @else
                                    <div class="italic">You are currently opted-out</div>
                                @endif
                            @else
                                <x-link-button href="{{route('connect.register')}}">
                                    Register for {{ appName() }} Connect!
                                </x-link-button>
                            @endif
                        </div>
                    </x-slot>
                </x-jet-section-title>
             </div>

            @if(Auth::user()->meetingConfig)
                <div class="w-full md:w-1/2 lg:w-2/3 pl-8">

                    <x-jet-section-title class="">
                        <x-slot name="title">
                            <span class="text-blue-800">{{ __('Upcoming One-on-Ones') }}</span>
                        </x-slot>
                        <x-slot name="description">
                            <div class="flex w-full mt-1 w-full grid grid-cols-2">
                                @forelse(Auth::user()->meetings()->sortBy('start') as $m)
                                    @php $u = $m->get_other_user() @endphp
                                    <div class="bg-white px-3 py-2 mx-2 my-5 shadow rounded border border-gray-300">
                                        <div class="w-full border-b border-gray-500 font-semibold">
                                            One-on-One with {{$u->name}}
                                        </div>
                                        <div class="my-1 py-1">
                                            <a href="{{ route('profile.user',['user' => $u->id])}}"
                                               class="flex justify-center">
                                                <img src="{{ $u->profile_photo_url }}"
                                                     class="rounded-full -mt-1 hover:bg-gray-100 h-16">
                                            </a>
                                            <div class="text-center px-3 pb-2 pt-2">
                                                <a class="text-black text-xls bold font-sans hover:bg-gray-100 p-2"
                                                   href="{{ route('profile.user',['user' => $u->id])}}">
                                                    {{ $u->name }}
                                                </a>
                                                <p class="mt-2 text-sm font-sans font-light text-grey-dark italic">
                                                    {{$u->position}}
                                                </p>
                                            </div>
                                        </div>
                                        <div class="italic text-sm w-full text-center">
                                            {{\Carbon\Carbon::parse($m->start)->format('g:i A \o\n l, F jS, Y')}}
                                        </div>
                                        <div class="w-full mt-2 text-left border-t border-gray-500 pt-2">
                                            @if($m->zoom_link)
                                                <x-clear-link-button class="bg-blue-200 hover:bg-blue-100"
                                                                     href="{{$m->zoom_link}}" target="_blank">
                                                    Join Zoom
                                                </x-clear-link-button>
                                        @endif
                                        <!-- <x-clear-link-button class="bg-yellow-200 hover:bg-yellow-100"> Reschedule </x-clear-link-button>
                                                <x-clear-link-button class="bg-red-200 hover:bg-red-100"> Cancel </x-clear-link-button> -->
                                        </div>
                                    </div>
                                @empty
                                    <p class="text-gray-500 text-sm">{{__('No Upcoming Meetings')}}</p>
                                @endforelse
                            </div>
                        </x-slot>
                    </x-jet-section-title>

                    <x-jet-section-title class="bg-white mt-5">
                        <x-slot name="title">
                            <span class="text-blue-800">{{ __('Completed One-on-Ones') }}</span>
                        </x-slot>

                        <x-slot name="description">
                            <div class="flex w-full mt-1 p-2 w-full grid grid-cols-2">
                                @forelse(Auth::user()->meetings()->where('start','<',\Carbon\Carbon::now()->format("Y-m-d"))->sortBy('start') as $m)
                                    @php $u = $m->get_other_user() @endphp
                                    <div class="bg-white px-3 py-2 mx-2 my-5 shadow rounded border border-gray-300">
                                        <div class="w-full border-b border-gray-500 font-semibold">
                                            One-on-One with {{$u->name}}
                                        </div>

                                        <div class="my-1 py-1">
                                            <a href="{{ route('profile.user',['user' => $u->id])}}"
                                               class="flex justify-center">
                                                <img src="{{ $u->profile_photo_url }}"
                                                     class="rounded-full -mt-1 hover:bg-gray-100 h-16">
                                            </a>
                                            <div class="text-center px-3 pb-2 pt-2">
                                                <a class="text-black text-xls bold font-sans hover:bg-gray-100 p-2"
                                                   href="{{ route('profile.user',['user' => $u->id])}}">
                                                    {{ $u->name }}
                                                </a>

                                                <p class="mt-2 text-sm font-sans font-light text-grey-dark italic">
                                                    {{$u->position}}
                                                </p>
                                            </div>
                                        </div>
                                        <div class="italic text-sm w-full text-center">
                                            {{\Carbon\Carbon::parse($m->start)->format('g:i A \o\n l, F jS, Y')}}
                                        </div>
                                    </div>
                                @empty
                                    <p class="text-gray-500 text-sm">{{__('No Completed Meetings')}}</p>
                                @endforelse
                            </div>
                        </x-slot>
                    </x-jet-section-title>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
