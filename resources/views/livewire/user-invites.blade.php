<div class="flex flex-col">
    <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
        <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
            <div class="flex justify-between w-full mb-5">
                <x-jet-input class="w-1/4 text-sm" type="text" wire:model="search" placeholder="Search User ..."
                             autofocus/>

                <div class="inline-flex items-center space-x-2">
                    <x-secondary-link-button wire:click="bulkInvite()">
                        Bulk Invite
                    </x-secondary-link-button>

                    <x-link-button href="{{ route('company.manage.users') }}">
                        Invite User
                    </x-link-button>
                </div>
            </div>

            <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                    <tr>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider font-bold">
                            Name
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider font-bold">
                            Title
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider font-bold">
                            Role
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider font-bold">
                            Level
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider font-bold">
                            Status
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider font-bold">
                            Actions
                        </th>
                    </tr>
                    </thead>

                    <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($users as $user)
                        <tr class="">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <img class="h-10 w-10 rounded-full" src="{{ $user->profile_photo_url }}"
                                             alt=""/>
                                    </div>

                                    <div class="ml-4" wire:loading.class.delay="opacity-40">
                                        <div class="text-sm font-medium text-gray-900">
                                            {{ $user->name }}
                                        </div>
                                        <div class="text-sm text-gray-500">
                                            {{ $user->email }}
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $user->position }}</div>
                                <div class="text-sm text-gray-500">{{ $user->progress }}</div>
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $user->role == '1' ? 'Company Administrator' : 'Standard User' }}
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                Level {{ $user->level }}
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    $status = $this->getInvitationStatus($user->created_at , $user->signed_up_at);
                                @endphp

                                <span
                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-{{$status['color']}}-100 text-{{$status['color']}}-800">
                                    {{ $status['status'] }}
                                </span>
                            </td>

                            <td>
                                @if(!$user->signed_up_at)
                                    <div class="">
                                        @if($this->isInvitationExpired($user->created_at))
                                            <a href="javascript:void(0);"
                                               class="text-green-600 hover:text-green-900 mr-2 lg:mr-5 md:sm:mr-3"
                                               wire:click="resendInvitation('{{$user->email}}')">
                                                <span>
                                                    <i class="fas fa-redo" title="resend"></i>
                                                </span>
                                            </a>
                                        @else
                                            <span class=" mr-2 lg:mr-5 md:sm:mr-3">&nbsp;&nbsp;&nbsp;&nbsp;</span>

                                        @endif

                                        <a href="javascript:void(0);" class="text-indigo-600 hover:text-indigo-900 mr-2 lg:mr-5 md:sm:mr-3"
                                           wire:click="editInvitation('{{$user->email}}')">
                                            <span>
                                                <i class="fa fa-edit" title="edit"></i>
                                            </span>
                                        </a>

                                        <a href="javascript:void(0);" class="text-red-400 hover:text-red-900 mr-2 lg:mr-5 md:sm:mr-3"
                                           wire:click="confirmDeletingInvitation('{{$user->email}}')">
                                            <span>
                                                <i class="fa fa-trash" title="delete"></i>
                                            </span>
                                        </a>
                                    </div>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap" colspan="100%">
                                <div class="flex items-center justify-center text-gray-600 h-16 opacity-50 text-md">
                                    <span class="mr-3"><i class="fa fa-envelope"></i></span>
                                    <span class="text-lg">No Invitations Found ...</span>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>

                <div class="p-5">
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Invitation Confirmation Modal -->
    <x-jet-dialog-modal wire:model="confirmDeleteInvitation" wire:click.away="cancelDeletingInvitation">
        <x-slot name="title">
            {{ __('Delete Invitation') }}
        </x-slot>

        <x-slot name="content">
            {{ __('Are you sure you want to delete invitation?') }}
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="cancelDeletingInvitation()" wire:loading.attr="disabled">
                {{ __('Nevermind') }}
            </x-jet-secondary-button>

            <x-jet-danger-button class="ml-2" wire:click="deleteInvitation()" wire:loading.attr="disabled">
                {{ __('Delete Invitation') }}
            </x-jet-danger-button>
        </x-slot>
    </x-jet-dialog-modal>

    <!-- Edit Invitation Modal -->
    <x-jet-modal wire:model="showInvitationUpdateModal" wire:click.away="resetEditInvitationModal()">
        <div class="p-4">
            <div class="text-lg">
                {{ __('Edit Invitation') }}
            </div>
        </div>

        @if($showInvitationUpdateModal)
            @livewire('add-user-by-email', ['invitation' => $selectedInvitation])
        @endif
    </x-jet-modal>
</div>
