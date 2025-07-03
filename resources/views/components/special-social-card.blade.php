<div class="mb-4 shadow bg-white rounded">
    <div class="flex items-center md:text-center border-gray-200 py-4 px-4 lg:px-6 border-b-2 space-x-2 w-full @if($point->is_super) @else  @endif">
        @if($point->giver)
            <a href="{{ route('profile.user',['user' => $point->giver->id])}}" class="">
                <img src="{{ $point->giver->profile_photo_url }}" class="rounded-full hover:bg-gray-100 h-10 "
                onerror="this.style.display='none'">
            </a>
        @else
            <p>
                <img src="{{ appFavicon() }}" class="rounded-full hover:bg-gray-100 h-10 ">
            </p>
        @endif

        <span class="px-2 md:px-2 mx-1 h-full">
            Happy @lang('point.'.$point->type)
            <a href="{{ route('profile.user',['user' => $point->reciever->id])}}" class="hover:bg-gray-100 p-1 rounded"
                onerror="this.style.display='none'">
                 {{ $point->reciever->name }}
            </a>
        </span>
    </div>

    <div class="p-3 flex flex-wrap justify-center bg-white">
        <div
            class="w-full lg:w-1/2 lg:border-r-2 lg:border-b-0 border-b-2 border-gray-200 p-4 free_form font-handwriting tracking-wide text-lg  break-words">
            {!! html_entity_decode(htmlspecialchars_decode($point->message)) !!}
        </div>

        <div class="w-full lg:w-1/2">
            <div class="rounded rounded-t-lg overflow-hidden max-w-xs my-1 m-auto">
            <!-- <img src='{{ $point->reciever->background_photo_path }}' class="w-full" style="max-height: 120px; object-fit: cover;" /> -->
                <a href="{{ route('profile.user',['user' => $point->reciever->id])}}" class="flex justify-center mt-8">
                    <img src="{{ $point->reciever->profile_photo_url }}"
                         class="rounded-full -mt-3 hover:bg-gray-100  h-16"
                         onerror="this.style.display='none'">
                </a>

                <div class="text-center pb-2 pt-1">
                    <a class="text-black text-xls bold font-sans hover:bg-gray-100 p-1"
                       href="{{ route('profile.user',['user' => $point->reciever->id])}}">
                        {{ $point->reciever->name }}

                        <a href="mailto:{{ $point->reciever->email }}" class="tooltip" title="{{ $point->reciever->email }}">
                            <i class="text-sm fa fa-envelope text-indigo-400 hover:text-indigo-700"></i>
                        </a>
                    </a>

                    <p class="mt-2 text-sm font-sans font-light text-grey-dark italic">
                        {{$point->reciever->position}}
                    </p>
                </div>

                <div class="space-x-5 text-center items-center">
                    @if($point->reciever->birthday)
                        <span>
                            <i class="fa fa-birthday-cake text-pink-400 tooltip" title="Birthday: {{ $point->reciever->birthday->format('F jS') }}"></i>
                        </span>
                    @endif

                    @if($point->reciever->anniversary)
                        <span>
                            <i class="fas fa-university text-gray-900 tooltip" title="Start Date: {{ $point->reciever->anniversary->format('F jS, Y') }}"></i>
                        </span>
                    @endif

                    @if(auth()->id() !== $point->reciever->id)
                        <a href="{{ route('kudos-show', ['user' => $point->reciever->id]) }}">
                            <i class="fa-solid fa-hands-clapping text-blue-500 tooltip" title="Give {{ getReplacedWordOfKudos() }}"></i>
                        </a>

                        <a href="{{ route('card.create', ['user' => $point->reciever->id]) }}">
                            <i class="fa fa-object-group text-red-500 tooltip" title="Send Group Card"></i>
                        </a>
                    @endif
                </div>
            </div>

{{--            <div class="text-center">--}}
{{--                @if(isset($showOptions) && $showOptions && $point->isSpecial() && auth()->id() !== $point->reciever->id)--}}
{{--                    <div>--}}
{{--                        <x-jet-button class="h-6"--}}
{{--                                      wire:click.prevent="sendCard({{$point->reciever->id}})">--}}
{{--                            Send Card--}}
{{--                        </x-jet-button>--}}

{{--                        <x-secondary-link-button class="h-6 opacity-80"--}}
{{--                                                 wire:click.prevent="sendKudos({{$point->reciever->id}})">--}}
{{--                            Send {{ getReplacedWordOfKudos() }}--}}
{{--                        </x-secondary-link-button>--}}
{{--                    </div>--}}
{{--                @endif--}}
{{--            </div>--}}
        </div>
    </div>

    <div class="flex justify-between text-xs p-2 text-gray-800 border-t-2 border-gray-100  ">
        <div class="flex items-center italic">
            {{$point->created_at->diffForHumans()}}
        </div>

        @if(isset($showOptions) && $showOptions && showSpecialKudosOptions($point))
            <div>
                @if($point->hidden)
                    <x-clear-link-button class="h-6" wire:click="$emit('showKudosModal', {{$point->id}})">
                        Make {{ getReplacedWordOfKudos() }} Public
                    </x-clear-link-button>
                @else
                    <x-clear-link-button class="h-6" wire:click="$emit('hideKudosModal', {{$point->id}})">
                        Make {{ getReplacedWordOfKudos() }} Private
                    </x-clear-link-button>
                @endif
            </div>
        @endif
    </div>
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
