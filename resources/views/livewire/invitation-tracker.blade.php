<div>

    <!-- Manage Team Members -->
    <div class="mt-10 sm:mt-0">
        <x-jet-action-section>
            <x-slot name="title">
                {{ __('Invitations Outstanding') }}
            </x-slot>

            <x-slot name="description">
                {{ __('All of the invitations currently outstanding at your company.') }}<br>
            </x-slot>

            <!-- Team Member List -->
            <x-slot name="content">
                <div class="space-y-1">
                    @foreach ($items as $user)
                        <div class="flex items-center justify-between py-1 ">
                            <div class="flex items-center">
                                <div class="ml-1 text-black text-xls bold font-sans">{{ $user->email }}</div>
                            </div>


                            <div class="flex items-center">


{{--                                <button class="cursor-pointer ml-2 text-sm text-green-500"--}}
{{--                                        wire:click="manageModifyPermission({{ $user->id }})">--}}
{{--                                    {{ __('Modify Permissions') }}--}}
{{--                                </button>--}}

                                <!-- Remove Team Member -->
                                <button class="cursor-pointer ml-2 text-sm text-red-500"
                                        wire:click="confirmCompanyMemberRemoval('{{ $user->id }}')">
                                    {{ __('Delete') }}
                                </button>
                            </div>
                        </div>
                        <div class="flex ml-2 pb-1 pt-2 text-sm italic items-center text-right justify-between
                            @if(!$loop->last) border-b border-gray-200 @endif"
                        >
                             <div>
{{--                                 <button class="cursor-pointer ml-2 text-sm text-blue-500"--}}
{{--                                                wire:click="resendInvite({{ $user->id }})">--}}
{{--                                            {{ __('Resend') }}--}}
{{--                                </button>--}}
                            </div>
                            <div>
                                Sent {{Timezone::convertToLocal($user->created_at, 'F jS, Y \- g:i A')}}
                            </div>
                        </div>
                    @endforeach
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
            {{ __('Deactivate Invitation') }}
        </x-slot>

        <x-slot name="content">
            {{ __('Are you sure you would like to deactivate the invitation?') }}
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$set('confirmingCompanyMemberRemoval', false)" wire:loading.attr="disabled">
                {{ __('Nevermind') }}
            </x-jet-secondary-button>

            <x-jet-danger-button class="ml-2" wire:click="removeCompanyMember" wire:loading.attr="disabled">
                {{ __('Remove') }}
            </x-jet-danger-button>
        </x-slot>
    </x-jet-confirmation-modal>
</div>
