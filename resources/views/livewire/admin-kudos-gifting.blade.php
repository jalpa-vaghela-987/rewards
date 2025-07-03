<div>
    <style>
        [x-cloak] { display: none; }
    </style>

    <x-form-section submit="{{route('admin.kudos-gifting')}}" shadow="no-shadow" formClass="mx-4 md:mx-0">
        <x-slot name="title"></x-slot>

        <x-slot name="description">
            <div class="w-full">
                <p class="text-xl mb-2 font-bold">Gifting {{ getReplacedWordOfKudos() }}!</p>
                <p>{{ appName() }} allows admin users to gift {{ getReplacedWordOfKudos() }} to other users in bulk by choosing the following options to select the group of users.</p>
                <p>Admin gifting will not reduce {{ getReplacedWordOfKudos() }} of the sender. This is intended for gifts and group awards from the company.</p>
            </div>
        </x-slot>

        <x-slot name="form">
            <div x-data="{showRecipientPortion: true, canClickNext: false}" x-cloak
                 x-init="
                     showRecipientPortion = {{(isset($errors) && count($errors)) ? 'false' : 'true'}}
                     canClickNext = {{(isset($errors) && count($errors)) ? 'true' : 'false'}}
                 "
                 class="bg-white p-5 m-0 shadow rounded"
            >
                <div x-show="showRecipientPortion">
                    <span class="text-blue-800">
                        {{ __('Recipients') }}
                        @if(count($selected_recipients))
                            ({{ count($selected_recipients) }})
                        @endif
                    </span>

                    <hr class="my-0.5 mb-5">

                    @if(count($selected_recipients))
                        <div class="w-full">
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-2 mt-2 max-h-72 overflow-y-auto overflow-x-hidden">
                                @foreach($selected_recipients as $id => $name)
                                    <x-clear-link-button class="hover:bg-red-500 hover:text-white"
                                                         onmouseover="$(this).find('span').show(0);"
                                                         onmouseout="$(this).find('span').hide(0);"
                                                         wire:click="removeUser({{$id}})">
                                        <div class="w-full h-auto lg:h-7">
                                            <span class="text-white hidden">Remove </span>{{$name}}
                                        </div>
                                    </x-clear-link-button>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <div class="w-full text-gray-400 h-32 flex items-center justify-center">
                            Please select recipients
                        </div>
                    @endif

                    <x-jet-input-error for="user_id" class="my-2"/>

                    <input type="hidden" name="kudos_visibility" value="1">
                    <input type="hidden" name="company" value="{{ auth()->user()->company->name }}">
                    @if(count($selected_recipients))
                        <input type="hidden" name="user_id" value="@json(array_keys($selected_recipients))">
                    @endif

                    <hr class="my-5">

                    <div x-data="{clicked: false}" wire:ignore
                         class="row inline-flex items-center tracking-widest transition ease-in-out duration-150">
                        <div x-show="!clicked" x-cloak>
                            <x-secondary-link-button @click="clicked = !clicked" wire:click="addFullCompanyUsers">
                                Add Full Company
                            </x-secondary-link-button>
                        </div>

                        <div x-show="clicked" x-cloak>
                            <x-link-button @click="clicked = !clicked" wire:click="removeAllUsers">
                                Remove Full Company
                            </x-link-button>
                        </div>
                    </div>

                    <hr class="mt-5 mb-3">

                    <div class="row space-y-2">
                        @foreach(auth()->user()->company->teams()->get() as $t)
                            <div x-data="{clicked: false}" x-key="{{$t->id}}" wire:ignore
                                 class="inline-flex items-center transition ease-in-out duration-150">
                                <div x-show="!clicked">
                                    <x-secondary-link-button @click="clicked = !clicked" wire:click="addFullTeamUsers({{$t->id}})">
                                        Add {{ $t->name }}
                                    </x-secondary-link-button>
                                </div>

                                <div x-show="clicked">
                                    <x-link-button @click="clicked = !clicked" wire:click="removeFullTeamUsers({{$t->id}})">
                                        Remove {{ $t->name }}
                                    </x-link-button>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <hr class="my-5">

                    <div class="row">
                        <div class="mt-5 text-blue-800">
                            Add Individual Recipients
                        </div>

                        <div class="flex" style="">
                            <input wire:model.debounce.500ms="search" type="search" id="searchbar"
                                   autocomplete="off" placeholder="Add Recipients..."
                                   class="focus:outline-none border-gray-200 p-1 mt-4"
                                   style="border-top:none; border-left: none; border-right: none;">

                            <ul class="absolute z-50 bg-white shadow-md rounded-md text-gray-700 text-sm divide-y divide-gray-300" style="width: 300px; margin-top: 58px;">
                                @foreach($searchResults as $user)
                                    <li class="border border-gray-300" wire:model="removeLI">
                                        <div wire:click="addUser({{$user}}, true)"
                                            class="flex items-center px-4 py-4 hover:bg-gray-200 transition ease-in-out duration-150 cursor-pointer">
                                            <img src="{{$user->profile_photo_url}}" class="w-10 rounded-full">

                                            <div class="ml-4 leading-tight">
                                                <div class="font-semibold">{{$user->name}}</div>
                                                <div class="text-gray-600">{{$user->position}}</div>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        <div wire:model.debounce.500ms="search"></div>
                    </div>

                    <hr class="my-5">
                </div>

                <div x-show="!showRecipientPortion" class="space-y-4">
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

                        <x-text-area id="message" name="message" type="text" class="mt-1 block w-full hidden" autofocus/>

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
                                $( document ).ready(function() {
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
                                        $("#message").val(quill.root.innerHTML)
                                    });
                                });
                            </script>
                        </div>

                        <x-jet-input-error for="message" class="mt-2"/>
                    </div>
                </div>

                <div class="w-full flex justify-end space-x-2 mt-8">
                    <x-secondary-link-button
                        wire:click.prevent=""
                        x-show="!showRecipientPortion"
                        @click="showRecipientPortion = true">
                        Back
                    </x-secondary-link-button>

                    <x-jet-button class="mr-2" x-show="!showRecipientPortion">
                        Submit
                    </x-jet-button>

                    @if(!count($selected_recipients))
                        <div class="wrapper">
                            <x-secondary-link-button
                                disabled="true"
                                class="cursor-not-allowed"
                                wire:click.prevent=""
                                x-show="showRecipientPortion"
                                @click="showRecipientPortion = false">
                                Next
                            </x-secondary-link-button>

                            <div class="tooltip-text ml-4">
                                Select Recipient
                            </div>
                        </div>
                    @else
                        <x-secondary-link-button
                            wire:click.prevent=""
                            x-show="showRecipientPortion"
                            @click="showRecipientPortion = false">
                            Next
                        </x-secondary-link-button>
                    @endif
                </div>
            </div>
        </x-slot>
    </x-form-section>
</div>
