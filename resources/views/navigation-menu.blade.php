@if((auth()->guest() && \Illuminate\Support\Facades\Route::current()->getName() !== 'card.view') || auth()->user())
    <nav x-data="{ open: false }" class="bg-white border-b border-gray-100 shadow">
        <!-- Primary Navigation Menu -->
        <div class="container px-4 mx-auto">
            <div class="flex justify-between h-16 lg:h-20">
                <div class="flex">
                    <!-- Logo -->
                    <div class="flex-shrink-0 flex items-center">
                        <a href="{{ route('kudos.feed') }}">
                            <x-jet-application-mark class="block h-5 w-auto"/>
                        </a>
                    </div>

                    <!-- Navigation Links -->
                    <div class="hidden space-x-2 md:space-x-4 xl:space-x-10 sm:-my-px sm:ml-6 xl:ml-10 sm:flex">
                        <x-jet-nav-link href="{{ route('kudos.feed') }}" :active="request()->routeIs('kudos.feed')">
                            {{ __(getReplacedWordOfKudos()) }} Feed
                        </x-jet-nav-link>

                        <x-jet-nav-link href="{{ route('people') }}" :active="request()->routeIs('people')">
                            {{ __('People') }}
                        </x-jet-nav-link>

                        <x-jet-nav-link href="{{ route('wallet', ['currency' => auth()->user()->currency]) }}"
                                        :active="request()->routeIs('wallet')">
                            {{ getReplacedWordOfKudos() }} {{ __('Wallet') }}
                        </x-jet-nav-link>

                        <x-jet-nav-link href="{{ route('card.cards') }}"
                                        :active="request()->routeIs('card.cards') || request()->routeIs('card.create')">
                            {{ __('Group Cards') }}
                        </x-jet-nav-link>

                        @if(Auth::user()->company->using_connect)
                            <x-jet-nav-link href="{{ route('connect') }}" :active="request()->routeIs('connect')">
                                {{ __('Connect') }}
                            </x-jet-nav-link>
                        @endif

                        <livewire:search-dropdown/>
                    </div>
                </div>

                <div class="hidden lg:flex lg:items-center lg:ml-1">
                    <livewire:mark-notifications-read/>

                    <!-- Company Dropdown -->
                    @if (Auth::user()->role == 1)
                        <div class="px-2">
                            <x-jet-dropdown align="right" width="60">
                                <x-slot name="trigger">
                            <span class="inline-flex rounded-md">
                                <button type="button"

                                        class="
                                @if((auth()->user()->role == 1)) hover:border-gray-300 @endif
                                        @if(!Auth::user()->company->logo_path) py-2 @else py-0 @endif
                                            inline-flex items-center px-1 border border-transparent text-sm leading-4
                                                    font-medium rounded-md text-gray-500 bg-white hover:bg-gray-50 hover:text-gray-700
                                                    focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition ease-in-out
                                                    duration-150 inline-flex items-center px-1 border border-transparent
"
                                >
                                    @if(Auth::user()->company->logo_path)
                                        <livewire:company-logo/>
                                    @else
                                        {{ substr(Auth::user()->company->name, 0, 20) }}
                                    @endif

                                    @if (Auth::user()->role == 1)
                                        <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                             viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd"
                                                  d="M10 3a1 1 0 01.707.293l3 3a1 1 0 01-1.414 1.414L10 5.414 7.707 7.707a1 1 0 01-1.414-1.414l3-3A1 1 0 0110 3zm-3.707 9.293a1 1 0 011.414 0L10 14.586l2.293-2.293a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z"
                                                  clip-rule="evenodd"/>
                                        </svg>
                                    @endif
                                </button>
                            </span>
                                </x-slot>

                                <x-slot name="content">
                                    <div class="w-60">
                                        @can('access_admin_controls')
                                            <div class="border-t border-gray-100"></div>

                                            <div class="block px-4 py-2 text-xs text-gray-400">
                                                User Management
                                            </div>

                                            <x-jet-dropdown-link href="{{ route('company.manage.users') }}">
                                                {{ __('Manage ')}} {{(' Users') }}
                                            </x-jet-dropdown-link>

                                            <x-jet-dropdown-link href="{{ route('admin.kudos-gifting') }}">
                                                {{ getReplacedWordOfKudos() . __(' Admin Gifting') }}
                                            </x-jet-dropdown-link>

                                            <x-jet-dropdown-link href="{{ route('company.manage-invites') }}">
                                                {{ __('User Invitations') }}
                                            </x-jet-dropdown-link>

                                            <x-jet-dropdown-link href="{{ route('company.user-stats') }}">
                                                {{ __('User Statistics') }}
                                            </x-jet-dropdown-link>

                                            <div class="border-t border-gray-100"></div>
                                            <div class="block px-4 py-2 text-xs text-gray-400">
                                                Reward Management
                                            </div>


                                            <x-jet-dropdown-link
                                                href="{{ route('rewards.company', ['currency' => auth()->user()->currency]) }}">
                                                {{ __('Manage Rewards') }}
                                            </x-jet-dropdown-link>

                                            <x-jet-dropdown-link href="{{ route('rewards.company-stats') }}">
                                                {{ __('Reward Statistics') }}
                                            </x-jet-dropdown-link>

                                            <div class="border-t border-gray-100"></div>

                                            <div class="block px-4 py-2 text-xs text-gray-400">
                                                {{ __('Analytics & Billing') }}
                                            </div>

                                            <x-jet-dropdown-link href="{{ route('dashboard') }}">
                                                {{ __('Activity Dashboard') }}
                                            </x-jet-dropdown-link>

                                            <x-jet-dropdown-link href="{{ route('billing') }}">
                                                {{ __('Billing Dashboard') }}
                                            </x-jet-dropdown-link>

                                            <div class="border-t border-gray-100"></div>

                                            <div class="block px-4 py-2 text-xs text-gray-400">
                                                Company Customization
                                            </div>

                                            <x-jet-dropdown-link href="{{ route('manage.company') }}">
                                                Company {{(' Settings') }}
                                            </x-jet-dropdown-link>

                                            @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                                                <x-jet-dropdown-link href="{{ route('api-tokens.index') }}">
                                                    {{ __('API Tokens') }}
                                                </x-jet-dropdown-link>
                                            @endif
                                        @endcan
                                    </div>
                                </x-slot>
                            </x-jet-dropdown>
                        </div>
                    @else
                        @if(Auth::user()->company->logo_path)
                            <livewire:company-logo/>
                        @else
                            {{ substr(Auth::user()->company->name, 0, 20) }}
                        @endif
                    @endif

                    <div class="ml-3 relative">
                        <x-jet-dropdown align="right" width="60">
                            <x-slot name="trigger">
                                <span class="inline-flex rounded-md">
                                    <button type="button"
                                            class="inline-flex items-center px-3 py-2 border border-transparent hover:border-gray-300 text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:bg-gray-50 hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition ease-in-out duration-150">

                                           Manage Teams


                                        <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                             viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd"
                                                  d="M10 3a1 1 0 01.707.293l3 3a1 1 0 01-1.414 1.414L10 5.414 7.707 7.707a1 1 0 01-1.414-1.414l3-3A1 1 0 0110 3zm-3.707 9.293a1 1 0 011.414 0L10 14.586l2.293-2.293a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z"
                                                  clip-rule="evenodd"/>
                                        </svg>
                                    </button>
                                </span>
                            </x-slot>

                            <x-slot name="content">
                                <div class="w-60">
                                @if (Laravel\Jetstream\Jetstream::hasTeamFeatures())
                                    <!-- Team Management -->
                                        <div class="block px-4 py-2 text-xs text-gray-400">
                                            {{ __('Build Teams') }}
                                        </div>

                                        <x-jet-dropdown-link href="{{ route('teams.manage') }}">
                                            {{ __('Team Management') }}
                                        </x-jet-dropdown-link>

                                        @can('create', Laravel\Jetstream\Jetstream::newTeamModel())
                                            <x-jet-dropdown-link href="{{ route('teams.create') }}">
                                                {{ __('Create New Team') }}
                                            </x-jet-dropdown-link>
                                        @endcan

                                        <div class="border-t border-gray-100"></div>
                                    @endif

                                <!-- Team Settings -->
                                    {{--                                    @if (Auth::user()->hasTeams())--}}
                                    {{--                                        <x-jet-dropdown-link--}}
                                    {{--                                            href="{{ route('teams.show', Auth::user()->currentTeam->id) }}">--}}
                                    {{--                                            {{ __('Team Settings') }}--}}
                                    {{--                                        </x-jet-dropdown-link>--}}
                                    {{--                                    @endif--}}

                                <!-- Team Switcher -->
                                    @if (Auth::user()->hasTeams() && count(Auth::user()->allTeams()))
                                        <div class="block px-4 py-2 text-xs text-gray-400">
                                            {{ __('Modify Team Settings') }}
                                        </div>

                                        @foreach (Auth::user()->allTeams() as $team)
                                            <x-jet-switchable-team :team="$team"/>
                                        @endforeach
                                    @endif
                                </div>
                            </x-slot>
                        </x-jet-dropdown>
                    </div>

                    <!-- Settings Dropdown -->
                    <div class="ml-3 relative">
                        <x-jet-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button
                                    class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition duration-150 ease-in-out">
                                    <img class="h-8 w-8 rounded-full object-cover"
                                         src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}"/>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <!-- Account Management -->
                                <div class="block px-4 py-2 text-xs text-gray-400">
                                    {{ __('Manage Account') }}
                                </div>

                                <x-jet-dropdown-link href="{{ route('profile') }}">
                                    {{ __('View Profile') }}
                                </x-jet-dropdown-link>

                                <x-jet-dropdown-link href="{{ route('profile.show') }}">
                                    {{ __('Manage Profile') }}
                                </x-jet-dropdown-link>

                                <x-jet-dropdown-link href="{{ route('help') }}">
                                    Help &amp; Support
                                </x-jet-dropdown-link>


                                @if(auth()->check() && auth()->user()->can('is_developer_user'))
                                    <x-jet-responsive-nav-link href="{{ route('developer.show') }}"
                                                               :active="request()->routeIs('developer.show')">
                                        {{ __('Developer') }}
                                    </x-jet-responsive-nav-link>
                                @endif

                                <div class="border-t border-gray-100"></div>

                                <!-- Authentication -->
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf

                                    <x-jet-dropdown-link href="{{ route('logout') }}"
                                                         onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                        {{ __('Log Out') }}
                                    </x-jet-dropdown-link>
                                </form>
                            </x-slot>
                        </x-jet-dropdown>
                    </div>
                </div>

                <!-- Hamburger -->
                <div class="-mr-2 flex items-center lg:hidden">
                    <div class="sm:hidden block">
                        <livewire:search-dropdown/>
                    </div>

                    <livewire:mark-notifications-read/>

                    <button @click="open = ! open"
                            class="inline-flex items-center justify-center p-2 rounded-md {{--hover:text-white hover:bg-blue-500--}} focus:outline-none {{--focus:bg-blue-500--}} {{--focus:text-white--}} transition duration-150 ease-in-out"
                            :class="{'text-white': open, 'bg-blue-500': open, 'text-gray-600': !open}"
                    >
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex"
                                  stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M4 6h16M4 12h16M4 18h16"/>
                            <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden"
                                  stroke-linecap="round"
                                  stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Responsive Navigation Menu -->

        <div :class="{'block': open, 'hidden': ! open}"
             class="hidden lg:hidden absolute z-50 left-0 w-full bg-white shadow-md">
            <div class="pt-2 space-y-1">

                <x-jet-responsive-nav-link href="{{ route('kudos.feed') }}" :active="request()->routeIs('kudos.feed')">
                    {{ __(getReplacedWordOfKudos()) }} Feed
                </x-jet-responsive-nav-link>


                <x-jet-responsive-nav-link href="{{ route('people') }}" :active="request()->routeIs('people')">
                    {{ __('People') }}
                </x-jet-responsive-nav-link>

                <x-jet-responsive-nav-link href="{{ route('wallet', ['currency' => auth()->user()->currency]) }}"
                                           :active="request()->routeIs('wallet')">
                    {{ __(getReplacedWordOfKudos()) }} Wallet
                </x-jet-responsive-nav-link>

                <x-jet-responsive-nav-link href="{{ route('card.cards') }}" :active="request()->routeIs('card.cards')">
                    {{ __('Group Cards') }}
                </x-jet-responsive-nav-link>

                @if(Auth::user()->company->using_connect)
                    <x-jet-responsive-nav-link href="{{ route('connect') }}" :active="request()->routeIs('connect')">
                        {{ __('Connect') }}
                    </x-jet-responsive-nav-link>
                @endif

            </div>

            @if (Auth::user()->role == 1)
                <div class="flex flex-row">
                    <!-- Teams Dropdown -->
                    <div class="hidden lg:block">
                        <div class="px-2">
                            <x-jet-dropdown align="right" width="60">
                                <x-slot name="trigger">


                                <span class="inline-flex rounded-md">
                                    <button type="button"
                                            class="inline-flex items-center px-1 border border-transparent @if (Auth::user()->role == 1) hover:border-gray-300 @endif
                                                text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:bg-gray-50 hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition ease-in-out duration-150

                                                 @if(!Auth::user()->company->logo_path)
                                                py-2
@else
                                                py-0
@endif">
                                        @if(Auth::user()->company->logo_path)
                                            <livewire:company-logo/>
                                        @else
                                            {{ substr(Auth::user()->company->name, 0, 30) }}
                                        @endif

                                        @if (Auth::user()->role == 1)
                                            <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                                 viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd"
                                                      d="M10 3a1 1 0 01.707.293l3 3a1 1 0 01-1.414 1.414L10 5.414 7.707 7.707a1 1 0 01-1.414-1.414l3-3A1 1 0 0110 3zm-3.707 9.293a1 1 0 011.414 0L10 14.586l2.293-2.293a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z"
                                                      clip-rule="evenodd"/>
                                            </svg>
                                        @endif
                                    </button>
                                </span>
                                </x-slot>

                                <x-slot name="content">
                                    <div class="w-60">
                                        @can('access_admin_controls')
                                            <div class="border-t border-gray-100"></div>
                                            <div class="block px-4 py-2 text-xs text-gray-400">
                                                User Management
                                            </div>

                                            <x-jet-dropdown-link href="{{ route('company.manage.users') }}">
                                                {{ __('Manage ')}} {{(' Users') }}
                                            </x-jet-dropdown-link>

                                            <x-jet-dropdown-link href="{{ route('admin.kudos-gifting') }}">
                                                {{ getReplacedWordOfKudos() . __(' Admin Gifting') }}
                                            </x-jet-dropdown-link>

                                            <x-jet-dropdown-link href="{{ route('company.manage-invites') }}">
                                                {{ __('User Invitations') }}
                                            </x-jet-dropdown-link>

                                            <x-jet-dropdown-link href="{{ route('company.user-stats') }}">
                                                {{ __('User Statistics') }}
                                            </x-jet-dropdown-link>
                                        @endcan
                                    </div>
                                </x-slot>
                            </x-jet-dropdown>
                        </div>
                    </div>
                </div>
            @endif

        <!-- Responsive Settings Options -->
            <div class="hidden lg:block">
                <div class="pt-4 border-t border-gray-200">
                    <div class="flex items-center px-4">
                        @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                            <div class="flex-shrink-0 mr-3">
                                <img class="h-10 w-10 rounded-full object-cover"
                                     src="{{ Auth::user()->profile_photo_url }}"
                                     alt="{{ Auth::user()->name }}"/>
                            </div>
                        @endif

                        <div>
                            <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                            <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                        </div>
                    </div>

                    <div class="mt-3 space-y-1">
                        <div class="block px-4 py-2 text-xs text-gray-400">
                            {{ __('Manage Account') }}
                        </div>
                        <!-- Account Management -->
                        <x-jet-responsive-nav-link href="{{ route('profile') }}"
                                                   :active="request()->routeIs('profile')">
                            {{ __('View Profile') }}
                        </x-jet-responsive-nav-link>

                        <x-jet-responsive-nav-link href="{{ route('profile.show') }}"
                                                   :active="request()->routeIs('profile.show')">
                            {{ __('Manage Profile') }}
                        </x-jet-responsive-nav-link>

                        <x-jet-responsive-nav-link href="{{ route('help') }}"
                                                   :active="request()->routeIs('help')">
                            Help &amp; Support
                        </x-jet-responsive-nav-link>

                        @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                            <x-jet-responsive-nav-link href="{{ route('api-tokens.index') }}"
                                                       :active="request()->routeIs('api-tokens.index')">
                                {{ __('API Tokens') }}
                            </x-jet-responsive-nav-link>
                        @endif

                        @if(auth()->check() && auth()->user()->can('is_developer_user'))
                            <x-jet-responsive-nav-link href="{{ route('developer.show') }}"
                                                       :active="request()->routeIs('developer.show')">
                                {{ __('Developer') }}
                            </x-jet-responsive-nav-link>
                        @endif

                        <div class="border-t border-gray-200"></div>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-jet-responsive-nav-link href="{{ route('logout') }}"
                                                       onclick="event.preventDefault();
                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-jet-responsive-nav-link>
                        </form>

                        <!-- Team Management -->
                        @if (Laravel\Jetstream\Jetstream::hasTeamFeatures())
                            <div class="border-t border-gray-200"></div>

                            <div class="block px-4 py-2 text-xs text-gray-400">
                                {{ __('Build Teams') }}
                            </div>

                            <x-jet-responsive-nav-link href="{{ route('teams.manage') }}">
                                {{ __('Team Management') }}
                            </x-jet-responsive-nav-link>

                            @if (Auth::user()->hasTeams() && Auth::user()->currentTeam)
                                <x-jet-responsive-nav-link
                                    href="{{ route('teams.show', data_get(Auth::user()->currentTeam, 'id')) }}"
                                    :active="request()->routeIs('teams.show')">
                                    {{ __('Team Settings') }}
                                </x-jet-responsive-nav-link>
                            @endif
                        @endif

                        @can('create', Laravel\Jetstream\Jetstream::newTeamModel())
                            <x-jet-responsive-nav-link href="{{ route('teams.create') }}"
                                                       :active="request()->routeIs('teams.create')">
                                {{ __('Create New Team') }}
                            </x-jet-responsive-nav-link>
                        @endcan

                        <div class="border-t border-gray-200"></div>

                        <!-- Team Switcher -->
                        @if (Auth::user()->hasTeams())
                        <!-- Team Switcher -->
                            <div class="block px-4 py-2 text-xs text-gray-400">
                                {{ __('Modify Team Settings') }}
                            </div>

                            @foreach (Auth::user()->allTeams() as $team)
                                <x-jet-switchable-team :team="$team" component="jet-responsive-nav-link"/>
                            @endforeach
                        @endif

                        <div class="border-t border-gray-200"></div>

                        <div class="block px-4 py-2 text-xs text-gray-400">
                            {{ __('Settings') }}
                        </div>

                        <!-- Kudos Settings -->
                        @if (Gate::check('refil_kudos', Auth::user()) && Auth::user()->currentTeam)
                            <x-jet-dropdown-link
                                href="{{ route('manage.company', data_get(Auth::user()->currentTeam, 'id')) }}">
                                {{ __('Kudos Settings') }}
                            </x-jet-dropdown-link>
                        @endif

                        @if (Gate::check('add_adminUser', Auth::user()))
                            <x-jet-dropdown-link href="{{ route('manage.company.create_user', 'superduper') }}">
                                {{ __('Add Admin User') }}
                            </x-jet-dropdown-link>
                        @endif
                    </div>
                </div>
            </div>

            {{--            mobile --}}
            <div class="lg:hidden block space-y-1">
                {{--                <div x-data="{show: false}" class="mt-1 cursor-pointer">--}}
                {{--                    <x-jet-responsive-nav-link @click="show = !show"--}}
                {{--                                               :active="request()->routeIs('manage.company') || request()->routeIs('company.manage.users')">--}}
                {{--                        @if(Auth::user()->company->logo_path)--}}
                {{--                            <div class="flex items-center">--}}
                {{--                                @if (Auth::user()->role == 1)--}}
                {{--                                    <svg class="mr-1 h-4 w-4" xmlns="http://www.w3.org/2000/svg"--}}
                {{--                                         viewBox="0 0 20 20" fill="currentColor">--}}
                {{--                                        <path fill-rule="evenodd"--}}
                {{--                                              d="M10 3a1 1 0 01.707.293l3 3a1 1 0 01-1.414 1.414L10 5.414 7.707 7.707a1 1 0 01-1.414-1.414l3-3A1 1 0 0110 3zm-3.707 9.293a1 1 0 011.414 0L10 14.586l2.293-2.293a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z"--}}
                {{--                                              clip-rule="evenodd"/>--}}
                {{--                                    </svg>--}}
                {{--                                @endif--}}

                {{--                                <img class="object-contain h-8"--}}
                {{--                                     src="{!! Auth::user()->company->logo_path !!}"--}}
                {{--                                     alt="{{ substr(Auth::user()->company->name, 0, 20) }}"/>--}}

                {{--                                <span class="ml-2">--}}
                {{--                                    {{ __('Manage ')}}  {{(' Settings') }}--}}
                {{--                                </span>--}}
                {{--                            </div>--}}
                {{--                        @else--}}
                {{--                            {{ substr(Auth::user()->company->name, 0, 20) }}--}}
                {{--                        @endif--}}
                {{--                    </x-jet-responsive-nav-link>--}}

                {{--                    <div class="ml-6 w-60" x-show="show">--}}
                {{--                        @if (Auth::user()->role == 1)--}}
                {{--                            <div class="border-t border-gray-100"></div>--}}

                {{--                            <x-jet-responsive-nav-link href="{{ route('manage.company') }}">--}}
                {{--                                Company {{ __(' Settings') }}--}}
                {{--                            </x-jet-responsive-nav-link>--}}

                {{--                            <x-jet-responsive-nav-link href="{{ route('company.manage.users') }}">--}}
                {{--                                {{ __('Manage ')}} {{(' Users') }}--}}
                {{--                            </x-jet-responsive-nav-link>--}}

                {{--                            <x-jet-responsive-nav-link href="{{ route('company.manage-invites') }}">--}}
                {{--                                {{ __('User Invitations') }}--}}
                {{--                            </x-jet-responsive-nav-link>--}}

                {{--                            <x-jet-responsive-nav-link href="{{ route('rewards.company') }}">--}}
                {{--                                {{ __('Manage Rewards') }}--}}
                {{--                            </x-jet-responsive-nav-link>--}}
                {{--                        @endif--}}
                {{--                    </div>--}}
                {{--                </div>--}}
                @can('access_admin_controls')
                    <div x-data="{show: false}" class="cursor-pointer">
                        <x-jet-responsive-nav-link
                            @click="show = !show"
                            class="flex items-center"
                            :active="request()->routeIs('manage.company', 'company.manage.users', 'company.manage-invites', 'rewards.company', 'rewards.company-stats', 'company.user-stats')"
                            activeClass="gray"
                        >
                            <svg class="mr-1 h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                 viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                      d="M10 3a1 1 0 01.707.293l3 3a1 1 0 01-1.414 1.414L10 5.414 7.707 7.707a1 1 0 01-1.414-1.414l3-3A1 1 0 0110 3zm-3.707 9.293a1 1 0 011.414 0L10 14.586l2.293-2.293a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z"
                                      clip-rule="evenodd"/>
                            </svg>

                            User Management
                        </x-jet-responsive-nav-link>

                        <div class="ml-6 w-60" x-show="show">
                            <x-jet-responsive-nav-link
                                href="{{ route('company.manage.users') }}"
                                :active="request()->routeIs('company.manage.users')">
                                {{ __('Manage ')}} {{(' Users') }}
                            </x-jet-responsive-nav-link>

                            <x-jet-responsive-nav-link
                                href="{{ route('admin.kudos-gifting') }}"
                                :active="request()->routeIs('admin.kudos-gifting')">
                                {{ getReplacedWordOfKudos() . __(' Admin Gifting') }}
                            </x-jet-responsive-nav-link>

                            <x-jet-responsive-nav-link
                                href="{{ route('company.manage-invites') }}"
                                :active="request()->routeIs('company.manage-invites')">
                                {{ __('User Invitations') }}
                            </x-jet-responsive-nav-link>

                            <x-jet-responsive-nav-link
                                href="{{ route('company.user-stats') }}"
                                :active="request()->routeIs('company.user-stats')">
                                {{ __('User Statistics') }}
                            </x-jet-responsive-nav-link>
                        </div>
                    </div>

                    <div x-data="{show: false}" class="cursor-pointer">
                        <x-jet-responsive-nav-link
                            @click="show = !show"
                            class="flex items-center"
                            :active="request()->routeIs('dashboard', 'billing')"
                            activeClass="gray"
                        >
                            <svg class="mr-1 h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                 viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                      d="M10 3a1 1 0 01.707.293l3 3a1 1 0 01-1.414 1.414L10 5.414 7.707 7.707a1 1 0 01-1.414-1.414l3-3A1 1 0 0110 3zm-3.707 9.293a1 1 0 011.414 0L10 14.586l2.293-2.293a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z"
                                      clip-rule="evenodd"/>
                            </svg>

                            Reward Management
                        </x-jet-responsive-nav-link>

                        <div class="ml-6 w-60" x-show="show">
                            <x-jet-responsive-nav-link
                                href="{{ route('rewards.company', ['currency' => auth()->user()->currency]) }}"
                                :active="request()->routeIs('rewards.company')">
                                {{ __('Manage Rewards') }}
                            </x-jet-responsive-nav-link>

                            <x-jet-responsive-nav-link
                                href="{{ route('rewards.company-stats') }}"
                                :active="request()->routeIs('rewards.company-stats')">
                                {{ __('Reward Statistics') }}
                            </x-jet-responsive-nav-link>
                        </div>
                    </div>

                    <div x-data="{show: false}" class="cursor-pointer">
                        <x-jet-responsive-nav-link
                            @click="show = !show"
                            class="flex items-center"
                            :active="request()->routeIs('dashboard', 'billing')"
                            activeClass="gray"
                        >
                            <svg class="mr-1 h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                 viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                      d="M10 3a1 1 0 01.707.293l3 3a1 1 0 01-1.414 1.414L10 5.414 7.707 7.707a1 1 0 01-1.414-1.414l3-3A1 1 0 0110 3zm-3.707 9.293a1 1 0 011.414 0L10 14.586l2.293-2.293a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z"
                                      clip-rule="evenodd"/>
                            </svg>

                            {{ __('Analytics & Billing') }}
                        </x-jet-responsive-nav-link>

                        <div class="ml-6 w-60" x-show="show">
                            <x-jet-responsive-nav-link
                                href="{{ route('dashboard') }}"
                                :active="request()->routeIs('dashboard')">
                                {{ __('Activity Dashboard') }}
                            </x-jet-responsive-nav-link>

                            <x-jet-responsive-nav-link
                                href="{{ route('billing') }}"
                                :active="request()->routeIs('billing')">
                                {{ __('Billing Dashboard') }}
                            </x-jet-responsive-nav-link>
                        </div>
                    </div>

                    <div x-data="{show: false}" class="cursor-pointer">
                        <x-jet-responsive-nav-link
                            @click="show = !show"
                            class="flex items-center"
                            :active="request()->routeIs('dashboard', 'billing')"
                            activeClass="gray"
                        >
                            <svg class="mr-1 h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                 viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                      d="M10 3a1 1 0 01.707.293l3 3a1 1 0 01-1.414 1.414L10 5.414 7.707 7.707a1 1 0 01-1.414-1.414l3-3A1 1 0 0110 3zm-3.707 9.293a1 1 0 011.414 0L10 14.586l2.293-2.293a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z"
                                      clip-rule="evenodd"/>
                            </svg>

                            {{ __('Company Customization') }}
                        </x-jet-responsive-nav-link>

                        <div class="ml-6 w-60" x-show="show">
                            <x-jet-responsive-nav-link
                                href="{{ route('manage.company') }}"
                                :active="request()->routeIs('manage.company')">
                                {{('Company Settings') }}
                            </x-jet-responsive-nav-link>

                            @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                                <x-jet-responsive-nav-link
                                    href="{{ route('api-tokens.index') }}"
                                    :active="request()->routeIs('api-tokens.index')">
                                    {{ __('API Tokens') }}
                                </x-jet-responsive-nav-link>
                            @endif
                        </div>
                    </div>
                @endcan


                @if (Laravel\Jetstream\Jetstream::hasTeamFeatures())
                    <div x-data="{show: false}" class="cursor-pointer">
                        <!-- Team Management -->
                        <x-jet-responsive-nav-link
                            @click="show = !show"
                            class="flex items-center"
                            :active="request()->routeIs('teams.manage', 'teams.create')"
                            activeClass="gray"
                        >
                            <svg class="mr-1 h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                 viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                      d="M10 3a1 1 0 01.707.293l3 3a1 1 0 01-1.414 1.414L10 5.414 7.707 7.707a1 1 0 01-1.414-1.414l3-3A1 1 0 0110 3zm-3.707 9.293a1 1 0 011.414 0L10 14.586l2.293-2.293a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z"
                                      clip-rule="evenodd"/>
                            </svg>

                            {{ __('Build Teams') }}
                        </x-jet-responsive-nav-link>

                        <div class="ml-6 w-60" x-show="show">
                            <x-jet-responsive-nav-link :active="request()->routeIs('teams.manage')"
                                                       href="{{ route('teams.manage') }}">
                                {{ __('Team Management') }}
                            </x-jet-responsive-nav-link>

                            @can('create', Laravel\Jetstream\Jetstream::newTeamModel())
                                <x-jet-responsive-nav-link href="{{ route('teams.create') }}"
                                                           :active="request()->routeIs('teams.create')">
                                    {{ __('Create New Team') }}
                                </x-jet-responsive-nav-link>
                            @endcan
                        </div>
                    </div>
                @endif

                @if (Auth::user()->hasTeams())
                    <div x-data="{show: false}" class="cursor-pointer">
                        <!-- Team Switcher -->
                        <x-jet-responsive-nav-link
                            @click="show = !show"
                            class="flex items-center"
                            :active="preg_match('/^teams\/[0-9]+$/', request()->path())"
                            activeClass="gray"
                        >
                            <svg class="mr-1 h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                 viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                      d="M10 3a1 1 0 01.707.293l3 3a1 1 0 01-1.414 1.414L10 5.414 7.707 7.707a1 1 0 01-1.414-1.414l3-3A1 1 0 0110 3zm-3.707 9.293a1 1 0 011.414 0L10 14.586l2.293-2.293a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z"
                                      clip-rule="evenodd"/>
                            </svg>

                            {{ __('Modify Team Settings') }}
                        </x-jet-responsive-nav-link>

                        <div class="ml-6 w-60" x-show="show">
                            @foreach (Auth::user()->allTeams() as $team)
                                <x-jet-switchable-team :team="$team" component="jet-responsive-nav-link"/>
                            @endforeach
                        </div>
                    </div>
                @endif

                @if((Gate::check('refil_kudos', Auth::user()) && Auth::user()->currentTeam) || Gate::check('add_adminUser', Auth::user()))
                    <div x-data="{show: false}" class="cursor-pointer">
                        <x-jet-responsive-nav-link
                            @click="show = !show"
                            :active="request()->routeIs('manage.company', 'manage.company.create_user')"
                            activeClass="gray"
                        >
                            {{ __('Settings') }}
                        </x-jet-responsive-nav-link>

                        <div class="ml-6 w-60" x-show="show">
                            <!-- Kudos Settings -->
                            @if (Gate::check('refil_kudos', Auth::user()) && Auth::user()->currentTeam)
                                <x-jet-dropdown-link
                                    href="{{ route('manage.company', data_get(Auth::user()->currentTeam, 'id')) }}">
                                    {{ __('Kudos Settings') }}
                                </x-jet-dropdown-link>
                            @endif

                            @if (Gate::check('add_adminUser', Auth::user()))
                                <x-jet-dropdown-link href="{{ route('manage.company.create_user', 'superduper') }}">
                                    {{ __('Add Admin User') }}
                                </x-jet-dropdown-link>
                            @endif
                        </div>
                    </div>
                @endif

                <div x-data="{show: false}" class="cursor-pointer">
                    <x-jet-responsive-nav-link
                        class="flex items-center"
                        @click="show = !show"
                        :active="request()->routeIs('profile', 'profile.show', 'help', 'developer.show', 'api-tokens.index')"
                        activeClass="gray"
                    >
                        <svg class="mr-1 h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                             viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                  d="M10 3a1 1 0 01.707.293l3 3a1 1 0 01-1.414 1.414L10 5.414 7.707 7.707a1 1 0 01-1.414-1.414l3-3A1 1 0 0110 3zm-3.707 9.293a1 1 0 011.414 0L10 14.586l2.293-2.293a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z"
                                  clip-rule="evenodd"/>
                        </svg>

                        @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                            <div class="flex items-center">
                                <img class="h-8 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}"
                                     alt="{{ Auth::user()->name }}"/>

                                <span class="ml-2">{{Auth::user()->name}}</span>
                                {{--                            {{ __('Manage Account') }}--}}
                            </div>
                        @else
                            <div class="flex items-center">
                                <span class="ml-2">{{Auth::user()->name}}</span>
                                {{--                            {{ __('Manage Account') }}--}}
                            </div>
                        @endif
                    </x-jet-responsive-nav-link>

                    <div class="ml-6 w-60" x-show="show">
                        <!-- Account Management -->
                        <x-jet-responsive-nav-link href="{{ route('profile') }}"
                                                   :active="request()->routeIs('profile')">
                            {{ __('View Profile') }}
                        </x-jet-responsive-nav-link>

                        <x-jet-responsive-nav-link href="{{ route('profile.show') }}"
                                                   :active="request()->routeIs('profile.show')">
                            {{ __('Manage Profile') }}
                        </x-jet-responsive-nav-link>

                        <x-jet-responsive-nav-link href="{{ route('help') }}"
                                                   :active="request()->routeIs('help')">
                            Help &amp; Support
                        </x-jet-responsive-nav-link>

                        @if(auth()->check() && auth()->user()->can('is_developer_user'))
                            <x-jet-responsive-nav-link href="{{ route('developer.show') }}"
                                                       :active="request()->routeIs('developer.show')">
                                {{ __('Developer') }}
                            </x-jet-responsive-nav-link>
                        @endif

                    <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-jet-responsive-nav-link href="{{ route('logout') }}"
                                                       onclick="event.preventDefault();this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-jet-responsive-nav-link>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </nav>
@endif
