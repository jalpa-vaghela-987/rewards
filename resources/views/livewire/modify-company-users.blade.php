<div>
    <x-jet-section-border/>

    <!-- Manage Team Members -->
    <div class="mt-10 sm:mt-0">
        <x-jet-action-section>
            <x-slot name="title">
                {{ __('Company Members') }}
            </x-slot>

            <x-slot name="description">
                {{ __('All of the people that are part of this company.') }}<br>
                {{count($users)}} Users
            </x-slot>

            <!-- Team Member List -->
            <x-slot name="content">
                <div class="flex pb-6">
                    {{--                <span class="w-4/6"></span>--}}

                    <x-jet-input id="search" name="search" type="text" class="mt-1 w-full"
                                 wire:model.debounce.300ms="search" placeholder="Search"/>
                </div>
                {{--                <div class="flex pb-6">--}}
                {{--                    <x-jet-input id="search"--}}
                {{--                                 name="search"--}}
                {{--                                 type="text"--}}
                {{--                                 class="mt-1 w-full"--}}
                {{--                                 wire:model.debounce.300ms="search"--}}
                {{--                                 placeholder="Search"/>--}}
                {{--                </div>--}}


                <div class="space-y-6">
                    @foreach ($users as $user)
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <img class="w-8 h-8 rounded-full" src="{{ $user->profile_photo_url }}"
                                     alt="{{ $user->name }}">
                                <a class="ml-4 text-black text-xls bold font-sans"
                                   href="{{ route('profile.user',['user' => $user->id])}}">
                                    {{ $user->name }}
                                    @if ($user->role === 1)
                                        <span class="tooltip mt-5" title="Company Admin">
                                            <i class="fa fa-building"></i>
                                        </span>
                                    @endif
                                </a>
                            </div>

                            <div class="flex items-center">
                                <!-- Manage Team Member Role -->
                            <!-- <button class="ml-2 text-sm text-gray-400 underline" wire:click="manageRole('{{ $user->id }}')">
                                   Testing
                                </button> -->

                                <!-- Leave Team -->
                                <button class="cursor-pointer ml-6 text-sm text-green-500"
                                        wire:click="manageModifyPermission({{ $user->id }})">
                                    {{ __('Modify Permissions') }}
                                </button>

                                <!-- Remove Team Member -->
                                <button class="cursor-pointer ml-6 text-sm text-red-500"
                                        wire:click="confirmCompanyMemberRemoval('{{ $user->id }}')">
                                    {{ __('Delete') }}
                                </button>
                            </div>
                        </div>
                    @endforeach
                    {{$users->links()}}
                </div>
            </x-slot>
        </x-jet-action-section>
    </div>

    <!-- Modify User Permission Modal -->
    <x-jet-dialog-modal wire:model="showModifyPermission">
        <x-slot name="title">
            {{ __('Modify Permission') }}
        </x-slot>

        <x-slot name="content">
            <!-- Role -->
            @if (count($this->roles) > 0)
                <div class="col-span-6 lg:col-span-4">
                    <x-jet-label for="role" value="{{ __('Role') }}"/>
                    <x-jet-input-error for="role" class="mt-2"/>

                    <div class="relative z-0 mt-1 border border-gray-200 rounded-lg cursor-pointer">
                        @foreach ($this->roles as $index => $roleOption)
                            <button type="button"
                                    class="relative px-4 py-3 inline-flex w-full rounded-lg focus:z-10 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue {{ $index > 0 ? 'border-t border-gray-200 rounded-t-none' : '' }} {{ ! $loop->last ? 'rounded-b-none' : '' }}"
                                    wire:click="$set('role', '{{ $roleOption->key }}')">
                                <div
                                    class="{{ isset($role) && $role != $roleOption->key ? 'opacity-50' : '' }}">
                                    <!-- Role Name -->
                                    <div class="flex items-center">
                                        <div
                                            class="text-sm text-gray-600 {{ $role == $roleOption->key ? 'font-semibold' : '' }}">
                                            {{ $roleOption->name }}
                                        </div>

                                        @if ($role == $roleOption->key)
                                            <svg class="ml-2 h-5 w-5 text-green-400" fill="none"
                                                 stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                 stroke="currentColor" viewBox="0 0 24 24">
                                                <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        @endif
                                    </div>

                                    <!-- Role Description -->
                                    <div class="mt-2 text-xs text-gray-600 text-left">
                                        {{ $roleOption->description }}
                                    </div>
                                </div>
                            </button>
                        @endforeach
                    </div>
                </div>
            @endif
            @if (count($this->levels) > 0)
                <div class="col-span-6 lg:col-span-4 mt-4">
                    <x-jet-label for="levels" value="{{ __('User Level') }}"/>
                    <x-jet-input-error for="level" class="mt-2"/>

                    <div class="relative z-0 mt-1 border border-gray-200 rounded-lg cursor-pointer">
                        @foreach ($this->levels as $index => $levelOption)
                            <button type="button"
                                    class="relative px-4 py-3 inline-flex w-full rounded-lg focus:z-10 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue {{ $index > 0 ? 'border-t border-gray-200 rounded-t-none' : '' }} {{ ! $loop->last ? 'rounded-b-none' : '' }}"
                                    wire:click="$set('level', '{{ $levelOption->key }}')">
                                <div
                                    class="{{ isset($level) && $level != $levelOption->key ? 'opacity-50' : '' }}">
                                    <!-- Role Name -->
                                    <div class="flex items-center">
                                        <div
                                            class="text-sm text-gray-600 {{ $level == $levelOption->key ? 'font-semibold' : '' }}">
                                            {{ $levelOption->name }}
                                        </div>
                                        @if ($level == $levelOption->key)
                                            <svg class="ml-2 h-5 w-5 text-green-400" fill="none"
                                                 stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                 stroke="currentColor" viewBox="0 0 24 24">
                                                <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        @endif
                                    </div>

                                    <!-- Role Description -->
                                    <div class="mt-2 text-xs text-gray-600 text-left">
                                        {{ $levelOption->description }}
                                    </div>
                                </div>
                            </button>
                        @endforeach
                    </div>
                </div>
            @endif
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="cancel" wire:loading.attr="disabled">
                {{ __('Nevermind') }}
            </x-jet-secondary-button>

            <x-jet-button class="ml-2" wire:click="modifyPermission" wire:loading.attr="disabled">
                {{ __('Update') }}
            </x-jet-button>
        </x-slot>
    </x-jet-dialog-modal>

    <!-- Remove Company Member Confirmation Modal -->
    <x-jet-confirmation-modal wire:model="confirmingCompanyMemberRemoval">
        <x-slot name="title">
            {{ __('Remove Company Member') }}
        </x-slot>

        <x-slot name="content">
            {{ __('Are you sure you would like to remove this person from the company?') }}
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$set('confirmingCompanyMemberRemoval', false)"
                                    wire:loading.attr="disabled">
                {{ __('Nevermind') }}
            </x-jet-secondary-button>

            <x-jet-danger-button class="ml-2" wire:click="removeCompanyMember" wire:loading.attr="disabled">
                {{ __('Remove') }}
            </x-jet-danger-button>
        </x-slot>
    </x-jet-confirmation-modal>
</div>
