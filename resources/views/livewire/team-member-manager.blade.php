<div>
    @if (Gate::check('addTeamMember', $team))
        <x-jet-section-border/>

        <!-- Add Team Member -->
        <div class="mt-10 sm:mt-0">
            <x-jet-form-section submit="addTeamMember">
                <x-slot name="title">
                    {{ __('Invite Team Member') }}
                </x-slot>

                <x-slot name="description">
                    {{ __('Invite a new team member to your team, allowing them to collaborate with you.') }}
                </x-slot>

                <x-slot name="form">
                    <div class="col-span-6">
                        <div class="max-w-xl text-sm text-gray-600">
                            {{ __('Please search for the person you would like to add to this team.') }}
                        </div>
                    </div>

                    <!-- User Search -->
                    <div class="col-span-6 sm:col-span-4">
                        <x-jet-label for="search" value="{{ __('Search') }}"/>

                        <div class="flex" style="" x-data="{
                            selectHoveredUser() {
                                if ($('#search_user_list .selected .user_id').length) {
                                    $wire.addUser($('#search_user_list .selected .user_id')[0].innerHTML);

                                    $('#user-searchbar').blur();
                                }
                            }
                        }">
                            <!-- // Search bar -->
                            <input wire:model.debounce.500ms="search" type="search" id="user-searchbar"
                                   autocomplete="off"
                                   placeholder="Search for user..." class="focus:outline-none border-gray-200 p-1 mt-3"
                                   style="border-top:none; border-left: none; border-right: none;"
                                   @keydown.enter.prevent="selectHoveredUser()">

                            <ul class="absolute z-50 bg-white shadow-md rounded-md text-gray-700 text-sm divide-y divide-gray-300"
                                id="search_user_list" style="width: 300px; margin-top: 45px;"
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
                                x-init="selectUser">
                                @if(count($searchResults)<15 || $search !== "")
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
                                                <div class="user_id hidden">{{$result->id}}</div>
                                            </div>
                                        </li>
                                    @endforeach
                                @endif
                            </ul>
                        </div>
                        <x-jet-input-error for="recipient" class="mt-2"/>

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
                    </div>


                    <!-- Role -->
                    @if (count($this->roles) > 0)
                        <div class="col-span-6 lg:col-span-4">
                            <x-jet-label for="role" value="{{ __('Role') }}"/>
                            <x-jet-input-error for="role" class="mt-2"/>

                            <div class="relative z-0 mt-1 border border-gray-200 rounded-lg cursor-pointer">
                                @foreach ($this->roles as $index => $role)
                                    <button type="button"
                                            class="relative px-4 py-3 inline-flex w-full rounded-lg focus:z-10 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue {{ $index > 0 ? 'border-t border-gray-200 rounded-t-none' : '' }} {{ ! $loop->last ? 'rounded-b-none' : '' }}"
                                            wire:click="$set('addTeamMemberForm.role', '{{ $role->key }}')">
                                        <div
                                            class="{{ isset($addTeamMemberForm['role']) && $addTeamMemberForm['role'] !== $role->key ? 'opacity-50' : '' }}">
                                            <!-- Role Name -->
                                            <div class="flex items-center">
                                                <div
                                                    class="text-sm text-gray-600 {{ $addTeamMemberForm['role'] == $role->key ? 'font-semibold' : '' }}">
                                                    {{ $role->name }}
                                                </div>

                                                @if ($addTeamMemberForm['role'] == $role->key)
                                                    <svg class="ml-2 h-5 w-5 text-green-400" fill="none"
                                                         stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                         stroke="currentColor" viewBox="0 0 24 24">
                                                        <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                @endif
                                            </div>

                                            <!-- Role Description -->
                                            <div class="mt-2 text-xs text-gray-600 text-left">
                                                {{ $role->description }}
                                            </div>
                                        </div>
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </x-slot>

                <x-slot name="actions">
                    <x-jet-action-message class="mr-3 text-green-500" on="saved">
                        {{ __('Added.') }}
                    </x-jet-action-message>

                    <x-jet-button>
                        {{ __('Add') }}
                    </x-jet-button>
                </x-slot>

            </x-jet-form-section>
        </div>
    @endif

    @if ($team->users->isNotEmpty())
        @php
            $users = $team->users()->active()->orderBy('name')->get();
        @endphp
            <x-jet-section-border/>

            <div class="md:flex w-full mt-3 m-1 overflow-hidden mt-5 p-3 pl-1 ">
                <div class="flex w-full md:block md:w-1/5 m-2">
                    <div>

                        <div class="italic ml-2">
                            {{ __('Team Members') }}

                            <p class="text-base text-gray-600">{{count($users)}} Users</p>
                        </div>

                        <div class="italic ml-2">
                            Created on {{$team->created_at->format('F jS, Y') }}
                        </div>
                    </div>

                    <div>
                        <div class="font-semibold ml-2">
                            Team Administrator Users:
                        </div>

                        <div class="ml-2">
                            @foreach($team->users()->wherePivot('role', 'admin')->orderBy('name')->get() as $user)
                                <div>
                                    <a class="text-sm hover:bg-gray-100 p-1 text-blue-700"
                                       href="{{route('profile.user',['user' => $user->id])}}">
                                        {{$user->name}}
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="flex-1 sm:m-3 sm:ml-5 md:m-0 md:ml-8 p-3  bg-white shadow rounded border border-gray-200 overflow-hidden">
                    <div class="m-1 p-1 w-full border-b-2 border-gray-300 flex justify-between">
                        <div class="text-lg font-medium text-gray-900">
                            {{ __('Team Members') }}
                        </div>

                        @can('addTeamMember', $team)
                            <div>
                                <x-secondary-link-button class="mb-2 -mt-1 mr-2" wire:click="openAddTeamMemberModal({{$team->id}})">Add</x-secondary-link-button>
                            </div>
                        @endcan
                    </div>

                    <div style="max-height: 50vh; min-height: 25vh" class="p-2 overflow-y-auto overflow-x-hidden">
                        {{--                        <div class="grid w-3/4 overflow-y-scroll overflow-x-hidden w-1/4 gap-4 ">--}}
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-4 overflow-x-hidden w-full h-full gap-4">
                            @foreach($team->users()->orderBy('name')->get() as $u)
                                <div style="min-height: 10vh; max-height: 50vh; height: 100%" class="text-center relative" wire:key="{{ $u->id }}">
                                    <div class="w-full h-full rounded rounded-t-lg overflow-hidden bg-white border border-gray-300 px-1 py-4" style="min-width: 100px; ">
                                        @if(Gate::allows('addTeamMember', $team) || $u->id === auth()->id())
                                            <div class="absolute right-2 top-1.5" x-data="{ open: false }" @click.away="open = false" @close.stop="open = false">
                                                <div @click="open = ! open">
                                                <span class="inline-flex rounded-md text-gray-500 opacity-80 hover:opacity-100 cursor-pointer text-sm">
                                                    <i class="fa fa-ellipsis-v ml-2 -mr-0.5 h-4 w-4"></i>
                                                </span>
                                                </div>

                                                <div x-show="open"
                                                     x-transition:enter="transition ease-out duration-200"
                                                     x-transition:enter-start="transform opacity-0 scale-95"
                                                     x-transition:enter-end="transform opacity-100 scale-100"
                                                     x-transition:leave="transition ease-in duration-75"
                                                     x-transition:leave-start="transform opacity-100 scale-100"
                                                     x-transition:leave-end="transform opacity-0 scale-95"
                                                     class="absolute z-50 mt-2 w-36 rounded-md shadow-lg origin-top-right right-0"
                                                     @click="open = false" style="display: none;"
                                                >
                                                    <div class="rounded-md ring-1 ring-black ring-opacity-5 py-1 bg-white">
                                                        <div>
                                                            @can('updateTeamMember', $team)
                                                                <a class="border border-gray-100 cursor-pointer text-sm text-green-500 block px-2 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out truncate "
                                                                   style="border-top: none"
                                                                   wire:click="manageRole('{{ $u->id }}')">
                                                                    {{ __('Modify Permissions') }}
                                                                </a>
                                                            @endcan

                                                            @if ($this->user->id === $u->id)
                                                                <a class="cursor-pointer block px-2 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out truncate text-sm text-red-500"
                                                                   wire:click="$toggle('confirmingLeavingTeam')">
                                                                    {{ __('Leave') }}
                                                                </a>
                                                            <!-- Remove Team Member -->
                                                            @elseif (Gate::check('removeTeamMember', $team))
                                                                <a class="cursor-pointer block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out truncate text-sm text-red-500"
                                                                   wire:click="confirmTeamMemberRemoval('{{ $u->id }}')">
                                                                    {{ __('Remove') }}
                                                                </a>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif

                                        <a href="{{ route('profile.user',['user' => $u->id])}}"
                                           class="flex justify-center">
                                            <img src="{{ $u->profile_photo_url }}"
                                                 class="rounded-full hover:bg-gray-100 h-16">
                                        </a>

                                        <div class="text-center p-1 mt-1">
                                            <a class="text-black sm:text-xs xs:text-lg bold font-sans hover:bg-gray-100 p-1 lg:text-xs"
                                               href="{{ route('profile.user',['user' => $u->id])}}">
                                                {{ $u->name }}

                                                <a href="mailto:{{ $u->email }}" class="text-sm text-gray-500">
                                                    <i class="fa fa-envelope text-indigo-400 hover:text-indigo-700 tooltip" title="{{ $u->email }}"></i>
                                                </a>
                                            </a>

                                            <p class="mt-2 text-sm font-sans font-light text-grey-dark italic sm:text-xs">
                                                {{$u->position}}
                                            </p>

                                            <div class="space-x-5 mt-4 text-center items-center">
                                                @if($u->birthday)
                                                    <span>
                                                    <i class="fa fa-birthday-cake text-pink-400 tooltip" title="Birthday: {{ $u->birthday->format('F jS') }}"></i>
                                                </span>
                                                @endif

                                                @if($u->anniversary)
                                                    <span>
                                                        <i class="fas fa-university text-gray-900 tooltip" title="Start Date: {{ $u->anniversary->format('F jS, Y') }}"></i>
                                                    </span>
                                                @endif

                                                @if(auth()->id() !== $u->id)
                                                    <a href="{{ route('kudos-show', ['user' => $u->id]) }}">
                                                        <i class="fa-solid fa-hands-clapping text-blue-500 tooltip" title="Give {{ getReplacedWordOfKudos() }}"></i>
                                                    </a>

                                                    <a href="{{ route('card.create', ['user' => $u->id]) }}">
                                                        <i class="fa fa-object-group text-red-500 tooltip" title="Send Group Card"></i>
                                                    </a>
                                                @endif
                                            </div>
                                        </div>

                                        @if(auth()->check() && auth()->user()->role === 1)
                                            <div class="text-left text-sm mt-3 border-gray-200 border-t -my-2 p-2 text-gray-600">
                                                <div class="text-xs italic underline text-center mb-1">Company Admin Only</div>
                                                <p class="text-xs">{{ number_format($u->points) }} {{ getReplacedWordOfKudos() }} to Spend</p>
                                                <p class="text-xs mt-1">{{ number_format($u->points_to_give) }} {{ getReplacedWordOfKudos() }} available to give away</p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

{{--        <x-jet-section-border/>--}}


        <!-- Manage Team Members -->
{{--        <div class="mt-10 sm:mt-0">--}}
{{--            <x-jet-action-section>--}}
{{--                <x-slot name="title">--}}
{{--                    {{ __('Team Members') }}--}}
{{--                    <p class="text-base text-gray-600">{{count($users)}} Users</p>--}}
{{--                </x-slot>--}}

{{--                <x-slot name="description">--}}
{{--                    {{ __('All of the people that are part of this team.') }}--}}
{{--                </x-slot>--}}

{{--                <!-- Team Member List -->--}}
{{--                <x-slot name="content">--}}
{{--                    <div class="divide-y divide-gray-200">--}}
{{--                        @foreach ($users as $user)--}}
{{--                            <div class="flex sm:flex-row sm:items-center sm:justify-between py-4 justify-between">--}}
{{--                                <div class="flex items-center">--}}
{{--                                    <img class="w-8 h-8 rounded-full" src="{{ $user->profile_photo_url }}"--}}
{{--                                         alt="{{ $user->name }}">--}}
{{--                                    <a class="ml-4 text-black text-xls bold font-sans"--}}
{{--                                       href="{{ route('profile.user',['user' => $user->id])}}">{{ $user->name }}</a>--}}
{{--                                </div>--}}

{{--                                <div class="flex items-center">--}}
{{--                                    <!-- Manage Team Member Role -->--}}
{{--                                    @if (Gate::check('updateTeamMember', $team) && Laravel\Jetstream\Jetstream::hasRoles())--}}
{{--                                        <button class="ml-2 text-sm text-gray-400 underline"--}}
{{--                                                wire:click="manageRole('{{ $user->id }}')">--}}
{{--                                            {{ Laravel\Jetstream\Jetstream::findRole($user->membership->role)->name }}--}}
{{--                                        </button>--}}
{{--                                    @elseif (Laravel\Jetstream\Jetstream::hasRoles())--}}
{{--                                        <div class="ml-2 text-sm text-gray-400">--}}
{{--                                            {{ Laravel\Jetstream\Jetstream::findRole($user->membership->role)->name }}--}}
{{--                                        </div>--}}
{{--                                    @endif--}}

{{--                                <!-- Leave Team -->--}}
{{--                                    @if(count($users) > 1)--}}
{{--                                        @if ($this->user->id === $user->id)--}}
{{--                                            <button class="cursor-pointer ml-6 text-sm text-red-500"--}}
{{--                                                    wire:click="$toggle('confirmingLeavingTeam')">--}}
{{--                                                {{ __('Leave') }}--}}
{{--                                            </button>--}}
{{--                                            <!-- Remove Team Member -->--}}
{{--                                        @elseif (Gate::check('removeTeamMember', $team))--}}
{{--                                            <button class="cursor-pointer ml-6 text-sm text-red-500"--}}
{{--                                                    wire:click="confirmTeamMemberRemoval('{{ $user->id }}')">--}}
{{--                                                {{ __('Remove') }}--}}
{{--                                            </button>--}}
{{--                                        @endif--}}
{{--                                    @endif--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        @endforeach--}}
{{--                    </div>--}}
{{--                </x-slot>--}}
{{--            </x-jet-action-section>--}}
{{--        </div>--}}
@endif

<!-- Role Management Modal -->
    <x-jet-dialog-modal wire:model="currentlyManagingRole">
        <x-slot name="title">
            {{ __('Manage Role') }}
        </x-slot>

        <x-slot name="content">
            <div class="relative z-0 mt-1 border border-gray-200 rounded-lg cursor-pointer">
                @foreach ($this->roles as $index => $role)
                    <button type="button"
                            class="relative px-4 py-3 inline-flex w-full rounded-lg focus:z-10 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue {{ $index > 0 ? 'border-t border-gray-200 rounded-t-none' : '' }} {{ ! $loop->last ? 'rounded-b-none' : '' }}"
                            wire:click="$set('currentRole', '{{ $role->key }}')">
                        <div class="{{ $currentRole !== $role->key ? 'opacity-50' : '' }}">
                            <!-- Role Name -->
                            <div class="flex items-center">
                                <div
                                    class="text-sm text-gray-600 {{ $currentRole == $role->key ? 'font-semibold' : '' }}">
                                    {{ $role->name }}
                                </div>

                                @if ($currentRole == $role->key)
                                    <svg class="ml-2 h-5 w-5 text-green-400" fill="none" stroke-linecap="round"
                                         stroke-linejoin="round" stroke-width="2" stroke="currentColor"
                                         viewBox="0 0 24 24">
                                        <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                @endif
                            </div>

                            <!-- Role Description -->
                            <div class="mt-2 text-xs text-gray-600">
                                {{ $role->description }}
                            </div>
                        </div>
                    </button>
                @endforeach
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="stopManagingRole" wire:loading.attr="disabled">
                {{ __('Nevermind') }}
            </x-jet-secondary-button>

            <x-jet-button class="ml-2" wire:click="updateRole" wire:loading.attr="disabled">
                {{ __('Save') }}
            </x-jet-button>
        </x-slot>
    </x-jet-dialog-modal>

<!-- Leave Team Confirmation Modal -->
    <x-jet-confirmation-modal wire:model="confirmingLeavingTeam">
        <x-slot name="title">
            {{ __('Leave Team') }}
        </x-slot>

        <x-slot name="content">
            {{ __('Are you sure you would like to leave this team?') }}

            <x-jet-input-error for="team" class="mt-5"/>
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('confirmingLeavingTeam')" wire:loading.attr="disabled">
                {{ __('Nevermind') }}
            </x-jet-secondary-button>

            <x-jet-danger-button class="ml-2" wire:click="leaveTeam" wire:loading.attr="disabled">
                {{ __('Leave') }}
            </x-jet-danger-button>
        </x-slot>
    </x-jet-confirmation-modal>

    <!-- Remove Team Member Confirmation Modal -->
    <x-jet-confirmation-modal wire:model="confirmingTeamMemberRemoval">
        <x-slot name="title">
            {{ __('Remove Team Member') }}
        </x-slot>

        <x-slot name="content">
            {{ __('Are you sure you would like to remove this person from the team?') }}
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('confirmingTeamMemberRemoval')" wire:loading.attr="disabled">
                {{ __('Nevermind') }}
            </x-jet-secondary-button>

            <x-jet-danger-button class="ml-2" wire:click="removeTeamMember" wire:loading.attr="disabled">
                {{ __('Remove') }}
            </x-jet-danger-button>
        </x-slot>
    </x-jet-confirmation-modal>

    <x-jet-modal wire:model="showAddNewTeamMemberModal">
        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
            <div class="sm:flex sm:items-start">
                <livewire:add-team-member key="{{ now() }}" :team="$selectedTeam" />
            </div>
        </div>
    </x-jet-modal>

    <!--  Manage Permission  -->
    <x-jet-modal wire:model="showManagePermissionModal">
        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
            <div class="sm:flex sm:items-start">
                <livewire:add-team-member wire:key="{{ now() }}" :team="$selectedTeam" :user="$selectedUser" />
            </div>
        </div>
    </x-jet-modal>
</div>
