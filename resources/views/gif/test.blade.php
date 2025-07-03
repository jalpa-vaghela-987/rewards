<x-app-layout>
    <div class="overflow-y-scroll w-full text-center m-auto shadow my-10 h-64" style="width: 465px;">
        <div class="bg-black gif-keyboard overflow-x-hidden">
            @foreach($gifs as $g)
                <div class="gif-item cursor-pointer"><img src="{{ htmlentities($g) }}" class="w-28 gif-image"></div>
            @endforeach
        </div>
    </div>
    <script type="text/javascript">
        $('.gif-keyboard').masonry({
            // options...
            itemSelector: '.gif-item',
            //columnWidth: 25
            columnWidth: 112
        });

        $('.gif-image').mouseenter(function (e) {
            $(this).addClass("border-blue-300 border-2");
            //$(this).removeClass("w-28");
        }).mouseleave(function (e) {
            //$(this).addClass("w-28");
            $(this).removeClass("border-blue-300 border-2");
        });
    </script>
</x-app-layout>






