<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style type="text/css">
        @import url(https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,300;0,400;0,700;0,900;1,300;1,400;1,700;1,900&display=swap);
        @import url(https://fonts.googleapis.com/css2?family=Fira+Sans:ital,wght@0,500;0,600;0,700;0,800;0,900;1,500;1,600;1,700;1,800;1,900&display=swap);
        @import url(https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,300;0,400;0,700;0,900;1,300;1,400;1,700;1,900&display=swap);
        @import url(https://fonts.googleapis.com/css2?family=Fira+Sans:ital,wght@0,500;0,600;0,700;0,800;0,900;1,500;1,600;1,700;1,800;1,900&display=swap);
        @import url(https://fonts.googleapis.com/css2?family=Architects+Daughter&display=swap);
        @import url(https://fonts.googleapis.com/css2?family=Annie+Use+Your+Telescope&display=swap);
        @import url(https://fonts.googleapis.com/css2?family=Handlee&display=swap);
        @import url(https://fonts.googleapis.com/css2?family=Shadows+Into+Light&display=swap);
    </style>

    <title>{{ config('app.name', 'PerkSweet') }}</title>

    <!-- Include stylesheet -->
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <!-- Include the Quill library -->
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/underscore@1.13.1/underscore-umd-min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.js" defer></script>

    <style type="text/css">
        .card-main-background{
            background-image: url('{{$card->background_photo_path}}');
            /*background-size: cover;*/
            min-height: 600px;
            background-size: 100% auto;
            background-attachment: fixed;
        }

        @media screen and (max-width: 1000px) {
            .card-main-background{
                background-image: url('{{$card->background_photo_path}}');
                /*background-size: cover;*/
                min-height: 600px;
                background-size: auto 100%;
                background-attachment: fixed;
            }
        }
    </style>

    <!-- Fonts -->


    @livewireStyles

    <!-- Scripts -->
    @include('layouts.scripts')

</head>
<body class="font-sans antialiased">

<div class="min-h-screen h-full flex flex-col" style="background: rgba(239,246,255,.5);">
<!-- Page Content -->
    <main class="p-0 m-0 flex-grow">
        <div class="shadow-2xl card-main-background">
            <div class="h-24 text-gray-900 font-extrabold text-3xl mt-0 justify-center text-center rounded shadow-2xl flex align-middle flex-col w-full font-handwriting" style="background: {{$card->banner_color}}; ">
                {{$card->headline}}
            </div>

            <div class="flex pb-96 pt-12 w-full grid grid-cols-3">
                <!-- // prior peoples entries -->
                @foreach($card->card_elements()->where('active',1)->get() as $ce)
                    @include('cards.card_view_form')
                @endforeach
            </div>
        </div>
    </main>
</div>

@stack('modals')

@livewireScripts
@include("components.css")

</body>
</html>
