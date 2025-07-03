<x-app-layout>

    <!-- Include stylesheet -->
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <!-- Include the Quill library -->
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/underscore@1.13.1/underscore-umd-min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.js" defer></script>

{{--    <div class="w-full text-right p-5">--}}
{{--        <x-link-button href="{{route('card.download', $card->token)}}" class="shadow bg-red-300">--}}
{{--            {{__('Download')}}--}}
{{--        </x-link-button>--}}
{{--    </div>--}}

    <div class="shadow-2xl card-main-background">
        <div class="h-24 text-gray-900 font-extrabold text-3xl mt-0 justify-center text-center rounded shadow-2xl flex align-middle flex-col w-full font-handwriting" style="background: {{$card->banner_color}}; ">
            {{$card->headline}}

        </div>
        <div class="flex pb-96 pt-12 w-full grid xs:grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3">
            <!-- // prior peoples entries -->
            @foreach($card->card_elements->where('active',1) as $ce)
                @if ($card->users()->wherePivot('active', 1)->wherePivot('user_id', $ce->user->id)->exists())
                    @include('cards.card_view_form')
                @endif
            @endforeach
        </div>
    </div>

    <style type="text/css">
        @media screen and (min-width: 1000px) {
            .card-main-background {
                background-image: url('{{$card->background_photo_path}}');
                /*background-size: cover;*/
                min-height: 600px;
                background-size: 105% auto;
                background-attachment: fixed;
            }
        }
        @media screen and (max-width: 1000px) and (min-width:500px) {
            .card-main-background{
                background-image: url('{{$card->background_photo_path}}');
                /*background-size: cover;*/
                max-width: 100%;
                height: auto;
                background-size: 761px 1016px;
                background-repeat: repeat-x;
                background-attachment: fixed;
            }
        }
        @media screen and (max-width: 500px) {
            .card-main-background{
                background-image: url('{{$card->background_photo_path}}');
                background-size: cover;
                /*max-width: 100%;*/
                height: 100%;
                /*background-size: 389px 843px;*/
                background-repeat:repeat-x;
                background-attachment: fixed;
            }
        }
    </style>

</x-app-layout>

