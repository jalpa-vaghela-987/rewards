<div class="p-5 md:p-8 bg-white my-0 md:my-10 border border-gray-300 rounded rounded-t-lg ">
    <div class="w-full text-left mt-5">
        <div class="md:flex">
            <div class="w-full md:w-1/3">
                <p class="text-xl mb-2 font-bold">Organize Teams</p>
                <p>Edit Company Team Structures</p>
            </div>

            <div class="w-full md:w-2/3 mt-3 md:mt-0">
                <div class="border shadow rounded-md md:ml-5 md:p-5">
                    <x-form-section submit="{{ route('developer.kudos') }}" shadow="no-shadow" class="mt-5" formClass="mx-4 md:mx-0">
                        <x-slot name="title"></x-slot>

                        <x-slot name="description">
                            <div class="">
                                Edit Company Team Structures
                            </div>
                        </x-slot>

                        <x-slot name="form">

                            <div class="lg:flex lg:space-x-10">
                                <div class="my-3">
                                    <x-jet-label for="title" value="{{ __('Select Company') }}"/>

                                    <input wire:model.debounce.500ms="company_search" type="search" id="searchbar"
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
{{--                                @if($company && $company_search)--}}
{{--                                <div class="lg:flex lg:space-x-10">--}}
{{--                                    <div class="lg:my-3 mt-5">--}}
{{--                                        <x-jet-label for="title" value="{{ __('Select User') }}"/>--}}

{{--                                        <input wire:model.debounce.500ms="recipient_search" type="search" id="searchbar"--}}
{{--                                               autocomplete="off" placeholder="Recipient..."--}}
{{--                                               class="focus:outline-none border-gray-200 p-1 mt-3" autofocus--}}
{{--                                               style="border-top:none; border-left: none; border-right: none;">--}}

{{--                                        <x-jet-input-error for="recipient" class="mt-2"/>--}}

{{--                                        <ul class="absolute z-50 bg-white shadow-md rounded-md text-gray-700 text-sm divide-y divide-gray-300 {{$is_recipient_showing}} mt-3" id="search_ul2" style="width: 300px;;">--}}
{{--                                            @foreach($recipients as $result)--}}
{{--                                                <li class="border border-gray-300">--}}
{{--                                                    <div wire:click.prevent="selectRecipient({{$result->id}})" class="flex items-center px-4 py-4 hover:bg-gray-200 transition ease-in-out duration-150 cursor-pointer">--}}
{{--                                                        <img src="{{$result->profile_photo_url}}" class="w-10 rounded-full">--}}

{{--                                                        <div class="ml-4 leading-tight overflow-hidden">--}}
{{--                                                            <div class="font-semibold">{{$result->name}}</div>--}}
{{--                                                            <div class="text-gray-600 truncate">{{$result->position}}</div>--}}
{{--                                                        </div>--}}
{{--                                                    </div>--}}
{{--                                                </li>--}}
{{--                                            @endforeach--}}
{{--                                        </ul>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                @endif--}}

                                @if($company && $company_search )
                                <div class="lg:flex lg:space-x-10">
                                    <div class="lg:my-3 mt-5">
                                        <x-jet-label for="title" value="{{ __('Select Team') }}"/>
                                        <input wire:model="team_search" type="hidden" id="searchbar">
                                        <select wore:model="team_search" id="searchbar">
                                        @forelse($teams as $result)
                                            <option wire:click.prevent="selectTEAm({{$result->id}})">{{$result->name}}</option>
                                            @empty
                                            <option>No Team Found</option>
                                            @endforelse
                                        </select>
{{--                                        <input wire:model.debounce.500ms="team_search" type="search" id="searchbar"--}}
{{--                                               autocomplete="off" placeholder="Team..."--}}
{{--                                               class="focus:outline-none border-gray-200 p-1 mt-3" autofocus--}}
{{--                                               style="border-top:none; border-left: none; border-right: none;">--}}

                                        <x-jet-input-error for="team" class="mt-2"/>

{{--                                        <ul class="absolute z-50 bg-white shadow-md rounded-md text-gray-700 text-sm divide-y divide-gray-300 {{$is_team_showing}} mt-3" id="search_ul3" style="width: 300px;;">--}}
{{--                                            @foreach($teams as $result)--}}
{{--                                                <li class="border border-gray-300">--}}
{{--                                                    <div wire:click.prevent="selectTeam({{$result->id}})" class="flex items-center px-4 py-4 hover:bg-gray-200 transition ease-in-out duration-150 cursor-pointer">--}}
{{--                                                        <img src="{{$result->profile_photo_url}}" class="w-10 rounded-full">--}}

{{--                                                        <div class="ml-4 leading-tight overflow-hidden">--}}
{{--                                                            <div class="font-semibold">{{$result->name}}</div>--}}
{{--                                                            <div class="text-gray-600 truncate">{{$result->position}}</div>--}}
{{--                                                        </div>--}}
{{--                                                    </div>--}}
{{--                                                </li>--}}
{{--                                            @endforeach--}}
{{--                                        </ul>--}}
                                    </div>
                                </div>
                                @endif

                        </x-slot>

                        <x-slot name="actions">
                            <x-jet-action-message class="mr-3 text-red-500" on="warning">
                                {{ __('Unable to delete team.') }}
                            </x-jet-action-message>

                            <x-jet-action-message class="mr-3 text-green-500" on="saved">
                                {{ __('Team Deleted Successfully.') }}
                            </x-jet-action-message>

                            <x-jet-danger-button class="ml-2 mr-2" wire:click="deleteTeam" wire:loading.attr="disabled">
                                {{ __('Delete Team') }}
                            </x-jet-danger-button>
                        </x-slot>
                    </x-form-section>
                </div>
            </div>
        </div>
    </div>
</div>
