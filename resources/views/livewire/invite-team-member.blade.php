<div>
    @foreach($teams as $t)
        @if($t->users && $t->users->count())
            <div class="md:flex w-full mt-3 m-1 overflow-hidden mt-5 p-3 pl-1 border-t border-gray-200">
                <div class="flex w-full md:block md:w-1/5 m-2">
                    <div>
                        <h1 class="text-lg">{{ $t->name }}</h1>

                        <div class="italic ml-2">
                            {{$t->users->count()}} Members
                        </div>

                        <div class="italic ml-2">
                            Created on {{$t->created_at->format('F jS, Y') }}
                        </div>
                    </div>

                    <div>
                        <div class="font-semibold ml-2">
                            Team Administrator Users:
                        </div>

                        <div class="ml-2">
                            @foreach($t->users()->wherePivot('role', 'admin')->orderBy('name')->get() as $user)
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
                        <div>
                            <h2 class="text-xl">Members of {{$t->name}}</h2>
                        </div>

                        @can('addTeamMember', $t)
                        <div>
                            <x-secondary-link-button class="mb-2 -mt-1 mr-2" wire:click="openAddTeamMemberModal({{$t->id}})">Add</x-secondary-link-button>
                        </div>
                        @endcan
                    </div>

                    <div style="max-height: 50vh; min-height: 25vh" class="p-2 overflow-y-auto overflow-x-hidden">
{{--                        <div class="grid w-3/4 overflow-y-scroll overflow-x-hidden w-1/4 gap-4 ">--}}
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-5 overflow-x-hidden w-full h-full gap-4">
                            @foreach($t->users()->orderBy('name')->get() as $u)
                                <div style="min-height: 10vh; max-height: 50vh; height: 100%" class="text-center relative">
                                    <div class="w-full h-full rounded rounded-t-lg overflow-hidden bg-white border border-gray-300 px-1 py-4" style="min-width: 100px; ">
                                        @if(Gate::allows('addTeamMember', $t) || $u->id === auth()->id())
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
                                                        @can('updateTeamMember', $t)
                                                            <a class="border border-gray-100 cursor-pointer text-sm text-green-500 block px-2 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out truncate "
                                                               style="border-top: none"
                                                               wire:click="manageModifyPermission({{ $t->id}}, {{$u->id }})">
                                                                {{ __('Modify Permissions') }}
                                                            </a>
                                                        @endif

                                                        @if (auth()->id() === $u->id)
                                                            <a class="cursor-pointer block px-2 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out truncate text-sm text-red-500"
                                                                    wire:click="confirmLeavingTeam({{$u->id}}, {{$t->id}})">
                                                                {{ __('Leave') }}
                                                            </a>
                                                            <!-- Remove Team Member -->
                                                        @elseif (Gate::check('removeTeamMember', $t))
                                                            <a class="cursor-pointer block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out truncate text-sm text-red-500"
                                                                    wire:click="confirmTeamMemberRemoval({{$u->id}}, {{$t->id}})">
                                                                {{ __('Remove') }}
                                                            </a>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endcan

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
                                            <p class="text-xs text-center">{{ number_format($u->points) }} {{ getReplacedWordOfKudos() }} to Spend</p>
                                            <p class="text-xs mt-1 text-center">{{ number_format($u->points_to_give) }} {{ getReplacedWordOfKudos() }} available to give away</p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
    @endif
@endforeach

    <!-- Leave Team Confirmation Modal -->
    <x-jet-confirmation-modal wire:model="confirmingLeavingTeam">
        <x-slot name="title">
            {{ __('Leave Team') }}
        </x-slot>

        <x-slot name="content">
            {{ __('Are you sure you would like to leave this team?') }}
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
