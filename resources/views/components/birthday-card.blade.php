@if(isset($user->birthday))

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
            Birthday  on {{ $user->birthday->format('jS F') }}
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

    </div>

</div>
    @endif

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
