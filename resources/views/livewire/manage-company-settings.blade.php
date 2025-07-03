<div>
    <div class="p-5 md:p-8 bg-white my-0 md:my-10 border border-gray-300 rounded rounded-t-lg ">
        <div class="w-full text-left mt-5">
            <div class="md:flex">
                <div class="w-full md:w-1/3">
                    <p class="text-xl mb-2 font-bold">Manage Company Settings</p>
                </div>

                <div class="w-full md:w-2/3 mt-3 md:mt-0">
                    <div class="border shadow rounded-md md:ml-5 md:p-5">

                        <x-jet-label for="title" value="{{ __('Select Company') }}"/>

                        <input wire:model.debounce.500ms="company_search" type="search" id="searchbar" name="company"
                               autocomplete="off" placeholder="Company..."
                               class="focus:outline-none border-gray-200 p-1 mt-3" autofocus
                               style="border-top:none; border-left: none; border-right: none;">

                        <x-jet-input-error for="company" class="mt-2"/>

                        <ul class="absolute z-50 bg-white shadow-md rounded-md text-gray-700 text-sm divide-y divide-gray-300 {{$is_company_showing}} mt-3" id="search_ul2" style="width: 300px;;">
                            @foreach($companies as $result)
                                <li class="border border-gray-300">
                                    <div wire:click.prevent="selectCompany({{$result->id}})" class="flex items-center px-4 py-4 hover:bg-gray-200 transition ease-in-out duration-150 cursor-pointer">
                                        <img src="{{$result->logo_path}}" class="w-10 rounded-full">

                                        <div class="ml-4 leading-tight overflow-hidden">
                                            <div class="font-semibold">{{$result->name}}</div>
                                            <div class="text-gray-600 truncate">
                                                {{$result->description}}
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
