<a class="h-48 text-center p-2 m-2  flex align-middle justify-center items-center font-bold hover:shadow-xl border-4 border-white hover:border-blue-300 rounded cursor-pointer card-picture hover:border-blue-300 hover:shadow-xl font-handwriting"
   href="{{$href}}"
   style="background-image: url({{$card->background_photo_path}});">
    <div class="text-black p-3 shadow-xl rounded text-lg card-picture-text" style="background:{{$card->banner_color}}">
        {{$card->headline}}
    </div>
</a>
