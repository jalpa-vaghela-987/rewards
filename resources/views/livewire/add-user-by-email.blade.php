<div>
{{--    <x-jet-section-border/>--}}

<!-- Add Team Member -->
    <div class="mt-10 sm:mt-0">
        <x-jet-form-section submit="{{ $invitation ? 'updateInvitation' : 'addNewUser' }}">
            @if(!$invitation)
                <x-slot name="title">
                    {{ __('Invite New User') }}
                </x-slot>

                <x-slot name="description">
                    {{ __('Invite a new user to join '. appName() .', allowing them access to the full platform.') }}
                </x-slot>
            @else
                <x-slot name="title">
                    {{ __('Edit Invitation') }}
                </x-slot>

                <x-slot name="description">
                    {{ __('Invite a new user to join '. appName() .', allowing them access to the full platform.') }}
                </x-slot>
            @endif

            <x-slot name="form">
                <div class="col-span-6">
                    <div class="max-w-xl text-sm text-gray-600">
                        {{ __('Please provide the email address of the person you would like to add to this team.') }}
                    </div>
                </div>

                {{-- Member Name --}}
                <div class="col-span-6 sm:col-span-4">
                    <x-jet-label for="first_name" value="{{ __('First Name') }}"/>
                    <x-jet-input id="first_name" type="text" class="mt-1 block w-full" wire:model.defer="first_name"/>
                    <x-jet-input-error for="first_name" class="mt-2"/>
                </div>

                <div class="col-span-6 sm:col-span-4">
                    <x-jet-label for="last_name" value="{{ __('Last Name') }}"/>
                    <x-jet-input id="last_name" type="text" class="mt-1 block w-full" wire:model.defer="last_name"/>
                    <x-jet-input-error for="last_name" class="mt-2"/>
                </div>

                {{-- Member Email --}}
                {{--                @if(!$invitation)--}}
                <div class="col-span-6 sm:col-span-4">
                    <x-jet-label for="email" value="{{ __('Email') }}"/>
                    <x-jet-input id="email" type="text" class="mt-1 block w-full" wire:model.defer="email"/>
                    <x-jet-input-error for="email" class="mt-2"/>
                </div>
                {{--                @endif--}}

                {{-- Member Title --}}
                <div class="col-span-6 sm:col-span-4">
                    <x-jet-label for="title" value="{{ __('Title (optional)') }}"/>
                    <x-jet-input id="title" type="text" class="mt-1 block w-full"
                                 wire:model.defer="title"/>
                    <x-jet-input-error for="title" class="mt-2"/>
                </div>

                {{-- Member Password --}}
                {{--                <div class="col-span-6 sm:col-span-4">--}}
                {{--                    <x-jet-label for="password" value="{{ __('Password') }}"/>--}}
                {{--                    <x-jet-input id="password" type="text" class="mt-1 block w-full"--}}
                {{--                                 wire:model.defer="password"/>--}}
                {{--                    <x-jet-input-error for="password" class="mt-2"/>--}}
                {{--                </div>--}}

                {{-- Role --}}
                @if (count($this->roles) > 0)
                    <div class="col-span-6 lg:col-span-4">
                        <x-jet-label for="role" value="{{ __('Role') }}"/>
                        <x-jet-input-error for="role" class="mt-2"/>

                        <div class="relative z-0 mt-1 border border-gray-200 rounded-lg cursor-pointer">
                            @foreach ($this->roles as $index => $companyRole)
                                <button type="button"
                                        class="relative px-4 py-3 inline-flex w-full rounded-lg focus:z-10 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue {{ $index > 0 ? 'border-t border-gray-200 rounded-t-none' : '' }} {{ ! $loop->last ? 'rounded-b-none' : '' }}"
                                        wire:click="$set('role', '{{ $companyRole->key }}')">
                                    <div
                                        class="{{ (string)$role !== (string)$companyRole->key ? 'opacity-70' : '' }}">
                                        <!-- Role Name -->
                                        <div class="flex items-center">
                                            <div
                                                class="text-sm text-gray-600 {{ (string)$role == (string)$companyRole->key ? 'font-semibold' : '' }}">
                                                {{ $companyRole->name }}
                                            </div>

                                            @if ($role == $companyRole->key)
                                                <svg class="ml-2 h-5 w-5 text-green-400" fill="none"
                                                     stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                     stroke="currentColor" viewBox="0 0 24 24">
                                                    <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                            @endif
                                        </div>

                                        <!-- Role Description -->
                                        <div class="mt-2 text-xs text-gray-600 text-left">
                                            {{ $companyRole->description }}
                                        </div>
                                    </div>
                                </button>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- level --}}
                @if (count($this->levels) > 0)
                    <div class="col-span-6 lg:col-span-4">
                        <x-jet-label for="levels" value="{{ __('User Level') }}"/>
                        <x-jet-input-error for="level" class="mt-2"/>

                        <div class="relative z-0 mt-1 border border-gray-200 rounded-lg cursor-pointer">
                            @foreach ($this->levels as $index => $userLevel)
                                <button type="button"
                                        class="relative px-4 py-3 inline-flex w-full rounded-lg focus:z-10 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue {{ $index > 0 ? 'border-t border-gray-200 rounded-t-none' : '' }} {{ ! $loop->last ? 'rounded-b-none' : '' }}"
                                        wire:click="$set('level', '{{ $userLevel->key }}')">
                                    <div
                                        class="{{ (string)$level !== (string)$userLevel->key ? 'opacity-70' : '' }}">
                                        <!-- Role Name -->
                                        <div class="flex items-center">
                                            <div
                                                class="text-sm text-gray-600 {{ (string)$level == (string)$userLevel->key ? 'font-semibold' : '' }}">
                                                {{ $userLevel->name }}
                                            </div>
                                            @if ((string)$level == (string)$userLevel->key)
                                                <svg class="ml-2 h-5 w-5 text-green-400" fill="none"
                                                     stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                     stroke="currentColor" viewBox="0 0 24 24">
                                                    <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                            @endif
                                        </div>

                                        <!-- Role Description -->
                                        <div class="mt-2 text-xs text-gray-600 text-left">
                                            {{ $userLevel->description }}
                                        </div>
                                    </div>
                                </button>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- choose team & role --}}
                <div class="col-span-6 lg:col-span-4">
                    <x-jet-label for="selected_teams" class="text-lg font-bold"
                                 value="{{ __('Add User to Existing Teams') }}"/>
                    <x-jet-label for="selected_teams"
                                 value="{{ __('Select all teams you would like this user to join') }}"/>
                    <x-jet-input-error for="selected_teams" class="mt-2"/>

                    <div class="grid grid-cols-1 mt-1 divide-y divide-gray-200 rounded-lg border border-gray-200">
                        @foreach($teams as $team)
                            <div
                                class="text-sm w-full py-5 px-4 pt-4.5 text-gray-600 {{ $this->teamSelected($team->id) ?: 'opacity-70' }}">
                                <div class="flex justify-between cursor-pointer"
                                     wire:click="addToTeam('{{$team->id}}')">
                                    <div
                                        class="{{!$this->teamSelected($team->id) ?: 'font-semibold'}}">{{ $team->name }}</div>

                                    @if ($this->teamSelected($team->id))
                                        <svg class="h-5 w-5 text-green-400 inline -mt-0.5" fill="none"
                                             stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                             stroke="currentColor" viewBox="0 0 24 24">
                                            <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    @endif
                                </div>

                                @if ($this->teamSelected($team->id))
                                    <div class="border-t border-gray-100 pt-2 mt-3">
                                        <div class="col-span-6 lg:col-span-4 mt-1">
                                            <label class="block font-medium text-sm text-gray-500 mb-1" for="role">
                                                Select Role
                                            </label>

                                            <div
                                                class="grid grid-cols-1 divide-y divide-gray-200 text-sm border rounded border-gray-200 w-full text-gray-600 cursor-pointer">
                                                @foreach($teamRoles as $roleKey => $roleName)
                                                    <div
                                                        class="px-3 py-4 flex {{ $this->roleSelectedForTeam($team->id, $roleKey) ?: 'opacity-70' }}"
                                                        wire:click="selectRole('{{$team->id}}', '{{$roleKey}}')">
                                                        <div class="text-xs">{{ $roleName }}</div>

                                                        @if ($this->roleSelectedForTeam($team->id, $roleKey))
                                                            <svg class="h-4 w-4 text-green-400 ml-2 inline" fill="none"
                                                                 stroke-linecap="round" stroke-linejoin="round"
                                                                 stroke-width="2"
                                                                 stroke="currentColor" viewBox="0 0 24 24">
                                                                <path
                                                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                            </svg>
                                                        @endif
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            </x-slot>

            <x-slot name="actions">
                <x-jet-action-message class="mr-3 text-green-500" on="saved">
                    {{ __('New user has been invited successfully.') }}
                </x-jet-action-message>

                @if($invitation)
                    <x-jet-button class="mr-3" wire:loading.attr="disabled">
                        Save
                    </x-jet-button>

                    <x-secondary-link-button wire:click.prevent="updateInvitation({{true}})"
                                             wire:loading.attr="disabled">
                        Save & Send Invitation
                    </x-secondary-link-button>
                @else
                    <x-jet-button>
                        {{ __('Invite') }}
                    </x-jet-button>
                @endif
            </x-slot>
        </x-jet-form-section>
    </div>
</div>
