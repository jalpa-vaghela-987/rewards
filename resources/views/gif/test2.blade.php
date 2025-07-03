<x-app-layout>
    <livewire:gif-keyboard/>


    <script type="text/javascript">

        $('#gif_scroll').on('scroll', function (e) {

            var scrollY = $(this).prop('scrollHeight') - $(this).prop('scrollTop');
            var height = $(this).prop('offsetHeight');
            var offset = height - scrollY;

            if (offset > -50) {
                // load more content here
                window.livewire.emit('load-more');
                //console.log('here');
            }

        });


        window.addEventListener('gif-hide', event => {
            $('#photos').hide();
            setTimeout(function () {
                $('#photos').show();
            }, 1500);
        });


    </script>


    <style type="text/css">

        #photos {
            /* Prevent vertical gaps */
            line-height: 0;
            background: black;
            -webkit-column-count: 5;
            -webkit-column-gap: 0px;
            -moz-column-count: 5;
            -moz-column-gap: 0px;
            column-count: 5;
            column-gap: 0px;
        }

        #photos img {
            /* Just in case there are inline attributes */
            width: 100% !important;
            height: auto !important;
        }

        @media (max-width: 1200px) {
            #photos {
                -moz-column-count: 4;
                -webkit-column-count: 4;
                column-count: 4;
            }
        }

        @media (max-width: 1000px) {
            #photos {
                -moz-column-count: 3;
                -webkit-column-count: 3;
                column-count: 3;
            }
        }

        @media (max-width: 800px) {
            #photos {
                -moz-column-count: 2;
                -webkit-column-count: 2;
                column-count: 2;
            }
        }

        @media (max-width: 400px) {
            #photos {
                -moz-column-count: 1;
                -webkit-column-count: 1;
                column-count: 1;
            }
        }

    </style>


</x-app-layout>






