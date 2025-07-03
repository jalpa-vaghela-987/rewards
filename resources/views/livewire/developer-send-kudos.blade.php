<div class="p-5 md:p-8 bg-white my-0 md:my-10 border border-gray-300 rounded rounded-t-lg ">
    <div class="w-full text-left mt-5">
        <div class="md:flex">
            <div class="w-full md:w-1/3">
                <p class="text-xl mb-2 font-bold">Send {{ getReplacedWordOfKudos() }}!</p>
                <p>{{ appName() }} allows admin users to create custom rewards that can be redeemed internally! These custom rewards can include local parter gift cards, perks, travel, and gift cards from corporate credit card points.</p>
            </div>

            <div class="w-full md:w-2/3 mt-3 md:mt-0">
                <div class="border shadow rounded-md md:ml-5 md:p-5">
                    <x-form-section submit="{{route('developer.kudos')}}" shadow="no-shadow" class="mt-5" formClass="mx-4 md:mx-0">
                        <x-slot name="title">
                            @if($recipient)
                                Send {{ getReplacedWordOfKudos() }} to {{$recipient->name}}
                            @endif
                        </x-slot>

                        <x-slot name="description">
                            <div class="">
                                {{ __('Sending '.getReplacedWordOfKudos().' to make the person feel appreciate and part of the team!') }}
                            </div>
                        </x-slot>

                        <x-slot name="form">

                            <div class="lg:flex lg:space-x-10">
                                <div class="my-3">
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

                                @if($company && $company_search)
                                    <div class="lg:my-3 mt-5">
                                        <x-jet-label for="title" value="{{ __('Select User') }}"/>

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
                                <div class="flex items-center px-4 py-4 {{--hover:bg-gray-200--}} transition ease-in-out duration-150 mb-5 border border-gray-200 rounded ">
                                    <img src="{{$recipient->profile_photo_url}}" class="w-10 rounded-full">

                                    <div class="ml-4 leading-tight">
                                        <div class="font-semibold">{{$recipient->name}}</div>
                                        <div class="text-gray-600">{{$recipient->position}}</div>
                                    </div>
                                </div>
                            </div>
                            @endif

                            <input type="hidden" name="kudos_visibility" value="1">
                            @if($recipient)
                                <input type="hidden" name="user_id" value="{{$recipient->id}}">
                            @endif

                            <div class="col-span-6 sm:col-span-4">
                                <x-jet-label for="kudos_amount" value="{{ __('Number of '. getReplacedWordOfKudos()) }}"/>
                                <x-jet-input id="kudos_amount" name="kudos_amount" type="number" min="100" max="100000" class="mt-1 block w-full"/>
                                <x-jet-input-error for="kudos_amount" class="mt-2"/>
                            </div>

                            <div class="col-span-6 sm:col-span-4">
                                <label class="border-gray-200 rounded relative border p-4 flex cursor-pointer">
                                    <input type="radio" name="kudos_type" value="standard"
                                           class="h-4 w-4 mt-0.5 cursor-pointer text-indigo-600 border-gray-300 focus:ring-indigo-500"
                                           aria-labelledby="privacy-setting-0-label"
                                           aria-describedby="privacy-setting-0-description">
                                    <div class="ml-3 flex flex-col">
                                        <span id="privacy-setting-0-label" class="text-gray-900 block text-sm font-medium">
                                            Standard {{ getReplacedWordOfKudos() }}
                                            <span class="italic">
                                                (standard thank you, well done, or great job)
                                            </span>
                                        </span>
                                    </div>
                                </label>

                                <label class="border-gray-200 rounded relative border p-4 flex cursor-pointer">
                                    <input type="radio" name="kudos_type" value="super"
                                           class="h-4 w-4 mt-0.5 cursor-pointer text-indigo-600 border-gray-300 focus:ring-indigo-500"
                                           aria-labelledby="privacy-setting-1-label"
                                           aria-describedby="privacy-setting-1-description">

                                    <div class="ml-3 flex flex-col">
                                        <span id="privacy-setting-1-label" class="text-gray-900 block text-sm font-medium">
                                            Super {{ getReplacedWordOfKudos() }} <span class="italic">(for anything spectacular!)</span>
                                        </span>
                                    </div>
                                </label>

                                <x-jet-input-error for="kudos_type" class="mt-2"/>
                            </div>

                            <div class="col-span-6 sm:col-span-4">
                                <x-jet-label for="message" value="{{ __('Add a Short Message!') }}"/>

                                <x-text-area id="message" name="message" type="text" class="mt-1 block w-full hidden"
                                             autofocus/>

                                <div wire:ignore>
                                    <div class="card-element-text min-h-40">
                                        <div class="mt-2 bg-white min-h-40">
                                            <div id="quill-editor2" class="rounded min-h-40 free_form font-handwriting tracking-wide text-lg"
                                                 style="min-height: 150px;">
                                                {!!old('message')!!}
                                            </div>
                                        </div>
                                    </div>

                                    <script type="text/javascript">
                                        let toolbarOptions = {
                                            container: [
                                                ['bold', 'italic', 'underline', 'strike'],
                                                //['blockquote'],
                                                [{'list': 'bullet'}],
                                                //[{'indent': '-1'}, {'indent': '+1'}],
                                                [{'color': []}, {'background': []}],
                                                //[{'font': []}],
                                                // [{'align': []}],
                                                ['clean'],
                                                ['emoji'],
                                                ['link']
                                                //['link', 'image', 'video']
                                            ],
                                            handlers: {
                                                'emoji': function () {
                                                }
                                            }
                                        }

                                        let quill = new Quill('#quill-editor2', {
                                            modules: {
                                                "toolbar": toolbarOptions,
                                                "emoji-toolbar": true,
                                                "emoji-shortname": true,
                                                "emoji-textarea": true
                                            },
                                            placeholder: 'Write something amazing...',
                                            theme: 'snow',
                                        });

                                        quill.on('text-change', function () {
                                            $('#message').val(quill.root.innerHTML);
                                        });
                                    </script>
                                </div>

                                <x-jet-input-error for="message" class="mt-2"/>
                            </div>

                            {{--                            @if($recipient)--}}
                            {{--                                <input type="hidden" name="user_id" value="{{$recipient->id}}">--}}
                            {{--                            @endif--}}
                        </x-slot>

                        <x-slot name="actions">
                            <x-jet-button class="mr-2">
                                {{ __('Send '.getReplacedWordOfKudos()) }}
                            </x-jet-button>
                        </x-slot>
                    </x-form-section>
                </div>
            </div>
        </div>
    </div>
</div>
