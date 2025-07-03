<div>
{{--    <x-jet-form-section>--}}
    <x-jet-form-section submit="">
        <x-slot name="title">
            @if(!$editingUser)
                {{ __('Invite New User') }}
            @else
                {{ __('Manage User Permission') }}
            @endif
        </x-slot>

        <x-slot name="description">
            @if(!$editingUser)
                {{ __('Invite a new user to join '. appName() .', allowing them access to the full platform.') }}
            @else
                {{ __('Manage user roles & permission by allowing them to access to the full platform.') }}
            @endif
        </x-slot>

        <x-slot name="form">
            @if(!$editingUser)
            <div class="col-span-6">
                <div class="max-w-xl text-sm text-gray-600">
                    {{ __('Please provide the email address of the person you would like to add to this team.') }}
                </div>
            </div>
            @endif

            {{-- Member Name --}}
            @if(!$editingUser)
            <div class="col-span-6 sm:col-span-4">
                <x-jet-label class="font-semibold" for="search" value="{{ __('Search User') }}"/>

                <input wire:model.debounce.500ms="search" type="search" id="searchbar" autocomplete="off"
                       placeholder="Search for user..." class="focus:outline-none border-bottom border-gray-200"
                       style="border-top:none; border-left: none; border-right: none;">

                <ul class="absolute z-50 bg-white shadow-md rounded-md text-gray-700 text-sm divide-y divide-gray-300" id="search_ul3" style="width: 300px;">
                    @if(count($searchResults)<15 || $search != "")
                        @foreach(collect($searchResults)->slice(0, 5) as $result)
                            <li class="border  border-gray-300" wire:model="removeLI">
                                <div wire:click="addUser({{$result->id}})"
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

                <x-jet-input-error for="recipient" class="mt-2"/>

                @if($recipient)
                    <div class="flex items-center px-4 py-4 mt-3">
                        <img src="{{$recipient->profile_photo_url}}" class="w-10 rounded-full">

                        <div class="ml-4 leading-tight">
                            <div class="font-semibold">{{$recipient->name}}</div>
                            <div class="text-gray-600">{{$recipient->position}}</div>
                        </div>
                    </div>

                    <input type="hidden" name="recipient_id" value="{{$recipient->id}}">
                @endif
            </div>
            @endif

            <!-- Role -->
            @if (count($roles) > 0)
                <div class="col-span-6 lg:col-span-4 @if(!$editingUser) mt-2 @endif">
                    <x-jet-label class="font-semibold" for="role" value="{{ __('Select Role') }}"/>
                    <x-jet-input-error for="role" class="mt-2"/>

                    <div class="relative z-0 mt-1 border border-gray-200 rounded-lg cursor-pointer mt-2">
                        @foreach ($roles as $index => $role)
                            <button type="button" class="relative px-4 py-3 inline-flex w-full rounded-lg focus:z-10 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue {{ $index > 0 ? 'border-t border-gray-200 rounded-t-none' : '' }} {{ ! $loop->last ? 'rounded-b-none' : '' }}"
                                    wire:click="$set('addTeamMemberForm.role', '{{ data_get($role, 'key') }}')">
                                <div class="{{ !$this->isRoleSelected($role) ? 'opacity-50' : '' }}">
                                    <!-- Role Name -->
                                    <div class="flex items-center">
                                        <div class="text-sm text-gray-600 {{!$this->isRoleSelected($role) ?: 'font-semibold'}}">
                                            {{ data_get($role, 'name') }}
                                        </div>

                                        @if ($this->isRoleSelected($role))
                                            <svg class="ml-2 h-5 w-5 text-green-400" fill="none"
                                                 stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                 stroke="currentColor" viewBox="0 0 24 24">
                                                <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        @endif
{{--                                            @if ($editingUser && data_get($role, 'key') == $roleNames[data_get($editingUser, 'role')])--}}
{{--                                                <svg class="ml-2 h-5 w-5 text-green-400" fill="none"--}}
{{--                                                     stroke-linecap="round" stroke-linejoin="round" stroke-width="2"--}}
{{--                                                     stroke="currentColor" viewBox="0 0 24 24">--}}
{{--                                                    <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>--}}
{{--                                                </svg>--}}
{{--                                            @endif--}}
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

            <x-jet-secondary-button wire:click="$emit('close-manage-team-member-modal')" class="mt-2 mr-2" wire:loading.attr="disabled">
                {{ __('Close') }}
            </x-jet-secondary-button>

            @if($editingUser)
                <x-jet-button type="submit" wire:click="updateMember" wire:loading.attr="disabled" class="mt-2">
                    {{ __('Save') }}
                </x-jet-button>
            @else
                <x-jet-button type="submit" wire:click="addTeamMember" wire:loading.attr="disabled" class="mt-2">
                    {{ __('Invite') }}
                </x-jet-button>
            @endif
        </x-slot>
    </x-jet-form-section>
</div>
