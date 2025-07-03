<div class="p-5 md:p-8 bg-white my-0 md:my-10 border border-gray-300 rounded rounded-t-lg ">
    <div class="w-full text-left mt-5">
        <div class="md:flex">
            <div class="w-full md:w-1/3">
                <p class="text-xl mb-2 font-bold">Send {{ getReplacedWordOfKudos() }} to Give Away!</p>
                <p>{{ appName() }} allows admin users to create custom rewards that can be redeemed internally! These custom rewards can include local partner gift cards, perks, travel, and gift cards from corporate credit card points.</p>
            </div>

            <div class="w-full md:w-2/3 mt-3 md:mt-0">
                <div class="border shadow rounded-md md:ml-5 md:p-5">
                    <x-jet-form-section submit="sendKudos" shadow="no-shadow">
                        <x-slot name="title">
                            @if($recipient)
                                Send {{ getReplacedWordOfKudos() }} to {{$recipient->name}}
                            @endif
                        </x-slot>

                        <x-slot name="description">
                            <div class="mt-4 md:mt-0">
                                {{ __('Sending '.getReplacedWordOfKudos().' to make the person feel appreciate and part of the team!') }}
                            </div>
                        </x-slot>

                        <x-slot name="form">
                            <div class="md:px-0 px-5">
                                <div class="lg:flex lg:space-x-10">
                                    <div class="my-3">
                                        <x-jet-label for="title" class="font-bold" value="{{ __('Select Company') }}"/>

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

                                    @if($company && $company_search)
                                        <div class="lg:my-3 mt-5">
                                            <x-jet-label for="title" class="font-bold" value="{{ __('Select User') }}"/>

                                            <input wire:model.debounce.500ms="recipient_search" type="search" id="searchbar"
                                                   autocomplete="off" placeholder="Recipient..."
                                                   class="focus:outline-none border-gray-200 p-1 mt-3" autofocus
                                                   style="border-top:none; border-left: none; border-right: none;">

                                            <x-jet-input-error for="recipient" class="mt-2"/>

                                            <ul class="absolute z-50 bg-white shadow-md rounded-md text-gray-700 text-sm divide-y divide-gray-300 {{$is_recipient_showing}} mt-3" id="search_ul2" style="width: 300px;;">
                                                @foreach($recipients as $result)
                                                    <li class="border border-gray-300">
                                                        <div wire:click.prevent="selectRecipient({{$result->id}})" class="flex items-center px-4 py-4 hover:bg-gray-200 transition ease-in-out duration-150 cursor-pointer">
                                                            <img src="{{$result->profile_photo_url}}" class="w-10 rounded-full">

                                                            <div class="ml-4 leading-tight overflow-hidden">
                                                                <div class="font-semibold">{{$result->name}}</div>
                                                                <div class="text-gray-600 truncate">{{$result->position}}</div>
                                                            </div>
                                                        </div>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                </div>

                                @if($recipient)
                                    <div class="col-span-6 sm:col-span-4">
                                        <div class="flex items-center px-4 py-4 {{--hover:bg-gray-200--}} transition ease-in-out duration-150 mb-5 lg:my-0 my-5 border border-gray-200 rounded ">
                                            <img src="{{$recipient->profile_photo_url}}" class="w-10 rounded-full">

                                            <div class="ml-4 leading-tight">
                                                <div class="font-semibold">{{$recipient->name}}</div>
                                                <div class="text-gray-600">{{$recipient->position}}</div>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <div class="col-span-6 sm:col-span-4 my-3">
                                    <x-jet-label for="amount" value="Number of {{ getReplacedWordOfKudos() }}"/>
                                    <x-jet-input id="amount" name="amount" wire:model.debounce.500ms="amount" type="number" min="100" max="100000" class="mt-1 block w-full"/>
                                    <x-jet-input-error for="amount" class="mt-2"/>
                                </div>
                            </div>
                        </x-slot>

                        <x-slot name="actions">
                            <x-jet-action-message class="mt-4 mr-3 text-green-500" on="saved">
                                {{ __(getReplacedWordOfKudos() . ' to give sent to user.') }}
                            </x-jet-action-message>

                            <x-jet-button class="mt-4 mr-0 md:-mr-5">
                                {{ __('Send ' . getReplacedWordOfKudos()) }}
                            </x-jet-button>
                        </x-slot>
                    </x-jet-form-section>
                </div>
            </div>
        </div>
    </div>
</div>
