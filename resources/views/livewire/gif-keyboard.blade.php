<div>
    <div class="bg-white shadow rounded p-4 m-auto w-2/3 text-center">
        <div class="overflow-y-scroll w-full text-centershadow h-64 m-auto" id="gif_scroll" style="width: 465px;">

            <div class="" id="photos" wire:model="photos">
                @foreach($this->gifs as $g)
                    <img src="{{ htmlentities($g) }}"
                         class="w-28 gif-image cursor-pointer border-black hover:border-blue-300 border-2 border-solid">
                @endforeach

            </div>

        </div>
        <input wire:model.debounce.1000ms="search" type="search" id="searchbar_gif" autocomplete="off"
               placeholder="Search for the perfect Gif..."
               class="focus:outline-none border-gray-200 p-1 -mt-5 m-auto w-2/3 rounded" autofocus
               style="border-top:none; border-left: none; border-right: none; height: 30px;"/>

    </div>

    <script type="text/javascript">

    </script>
</div>
