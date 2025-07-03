<div class="px-5 sm:px-0 w-full sm:w-2/3 ">
    <div class="bg-white p-0 pt-5 sm:p-5 m-0 sm:m-5 shadow rounded">
        <x-jet-section-title>
            <x-slot name="title">
                <div class="w-full text-center">
                    Group Card Recipient:
                    <span class="font-bold italic">
                        {{ $this->card->receiver->name }}
                    </span>
                </div>

                <span class="text-blue-800">{{ __('Contributors') }}</span>
            </x-slot>

            <x-slot name="description">
                <div class="w-full border-b border-gray-200">
                    Contributors:
                    <span class="font-bold italic" wire:model="peopleCount">
                        {{count($this->people)}}
                    </span>
                </div>
                 <div class="xs:display md:hidden lg:hidden italic">
                    Click on the name to remove from card
                </div>

                <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mt-5">
                    @foreach($this->people as $u)
                        @if($u->pivot->active)
                            @if($u->id != Auth::user()->id)
                                <x-clear-link-button class="hover:bg-red-500 hover:text-white"
                                                     onmouseover="$(this).find('span').show(0);"
                                                     onmouseout="$(this).find('span').hide(0);"
                                                     wire:click="removeUser({{$u->id}})">
                                    <div class="w-full h-auto lg:h-7"><span
                                            class="text-white hidden">Remove </span>{{$u->name}}</div>
                                </x-clear-link-button>
                            @else
                                <x-clear-link-button class="text-center">
                                    <div class="w-full h-7">{{$u->name}}</div>
                                </x-clear-link-button>
                            @endif
                        @endif
                    @endforeach
                </div>

                <div class="row ml-lg-5">
                    <div x-data="{clicked: false}" wire:ignore
                         class="inline-flex items-center tracking-widest transition ease-in-out duration-150 mr-2">
                        <div x-show="!clicked">
                            <x-secondary-link-button @click="clicked = !clicked" wire:click="addFullCompanyUsers"
                                                     class="mt-8">
                                Add Full Company
                            </x-secondary-link-button>
                        </div>
                        <div x-show="clicked">
                            <x-link-button @click="clicked = !clicked" wire:click="removeAllUsers" class="mt-8">
                                Remove Full Company
                            </x-link-button>
                        </div>
                    </div>
                </div>

                <div class="w-full border-b border-gray-200 mt-6"></div>

                <div class="row ml-lg-5">
                    @foreach(Auth::user()->company->teams()->get() as $t)
                        <div x-data="{clicked: false}" x-key="{{$t->id}}" wire:ignore
                             class="inline-flex items-center tracking-widest transition ease-in-out duration-150 mr-2">
                            <div x-show="!clicked">
                                <x-secondary-link-button @click="clicked = !clicked"
                                                         wire:click="addFullTeamUsers({{$t->id}})" class="mt-8">
                                    Add {{ $t->name }}
                                </x-secondary-link-button>
                            </div>
                            <div x-show="clicked">
                                <x-link-button @click="clicked = !clicked" wire:click="removeFullTeamUsers({{$t->id}})"
                                               class="mt-8">
                                    Remove {{ $t->name }}
                                </x-link-button>
                            </div>
                        </div>
                    @endforeach

                    {{--                    @if(!($this->people->count() === 1 && $this->people[0]->id === auth()->id()))--}}
                    {{--                        <div class="inline-flex items-center tracking-widest transition ease-in-out duration-150 mr-2">--}}
                    {{--                            <x-link-button wire:click="removeAllUsers" class="mt-8" >--}}
                    {{--                                Remove Other Users--}}

                    {{--                            </x-link-button>--}}
                    {{--                        </div>--}}
                    {{--                    @endif--}}
                </div>

                <div class="w-full border-b border-gray-200 mt-6"></div>

                <div class="mt-5 text-blue-800">
                    Add Individual Contributors
                </div>

                <div>
                    <div class="flex" style="">
                        <!-- // Search bar -->
                        <input wire:model.debounce.500ms="search" type="search" id="searchbar"
                               autocomplete="off" placeholder="Add Contributors..."
                               class="focus:outline-none border-gray-200 p-1 mt-6"
                               style="border-top:none; border-left: none; border-right: none;">

                        <ul class="absolute z-50 bg-white shadow-md rounded-md text-gray-700 text-sm divide-y divide-gray-300"
                            id="search_ul3"
                            style="width: 300px; margin-top: 58px;">
                            @if(count($searchResults)<15 || $search != "")
                                @foreach(collect($searchResults)->slice(0, 5) as $result)
                                    <li class="border border-gray-300" wire:model="removeLI">
                                        <div
                                            wire:click="addUser({{$result->id}})"
                                            class="flex items-center px-4 py-4 hover:bg-gray-200 transition ease-in-out duration-150 cursor-pointer">
                                            <img src="{{$result->profile_photo_url}}" class="w-10 rounded-full">
                                            <div class="ml-4 leading-tight">
                                                <div class="font-semibold">{{$result->name}}</div>
                                                <div class="text-gray-600">{{$result->position}}</div>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            @endif
                        </ul>
                    </div>

                    <div wire:model.debounce.500ms="search"></div>
                </div>
            </x-slot>
        </x-jet-section-title>
        <div class="w-full text-right p-5 sm:p-0">
            <x-link-button class="mt-7 object-right" href="{{url('card/notify/'.$this->card->id)}}">
                {{ __('Send Invites and Edit Card!') }}
            </x-link-button>
        </div>
    </div>
</div>

