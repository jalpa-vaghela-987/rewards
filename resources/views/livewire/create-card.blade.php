<div>
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.js" defer></script>
    <x-jet-form-section submit="createCard">
        <div class="">
            <x-slot name="title">
                {{ __('Card Details') }}
            </x-slot>

            <x-slot name="description">
                {{ __('Create a card for an occasion, event, or just to show you are thinking of them!') }}<br><br>
                @if(Auth::user()->hasTeams())
                    {{ __('This card will be sent to everyone on '.Auth::user()->currentTeam->name. " and/or whoever you select to contribute.") }}
                @else
                    {{ __('This card will be sent to everyone you select to contribute.') }}
                @endif
            </x-slot>
        </div>

        <div class="pl-10">
            <x-slot name="form">
                <div class="col-span-6">
                    <x-jet-label value="{{ __('Card Creator') }}"/>

                    <div class="flex items-center mt-2">
                        <img class="w-12 h-12 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}"
                             alt="{{ Auth::user()->name }}">

                        <div class="ml-4 leading-tight">
                            <div>
                                @if($this->card)
                                    {{$this->card->creator->name}}
                                @else
                                    {{ Auth::user()->name }}
                                @endif

                            </div>
                            <div class="text-gray-700 text-sm">
                                @if(Auth::user()->hasTeams())

                                    {{ $this->card->creator->position ?? Auth::user()->position }}
                                @else
                                    No Team Selected
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
{{--                @if ($errors->any())--}}
{{--                    <div class="alert alert-danger">--}}
{{--                        <ul>--}}
{{--                            @foreach ($errors->all() as $error)--}}
{{--                                <li style="color: red">{{ $error }}</li>--}}
{{--                            @endforeach--}}
{{--                        </ul>--}}
{{--                    </div>--}}
{{--                @endif--}}

                <div class="col-span-12 sm:col-span-12">
                    <x-jet-label for="name" value="{{ __('Who is the recipient?') }}"/>
                    <div>
                        <div>
                            <div class="flex" style="">
                                <div class="relative flex w-full flex-wrap items-stretch mb-3 mt-3" style="" x-data="{
                                selectHoveredUser() {
                                    if ($('#search_user_list .selected .user_id').length) {
                                        $wire.selectRecipient($('#search_user_list .selected .user_id')[0].innerHTML);

                                        $('#user-searchbar').blur();
                                    }
                                }
                            }">

                                    <input wire:model.debounce.500ms="search"
                                           autocomplete="off"
                                           type="search"
                                           placeholder="Recipient..."
                                           id="user-searchbar"
                                           @keydown.enter.prevent="selectHoveredUser()"
                                           class="focus:outline-none border-gray-200 p-1 mt-6" autofocus
                                           style="border-top:none; border-left: none; border-right: none;">
                                </div>

                                <ul class="absolute z-50 bg-white shadow-md rounded-md text-gray-700 text-sm divide-y divide-gray-300 {{$this->is_showing ?? ''}}" id="search_user_list" style="width: 300px; margin-top: 45px;"
                                    x-data="{
                                    selectUser () {
                                        let liSelected;
                                        document.getElementById('user-searchbar').addEventListener('keydown', function(e) {
                                            switch (e.keyCode) {
                                                case 38:
                                                    if(liSelected) {
                                                        liSelected.removeClass('selected');
                                                        next = liSelected.prev();
                                                        if(next.length > 0) {
                                                            liSelected = next.addClass('selected');
                                                        } else {
                                                            liSelected = $('#search_user_list li').last().addClass('selected');
                                                        }
                                                    } else {
                                                        liSelected = $('#search_user_list li').last().addClass('selected');
                                                    }
                                                    break;

                                                case 40:
                                                    if(liSelected) {
                                                        liSelected.removeClass('selected');
                                                        next = liSelected.next();
                                                        if(next.length > 0) {
                                                            liSelected = next.addClass('selected');
                                                        } else {
                                                            liSelected = $('#search_user_list li').eq(0).addClass('selected');
                                                        }
                                                    } else {
                                                        liSelected = $('#search_user_list li').eq(0).addClass('selected');
                                                    }
                                                    break;
                                            }
                                        });
                                    },


                                }"
                                    x-init="selectUser"
                                >
                                    @if(count($searchResults) || $search != "")
                                        @foreach(collect($searchResults)->slice(0, 5) as $result)
                                            <li class="border border-gray-300" wire:model="removeLI">
                                                <div
                                                    wire:click="selectRecipient({{$result->id}})"
                                                    class="flex items-center px-4 py-4 hover:bg-gray-200 transition ease-in-out duration-150 cursor-pointer">
                                                    <img src="{{$result->profile_photo_url}}" class="w-10 rounded-full">
                                                    <div class="ml-4 leading-tight">
                                                        <div class="font-semibold">{{$result->name}}</div>
                                                        <div class="text-gray-600">{{$result->position}}</div>
                                                    </div>
                                                    <div class="user_id hidden">{{$result->id}}</div>
                                                </div>
                                            </li>
                                        @endforeach
                                    @endif
                                </ul>
                            </div>


                            <x-jet-input-error for="recipient" class="mt-2"/>

                            <div wire:model.debounce.500ms="search"></div>
                        </div>


                        <x-jet-input-error for="name" class="mt-2"/>
                    </div>

                    @if($this->recipient)
                        <div
                            class="flex items-center px-4 py-4 mt-3">
                            <img src="{{$this->recipient->profile_photo_url}}" class="w-10 rounded-full">
                            <div class="ml-4 leading-tight">
                                <div class="font-semibold">{{$this->recipient->name}}</div>
                                <div class="text-gray-600">{{$this->recipient->position}}</div>
                            </div>
                        </div>
                        <input type="hidden" name="recipient_id" value="{{$this->recipient->id}}">
                    @endif

                    <div class="col-span-6 sm:col-span-4 mt-5">
                        <x-jet-label for="headline" value="{{ __('What should be headline for the card?') }}"/>

                        <input
                            class='border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-3/4 sm:w-full'
                            id="headline" type="text" wire:model.debounce.500ms="headline" value=""
                            maxlength="100">
                        <x-jet-input-error for="headline" class="mt-2"/>
                    </div>

                    <div class="italic mt-5 mx-4">Select a Theme (These can always be customized and changed later!)
                        <br>
                        <span class="text-xs">Delete headline to show default templates.</span>
                    </div>
{{--                    <div id="loader">--}}
{{--                        <img src="{{URL::to('card_themes/loading.jpg')}}" alt="Loading">--}}
{{--                    </div>--}}
                    <div class="flex w-full mt-1 p-2 bg-white w-full grid grid-cols-1 sm:grid-cols-2 body_parts" wire:model="backgroundsDiv">
                          @php
                    $headlines = $backgrounds->map(function ($item, $key) {
                            return $item[1];
                        });

                    @endphp

                        @foreach($this->backgrounds as $bg)
                            <div class="h-48 text-center p-2 m-2  flex align-middle justify-center items-center font-bold hover:shadow-xl border-4 border-white hover:border-blue-300 rounded cursor-pointer card-picture
				                 @if($this->selectedBackground && $loop->index+1 == $this->selectedBackground) border-blue-300 shadow-xl @endif"
                                 style="background-image: url({{$bg[3]}});" wire:click="selectBackground({{$loop->index + 1}})">
                                <div class="bg-white p-3 shadow-xl rounded font-handwriting" style="background: {{$bg[2]}}; word-break: break-word">
                                    @if($this->headline)
                                        {{$this->headline}}
                                    @else
                                        {{$bg[1]}}
                                    @endif
                                </div>
                            </div>
                        @endforeach
                        <input type="hidden" name="background_image" value="{{$this->selectedBackground}}">

                        <x-jet-input-error for="selectedBackground" class="mt-2"/>
                    </div>



                    <div class="text-lg text-blue-700 mt-10 ">Advanced</div>

                    <div class="col-span-6 sm:col-span-4 mt-2">
                        <x-jet-label for="photo" value="{{ __('(Optional) Upload a background photo.') }}"/>

                        <div x-data="{photoName: null, photoPreview: null}" class="w-full rounded-t-xl">
                            <input type="file" class="hidden"
                                   wire:model="photo"
                                   accept="image/*"
                                   x-ref="photo"
                                   x-on:change="
                                    photoName = $refs.photo.files[0].name;
                                    const reader = new FileReader();
                                    reader.onload = (e) => {
                                        //photoPreview = e.target.result;
                                    };
                                    reader.readAsDataURL($refs.photo.files[0]);
                                    reader.onloadend = function () {
                                        //console.log($refs.photo);
                                       //Livewire.emit('photoUploaded');
                                       //console.log('uploaded');
                                      }
                            "/>

                            <div class="w-full mt-3">
                                <x-jet-secondary-button class="mx-2" type="button"
                                                        x-on:click.prevent="$refs.photo.click()">
                                    {{ __('Select Photo') }}
                                </x-jet-secondary-button>

                            </div>
                            <x-jet-input-error for="photo" class="mt-2"/>
                        </div>

                    </div>


                <!--                 <div class="col-span-6 sm:col-span-4 mt-2">
            <x-jet-label for="send_at" value="{{ __('(Optional) Should the card be sent automatically? Hour intervals only.') }}" />
            <x-jet-input id="send_at" type="datetime-local" class="mt-1 block w-full" wire:model.defer="send_at" step="3600" />
            <x-jet-input-error for="send_at" class="mt-2" />
        </div> -->

                    <div class="col-span-6 sm:col-span-4 mt-5">
                        <x-jet-label for="banner_color" value="{{ __('(Optional) Select banner background color.') }}"/>
                        <div class="flex">
                            <div class="mx-2 mt-5 align-bottom">Select color...</div>
                            <x-jet-input id="banner_color" type="color" class="mt-1 block w-20 h-10"
                                         wire:model="banner_color"/>
                        </div>
                        <x-jet-input-error for="banner_color" class="mt-2"/>
                    </div>

                </div>

            </x-slot>

            <x-slot name="actions">
                <x-jet-button>
                    {{ __('Save & Choose Recipients') }}
                </x-jet-button>
                @if($this->card)
                    <x-secondary-link-button class="mx-3" wire:click.prevent="viewCard">
                        View Card!
                    </x-secondary-link-button>
                @endif

            </x-slot>
        </div>

    </x-jet-form-section>
</div>
<script>
    var spinner = $('#loader');
    $(document).ready(function(){
        $('#loader').fadeOut(showBodyPart);
        function showBodyPart(){
            $('.body_parts').fadeIn(100);
        }
    })
</script>
