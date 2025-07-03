<div class="relative" style="">
    <x-jet-dropdown align="right" width="60" dropdownClasses="notification-drop">
        <x-slot name="trigger">
            <div class="inline-flex rounded-md">
                <button type="button"
                        class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150"
                        wire:click.debounce.debounce.4000ms="open">
                    @if($unreadCount > 0)
                        <span class="mdl-badge material-icons count_icon text-red-500" data-badge="{{$unreadCount}} ">notifications_active</span>
                    @else
                        <span class="mdl-badge material-icons no_notifications">notifications_none</span>
                    @endif
                </button>
            </div>
        </x-slot>

        <x-slot name="content">
            <!-- Account Management -->
            <div class="block px-4 py-2 text-xs text-gray-400" wire:loading.attr="showing">
                {{ __('Recent Notifications') }}
            </div>

            @foreach($unread as $n)
                <a class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out"
                   href="{{ url($n->data['link']) }}"
                   style="
                        word-break: break-word;
                        overflow: hidden;
                        text-overflow: ellipsis;
                        line-height: 16px;
                        max-height: 58px;
                        display: -webkit-box;
                        -webkit-line-clamp: 3;
                        -webkit-box-orient: vertical;
                ">
                    {{$n->data["tagline"]}}
                </a>
            @endforeach
            <div class="border-t border-gray-200"></div>
            <x-jet-dropdown-link href="{{ url('notifications')}}" class="text-sm text-gray-400">
                View All Notifications
            </x-jet-dropdown-link>
        </x-slot>
    </x-jet-dropdown>
</div>

{{--<style>--}}
{{--    @media (max-width: 640px) {--}}
{{--        .notification-drop {--}}
{{--            width: 23rem !important;--}}
{{--        }--}}
{{--    }--}}

{{--    @media (min-width: 640px) {--}}
{{--        .notification-drop {--}}
{{--            width: 26rem !important;--}}
{{--        }--}}
{{--    }--}}

{{--    @media (min-width: 768px) {--}}
{{--        .notification-drop {--}}
{{--            width: 35rem !important;--}}
{{--        }--}}
{{--    }--}}
{{--</style>--}}


