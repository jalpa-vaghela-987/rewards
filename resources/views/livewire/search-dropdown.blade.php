<div class="flex items-center -mr-8 sm:mr-0" style="margin-left: 10px; margin-top: 2px;">

    <!-- Button -->
    <div class="inline-flex rounded-md">
        <button type="button"
                class="inline-flex items-center h-10 px-3 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none transition duration-150 ease-in-out"
                id="search_glass">
            <span class="mdl-badge material-icons count_icon" id="search_icon">search</span>
        </button>
    </div>

    <!-- // Search bar -->
    <input wire:model.debounce.500ms="search"
           type="search"
           id="searchbar"
           autocomplete="off"
           placeholder="Search..."
           class="focus:outline-none border-gray-200 p-1 py-2 w-2/4 sm:w-3/4 sm:mr-0"
           style="border-top:none; border-left: none; border-right: none; border-bottom: 2px solid #d1d5da; padding-bottom: 5px">

    <ul class="absolute z-50 bg-white shadow-md rounded-md text-gray-700 text-sm divide-y divide-gray-300 search-list"
        id="search_ul" style="width: 300px; top: 50px;">
        @if(count($searchResults)<15 || $search != "")
            @foreach(collect($searchResults)->slice(0, 10) as $result)
                <li class="border  border-gray-300">
                    <a href="{{url('profile/'.$result->id)}}"
                       class="flex items-center px-4 py-4 hover:bg-gray-200 transition ease-in-out duration-150">
                        <img src="{{$result->profile_photo_url}}" class="w-10 rounded-full">
                        <div class="ml-4 leading-tight">
                            <div class="font-semibold">{{$result->name}}</div>
                            <div class="text-gray-600">{{$result->position}}</div>
                        </div>
                    </a>
                </li>
            @endforeach
        @endif
    </ul>
</div>
