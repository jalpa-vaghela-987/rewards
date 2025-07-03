<div class="mb-4 shadow bg-white rounded self-start">
    <div class="flex items-center md:text-center border-gray-200 py-4 px-4 lg:px-6 border-b-2 space-x-2 w-full ">
        <a href="{{ route('profile.user',['user' => $n->notifiable->id])}}" class="">
            <img src="{{ $n->notifiable->profile_photo_url }}" class="rounded-full hover:bg-gray-100 h-10 ">
        </a>

        <span class="px-2 md:px-2 mx-1 h-full">
                {{$n->data['tagline']}}
        </span>
    </div>

    <div class="p-3 flex flex-wrap justify-center bg-white">

        <div
            class="w-full lg:w-1/2 lg:border-r-2 lg:border-b-0 border-b-2 border-gray-200 p-4 free_form tracking-wide ">
            {{$n->data['tagline']}}
        </div>

        <div class="w-full lg:w-1/2">
            <div class="rounded rounded-t-lg overflow-hidden max-w-xs my-1 m-auto">

                <div class="text-center px-3 pb-2 pt-1">

                    <x-link-button href="{{$n->data['link']}}">
                        View!
                    </x-link-button>
                </div>
            </div>
        </div>
    </div>

    <div class="text-xs italic p-2 text-gray-800 border-t-2 border-gray-100 ">
        {{$n->created_at->diffForHumans()}}
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
