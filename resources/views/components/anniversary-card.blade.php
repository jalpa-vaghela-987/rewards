@if(isset($user->anniversary))
<div class="mb-4 shadow bg-white rounded">
    <div class="flex items-center md:text-center border-gray-200 py-4 px-4 lg:px-6 border-b-2 space-x-2 w-full">
        {{--        @if($point->giver)--}}
        <a href="{{ route('profile.user',['user' => $user->id])}}" class="">
            <img src="{{ $user->profile_photo_url }}" class="rounded-full hover:bg-gray-100 h-10 "
                 onerror="this.style.display='none'">
        </a>

        <span class="px-2 md:px-2 mx-1 h-full">
                {{ $user->name}}
        </span>

    </div>

    <div class="p-3 flex flex-wrap justify-center bg-white">

            <div class="w-full lg:w-1/2 lg:border-r-2 lg:border-b-0 border-b-2 border-gray-200 p-4 free_form font-handwriting tracking-wide text-lg break-words">
                Work Anniversary "{{ $user->anniversary->format('F jS ,Y') }}"
            </div>
        <div class="text-center">
            <div>
                <x-jet-button class="mt-3 ml-5 h-8"
                              wire:click.prevent="sendCard({{$user->id}})">
                    Send Card
                </x-jet-button>

                <x-secondary-link-button class="h-8 ml-5 opacity-80"
                                         wire:click.prevent="sendKudos({{$user->id}})">
                    Send {{ getReplacedWordOfKudos() }}
                </x-secondary-link-button>
            </div>
        </div>


        {{--        <div class="w-full lg:w-1/2">--}}
        {{--            <div class="rounded rounded-t-lg overflow-hidden max-w-xs my-1 m-auto">--}}
        {{--            <!-- <img src='{{ $point->reciever->background_photo_path }}' class="w-full" style="max-height: 120px; object-fit: cover;" /> -->--}}
        {{--                <a href="{{ route('profile.user',['user' => $point->reciever->id])}}" class="flex justify-center mt-8">--}}
        {{--                    <img src="{{ $point->reciever->profile_photo_url }}"--}}
        {{--                         class="rounded-full -mt-3 hover:bg-gray-100  h-16"--}}
        {{--                         onerror="this.style.display='none'">--}}
        {{--                </a>--}}

        {{--                <div class="text-center px-3 pb-2 pt-1">--}}
        {{--                    <a class="text-black text-xls bold font-sans hover:bg-gray-100 p-1"--}}
        {{--                       href="{{ route('profile.user',['user' => $point->reciever->id])}}">--}}
        {{--                        {{ $point->reciever->name }}--}}
        {{--                    </a>--}}

        {{--                    <p class="mt-2 text-sm font-sans font-light text-grey-dark italic">--}}
        {{--                        {{$point->reciever->position}}--}}
        {{--                    </p>--}}
        {{--                </div>--}}
        {{--            </div>--}}
        {{--        </div>--}}
    </div>

    {{--    <div class="flex justify-between text-xs p-2 text-gray-800 border-t-2 border-gray-100">--}}
    {{--        <div class="flex items-center italic">--}}
    {{--            {{$point->created_at->diffForHumans()}}--}}
    {{--        </div>--}}

    {{--        <div class="flex">--}}
    {{--            --}}{{--            @if($point->from_id == auth()->id() && isset($showEdit) && $showEdit)--}}
    {{--            <div class="my-auto mr-5">--}}
    {{--                <span class="cursor-pointer" wire:click="showEditKudosModal({{$point}})">--}}
    {{--                    <i class="fa fa-edit text-gray-500 text-sm"></i>--}}
    {{--                </span>--}}
    {{--            </div>--}}
    {{--            --}}{{--            @endif--}}

    {{--            @if(isset($showOptions) && $showOptions && showStandardKudosOptions($point))--}}
    {{--                <div>--}}
    {{--                    @if($point->hidden)--}}
    {{--                        <x-clear-link-button class="h-6" wire:click="$emit('showKudosModal', {{$point->id}})">--}}
    {{--                            Make Kudos Public--}}
    {{--                        </x-clear-link-button>--}}
    {{--                    @else--}}
    {{--                        <x-clear-link-button class="h-6" wire:click="$emit('hideKudosModal', {{$point->id}})">--}}
    {{--                            Make Kudos Private--}}
    {{--                        </x-clear-link-button>--}}
    {{--                    @endif--}}
    {{--                </div>--}}
    {{--            @endif--}}
    {{--        </div>--}}
    {{--    </div>--}}
</div>

<style type="text/css">
    .free_form > a {
        text-decoration: underline;
        color: blue;
    }

    .free_form > .ql-font-serif {
        font: sans-serif;
    }

    .free_form > ul {
        list-style: inside;
    }
</style>
@endif

