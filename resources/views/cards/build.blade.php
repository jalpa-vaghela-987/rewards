<x-app-layout>

    <!-- Include stylesheet -->
{{--<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">--}}
<!-- Include the Quill library -->
    {{--<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>--}}

    <link href="https://vjs.zencdn.net/7.15.4/video-js.css" rel="stylesheet" />

    <!-- If you'd like to support IE8 (for Video.js versions prior to v7) -->
    <!-- <script src="https://vjs.zencdn.net/ie8/1.1.2/videojs-ie8.min.js"></script> -->

    <link rel="stylesheet" type="text/css" href="/quill/quill-emoji.css">
    <script src="/quill/quill-emoji.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/underscore@1.13.1/underscore-umd-min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.js" defer></script>

    <livewire:build-card :card="$card"/>

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
                background-size: 929px 870px;
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

    <style type="text/css">

        #photos {
            /* Pr czevent vertical gaps */
            line-height: 0;
            background: black;
            -webkit-column-count: 3;
            -webkit-column-gap:   0px;
            -moz-column-count:    3;
            -moz-column-gap:      0px;
            column-count:         3;
            column-gap:           0px;
        }

        #photos img {
            /* Just in case there are inline attributes */
            width: 100% !important;
            height: auto !important;
        }

        @media (max-width: 1200px) {
            #photos {
                -moz-column-count:    3;
                -webkit-column-count: 3;
                column-count:         3;
            }
        }
        @media (max-width: 1000px) {
            #photos {
                -moz-column-count:    2;
                -webkit-column-count: 2;
                column-count:         2;
            }
        }
        @media (max-width: 800px) {
            #photos {
                -moz-column-count:    2;
                -webkit-column-count: 2;
                column-count:         2;
            }
        }
        @media (max-width: 400px) {
            #photos {
                -moz-column-count:    1;
                -webkit-column-count: 1;
                column-count:         1;
            }
        }

    </style>


    <script src="https://vjs.zencdn.net/7.15.4/video.min.js"></script>

    <script type="text/javascript">

        $('#gif_scroll').on('scroll',function(e){

            var scrollY = $(this).prop('scrollHeight') - $(this).prop('scrollTop');
            var height = $(this).prop('offsetHeight');
            var offset = height - scrollY;

            if (offset > -10) {
                // load more content here
                window.livewire.emit('load-more');
                //console.log('here');
            }

        });


        window.addEventListener('gif-hide', event => {
            $('#photos').hide();
            setTimeout(function(){
                $('#photos').show();
            },1500);
        });


    </script>


</x-app-layout>
