<div class="w-full sm:flex">
    <div class="sm:w-1/4 w-full text-left sm:text-left">
        <div class="sm:mt-7 sm:ml-5 ml-2 mt-2">
            <div class="ml-5">
                <x-jet-section-title>
                    <x-slot name="title"><span style="font-weight: 600;">View Recent Activity</span></x-slot>
                    <x-slot name="description">The {{ getReplacedWordOfKudos() }} Feed displays recent {{ getReplacedWordOfKudos() }} and much more!
                        <br><br>
                        <span class="italic">You have {{number_format(Auth::user()->points_to_give)}} {{ getReplacedWordOfKudos() }} available to give away.
                            <br><br> {{ getReplacedWordOfKudos() }} expire 30 days after you receive them so do not hesitate to send them out!</span>
                    </x-slot>
                </x-jet-section-title>
            </div>

            <div class="sm:mt-10"></div>
            <x-jet-section-title>
                <x-slot name="title">
                    <span class="ml-5 mt-6" style="font-weight: 600;">Limit to a Specific Team</span>

                </x-slot>

                <x-slot name="description">
                    <div class="grid grid-cols-1">
                        <button class='inline-flex items-center justify-center px-3 py-2 bg-blue-300 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 disabled:opacity-25 mx-auto mt-5 focus:outline-none
                                @if(!$current_team) bg-blue-500 @endif'
                                style="max-width: 230px; width: 100%;"
                                wire:click="teamButtonClick(null)">
                            All Teams
                        </button>

                        @foreach(Auth::user()->teams->sortBy('name') as $t)
                            <button class='inline-flex items-center justify-center px-3 py-2 bg-blue-300 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 disabled:opacity-25 mx-auto mt-5 focus:outline-none
        			                @if($current_team == $t->id) bg-blue-500 @endif'
                                    style="max-width: 230px; width: 100%;"
                                    wire:click="teamButtonClick({{ $t->id }})">
                                {{$t->name}}
                            </button>
                        @endforeach
{{--                        <button class='inline-flex items-center justify-center px-3 py-2 bg-blue-300 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 disabled:opacity-25 mx-auto mt-5 focus:outline-none--}}
{{--                                bg-blue-500'--}}
{{--                                style="max-width: 230px; width: 100%;" id="show_hide"--}}
{{--                                onclick="hideShow('birthday')">--}}
{{--                            Upcoming Birthday--}}
{{--                        </button>--}}
{{--                        <button class='inline-flex items-center justify-center px-3 py-2 bg-blue-300 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 disabled:opacity-25 mx-auto mt-5 focus:outline-none--}}
{{--                                bg-blue-500'--}}
{{--                                style="max-width: 230px; width: 100%;" id="show_hide"--}}
{{--                                onclick="showHide('anniversary')">--}}
{{--                            Upcoming Anniversary--}}
{{--                        </button>--}}
                    </div>
                </x-slot>
            </x-jet-section-title>

            <div class="mt-10"></div>

            <x-jet-section-title>
                <x-slot name="title"><span class="ml-5" style="font-weight: 600;">Send {{ getReplacedWordOfKudos() }}!</span></x-slot>
                <x-slot name="description">
                    <div class="italic text-xs ml-5"> You have {{number_format(Auth::user()->points_to_give)}} {{ getReplacedWordOfKudos() }} to give away.
                    </div>
                    <!--  Add people to kudos search -->
                    <div>
                        <div class="flex send-kudo-textbox ml-5" style="">
                            <!-- // Search bar -->
                            {{--            <input wire:model.debounce.500ms = "search" type="search" id="searchbar" autocomplete="off" placeholder="Recipient..." class="focus:outline-none rounded border text border-gray-400 mt-2"--}}
                            {{--            style="height: 40px;">--}}


                            <div class="relative flex w-full flex-wrap items-stretch mb-3 mt-3" style="" x-data="{
                                selectHoveredUser() {
                                    if ($('#search_user_list .selected .user_id').length) {
                                        $wire.selectRecipient($('#search_user_list .selected .user_id')[0].innerHTML);

                                        $('#user-searchbar').blur();
                                    }
                                }
                            }">
                                <span class="z-10 h-full leading-snug font-normal absolute text-center text-blueGray-300 absolute bg-transparent rounded text-base items-center justify-center w-8 pl-3 py-3">
                                    <i class="fas fa-search"></i>
                                </span>

                                <input wire:model.debounce.500ms="search"
                                       autocomplete="off"
                                       type="search"
                                       placeholder="Recipient..."
                                       id="user-searchbar"
                                       @keydown.enter.prevent="selectHoveredUser()"
                                       class="px-3 py-3 placeholder-blueGray-300 text-blueGray-600 relative bg-white bg-white rounded text-sm border-0 shadow outline-none focus:outline-none focus:ring w-full pl-10 focus:outline-none rounded border text border-gray-400"/>
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

                        @if($this->recipient)
                            <a href="/profile/{{$this->recipient->id}}"
                               class="flex items-center px-4 py-4 mt-3 bg-white shadow hover:bg-gray-50 rounded">
                                <img src="{{$this->recipient->profile_photo_url}}" class="w-10 rounded-full">
                                <div class="ml-4 leading-tight">
                                    <div class="font-semibold">{{$this->recipient->name}}</div>
                                    <div class="text-gray-600">{{$this->recipient->position}}</div>
                                </div>
                            </a>
                            <input type="hidden" name="recipient_id" value="{{$this->recipient->id}}">
                            <a class='inline-flex items-left px-3 py-2 bg-blue-300 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-pink-300 disabled:opacity-25 mt-5 focus:outline-none bg-pink-400'
                               href='/kudos/{{$this->recipient->id}}'>
                                Proceed!
                            </a>
                            <br>
                        @endif
                    </div>
                </x-slot>
            </x-jet-section-title>
        </div>
    </div>

    <div class="grid grid-cols-1 xl:mx-32 lg:mx-16 md:mx-4 sm:mx-5 p-5 sm:w-3/4 w-full mx-auto">
        <div class="mb-4">
            <div class="w-full mx-auto rounded">
                <!-- Tabs -->
                <ul id="tabs" class="inline-flex w-full px-1 pt-2 ">
                    <li class="px-4 py-1.5 font-semibold text-gray-800 border-b-4 opacity-50 @if($this->selectedTab === 'public') rounded-t -mb-px border-blue-500 opacity-100 @endif">
                        <a id="default-tab" href="#" wire:click="$set('selectedTab', 'public')">Public</a>
                    </li>
                    <li class="px-4 py-1.5 font-semibold text-gray-800 border-b-4 opacity-50 @if($this->selectedTab === 'private') rounded-t -mb-px border-blue-500 opacity-100 @endif">
                        <a id="private" href="#" wire:click="$set('selectedTab', 'private')">Private</a>
                    </li>
                </ul>

                <!-- Tab Contents -->
                <div id="tab-contents">
                    <div id="public" class="py-4 @if($this->selectedTab !== 'public') hidden @endif">
                        @livewire('show-kudos', ['show_options' => true])
                    </div>

                    <div id="private" class="py-4 @if($this->selectedTab !== 'private') hidden @endif">
                        @livewire('show-kudos', ['show_options' => true, 'type' => 'private'])
                    </div>
                </div>
            </div>
        </div>

        <x-jet-confirmation-modal wire:model="confirmingHideKudos">
            <x-slot name="title">
                Hide {{ getReplacedWordOfKudos() }}
            </x-slot>

            <x-slot name="content">
                Are you sure you want to hide this kudo for others? After this action, This kudo cannot be seen by others.
            </x-slot>

            <x-slot name="footer">
                <x-jet-secondary-button wire:click="$toggle('confirmingHideKudos')" wire:loading.attr="disabled">
                    Nevermind
                </x-jet-secondary-button>

                <x-jet-danger-button class="ml-2" wire:click="hideSelectedKudos()" wire:loading.attr="disabled">
                    Hide
                </x-jet-danger-button>
            </x-slot>
        </x-jet-confirmation-modal>

        <x-jet-confirmation-modal wire:model="confirmingShowKudos">
            <x-slot name="title">
                Show {{ getReplacedWordOfKudos() }}
            </x-slot>

            <x-slot name="content">
                Are you sure you want to make this kudo public for others? After this action, kudo can be seen by others.
            </x-slot>

            <x-slot name="footer">
                <x-jet-secondary-button wire:click="$toggle('confirmingShowKudos')" wire:loading.attr="disabled">
                    Nevermind
                </x-jet-secondary-button>

                <x-jet-danger-button class="ml-2" wire:click="makePublicSelectedKudo()" wire:loading.attr="disabled">
                    Make it Public
                </x-jet-danger-button>
            </x-slot>
        </x-jet-confirmation-modal>

        <x-tour-modal wire:model="ShowProductTour">
            <x-slot name="slot">
                 <div class="p-3 md:p-4 bg-pink-100 border-b-2 border-pink-200 border-solid">
                    <h2 class="w-full text-2xl font-semibold text-center font-handwriting">Welcome to the {{ appName() }}
                        {{ getReplacedWordOfKudos() }} Feed!</h2>
                </div>
                <div class="md:p-4 bg-white overflow-y-scroll" style="height: 32rem;">
                    <div class="p-2 m-1">
                       <div class="italic text-sm">
                           The {{ getReplacedWordOfKudos() }} Feed is where you will be able to view {{ getReplacedWordOfKudos() }} sent to different co-workers as well as birthdays & work anniversaries!
                       </div>
                       <h2 class="w-full text-xl font-semibold text-left font-handwriting mt-6">What are {{ getReplacedWordOfKudos() }}?</h2>
                        <div class="text-sm">
                            {{ appName() }} uses virtual rewards called “{{ getReplacedWordOfKudos() }}” to facilitate public recognition for excellent behavior. Employees receive a monthly allowance of Kudos to give out. (e.g. 1,000 Kudos worth $10) Once you receive Kudos, you can exchange them for real rewards!
                         </div>
                       <h2 class="w-full text-xl font-semibold text-left font-handwriting mt-6">View Public Recognition</h2>
                       <img class="w-full mt-3 shadow rounded" alt="{{ appName() }} Overview" src="/other/screenshots/kudos-feed-2.png"
                             data-src="/other/screenshots/kudos-feed-1.png">
                        <h2 class="w-full text-xl font-semibold text-left font-handwriting mt-6">Easily filter by team or send
                            {{ getReplacedWordOfKudos() }} directly</h2>
                        <div class="md:flex">
                            <div class="w-full  md:w-1/2 mt-3 p-2">
                             <img class="shadow rounded w-full m-auto" alt="{{ appName() }} Overview" src="/other/screenshots/team-filter.png">
                         </div>

                             <div class="w-full md:w-1/2 mt-3 p-2">
                             <img class="shadow rounded w-full m-auto " alt="{{ appName() }} Overview" src="/other/screenshots/send-kudos-2.png">
                             </div>
                        </div>
                         <h2 class="w-full text-xl font-semibold text-left font-handwriting mt-6">...or search for your coworker and send
                             {{ getReplacedWordOfKudos() }} from there!</h2>
                       <img class="w-full mt-3 shadow rounded" alt="{{ appName() }} Overview" src="/other/screenshots/profile-kudos.png"
                             data-src="/other/screenshots/profile-kudos.png">
                    </div>
                </div>
                 <div class="p-2 md:p-4 bg-blue-50 border-t-2 border-blue-100 border-solid">
                    <x-link-button wire:click="$set('ShowProductTour', false)">
                        Got it
                    </x-link-button>
                </div>
            </x-slot>
        </x-tour-modal>
    </div>

{{--    <div class="grid grid-cols-1 xl:mx-32 lg:mx-16 md:mx-4 sm:mx-5 p-5 sm:w-3/4 w-full mx-auto" style="display: none;"  id="birthday">--}}
{{--        <center><span style="font-size: 32px; font-style: italic;" >Upcoming Birthday</span></center>--}}
{{--        <div class="mb-4">--}}
{{--            <div class="w-full mx-auto rounded">--}}
{{--                <div class="mt-5">--}}
{{--                    @foreach($users as $user)--}}
{{--                        @include('components.birthday-card', ['user' => $user],['show_options' => true])--}}
{{--                    @endforeach--}}

{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}

{{--    <div class="grid grid-cols-1 xl:mx-32 lg:mx-16 md:mx-4 sm:mx-5 p-5 sm:w-3/4 w-full mx-auto" style="display: none;"  id="anniversary">--}}
{{--        <center><span style="font-size: 32px; font-style: italic;" >Upcoming Anniversary</span></center>--}}
{{--        <div class="mb-4">--}}
{{--            <div class="w-full mx-auto rounded">--}}
{{--                <div class="mt-5">--}}

{{--                    @foreach($users as $user)--}}
{{--                        @include('components.anniversary-card', ['user' => $user],['show_options' => true])--}}
{{--                    @endforeach--}}

{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}

    <script>
        function hideShow(id) {
            if (document.getElementById('show_hide').value == 'Hide Layer') {
                document.getElementById('show_hide').value = 'Show Layer';
            } else {
                document.getElementById('show_hide').value = 'Hide Layer';
                document.getElementById('team').style.display='none';
                document.getElementById('anniversary').style.display='none';
                document.getElementById(id).style.display = 'inline';
            }
        }
    </script>

    <script>
        function showHide(id) {
            if (document.getElementById('show_hide').value == 'Hide Layer') {
                document.getElementById('show_hide').value = 'Show Layer';
            } else {
                document.getElementById('show_hide').value = 'Hide Layer';
                document.getElementById('birthday').style.display='none';
                document.getElementById('team').style.display='none';
                document.getElementById(id).style.display = 'inline';
            }
        }
    </script>
</div>


