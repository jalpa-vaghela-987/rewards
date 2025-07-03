<div>
    <div class="sm:p-8 bg-white my-4">
        <form wire:submit.prevent="mark">
            <div class="md:flex">
                <div class="col-span-6 sm:col-span-4 md:w-2/3 mr-3">
                    <x-jet-label for="reward_string" value="{{ __('Mark Reward as Sent') }}"/>
                    <x-jet-input id="reward_string" type="text" min="10" max="500" class="mt-1 block w-full"
                                 wire:model="reward_string" placeholder="Unique Redemption Code"/>
                    <x-jet-input-error for="reward_string" class="mt-2"/>
                </div>
                <x-jet-action-message class="mr-3 text-green-500 xs:block lg:hidden" on="saved">
                    {{ __('Saved.') }}
                </x-jet-action-message>

                <x-jet-action-message class="mr-3 text-red-500 xs:block lg:hidden" on="not_found">
                    {{ __('Invalid unique redemption code.') }}
                </x-jet-action-message>
                <x-jet-action-message class="mr-3 text-red-500 xs:block lg:hidden" on="null">
                    {{ __('The Unique Redemption Code field is required.') }}
                </x-jet-action-message>
                <div class="col-span-6 sm:col-span-4">
                    <div class="h-5"></div>

                    <x-jet-button class="my-2 mt-2" style="background: #10B981;">
                        {{ __('Mark as Sent') }}
                    </x-jet-button>
                </div>
            </div>

            <x-jet-action-message class="mr-3 text-green-500 lg:hidden" on="saved">
                {{ __('Saved.') }}
            </x-jet-action-message>

            <x-jet-action-message class="mr-3 text-red-500 xs:hidden" on="not_found">
                {{ __('Invalid unique redemption code.') }}
            </x-jet-action-message>
            <x-jet-action-message class="mr-3 text-red-500 xs:hidden" on="null">
                {{ __('The Unique Redemption Code field is required.') }}
            </x-jet-action-message>

            <x-jet-action-message class="mr-3 text-red-500" on="marked_already">
                {{ __('This reward is already marked as sent.') }}
            </x-jet-action-message>
            <x-jet-action-message class="mr-3 text-red-500" on="denied">
                {{ __('This reward is already denied.') }}
            </x-jet-action-message>
            <x-jet-action-message class="mr-3 text-red-500" on="pending">
                {{ __('This reward is pending.') }}
            </x-jet-action-message>
        </form>

        <div name="description">
            <div class="grid grid-cols-12 w-full my-5 py-3 rounded">
                <h3 class="text-lg col-start-1 col-span-12 mb-3 italic pb-2">
                    Outstanding Reward Redemptions
                </h3>

                <div class="col-span-12 grid grid-cols-12 hidden sm:grid">
                    <div class="col-start-1 col-span-1 mx-1 text-left sm:text-xs md:text-xs lg:text-sm font-semibold py-1">
                        Recipient Name
                    </div>

                    <div class="col-start-2 col-span-1 mx-1 sm:text-xs font-semibold md:text-xs lg:text-sm text-center  py-1">
                        Reward Title
                    </div>

                    <div class="col-start-3 col-span-2 mx-1 sm:text-xs md:text-xs text-center lg:text-sm font-semibold py-1">
                        Status <br> <span class="italic font-normal">(Hover to Change)</span>
                    </div>

                    <div class="col-start-5 col-span-1 mx-1 sm:text-xs md:text-sm text-center lg:text-sm font-semibold py-1">
                        Approval
                    </div>

                    <div class="col-start-6 col-span-2 mx-1 sm:text-xs md:text-xs text-center lg:text-sm font-semibold py-1">
                        Unique Redemption Code
                    </div>
                    <div class="col-start-8 col-span-1 mx-1 sm:text-xs md:text-xs text-center lg:text-sm font-semibold py-1">
                        {{ getReplacedWordOfKudos()}}
                    </div>
                    <div class="col-start-9 col-span-1 mx-1 sm:text-xs md:text-xs text-center lg:text-sm font-semibold py-1">
                        Amount
                    </div>
                    <div class="col-start-10 col-span-1 mx-1 sm:text-xs md:text-xs text-center lg:text-sm font-semibold py-1">
                        Currency
                    </div>

                    <div class="col-start-11 col-span-1 mx-1 sm:text-xs md:text-xs text-left lg:text-sm font-semibold py-1">
                        Purchase Date
                    </div>

                    <div class="col-start-1 col-span-12 border-b border-gray-500 mb-1"></div>

                    @forelse($redemptions->where('is_pending',1)->take(10) as $r)

                        <div class="col-start-1 col-span-1 mx-1 text-left text-sm  py-1">
                            {{ $r->user->name }}
                        </div>

                        <div class="col-start-2 col-span-1 mx-1 text-sm text-blue-600 text-center py-1 truncate">
                            <a href="/redemption/{{$r->id}}">
                                {{ data_get(json_decode($r->data), 'title') }}
                            </a>
                        </div>

                        <div class="col-start-3 col-span-2  mx-1 text-sm text-center py-1">

                            @if(!($r->marked_as_unable_to_furfill || $r->is_rejected) && !$r->is_pending)
                                <div class="@if($r->confirmed_reciept) text-green-500 @else text-red-500 @endif">
                                    @if($r->confirmed_reciept)
                                        @if($r->tango_order_id)
                                            <x-clear-link-button
                                                class="bg-white py-0">
                                                <div class="w-full">
                                                    <span class="text-purple-800">Sent</span>
                                                </div>
                                            </x-clear-link-button>
                                        @else
                                        <x-clear-link-button class="bg-white hover:bg-red-500 hover:text-white py-0"
                                                             onmouseover="$(this).find('span').first().show(0); $(this).find('span').first().next().hide(0);"
                                                             onmouseout="$(this).find('span').first().hide(0); $(this).find('span').first().next().show(0);"
                                                             wire:click="toggleReceipt({{$r->id}})">
                                            <div class="w-full">
                                                <span class="text-white hidden">Mark as Not Sent</span>
                                                <span class="text-green-500">Sent</span>
                                            </div>
                                        </x-clear-link-button>
                                        @endif
                                    @else
                                        <x-clear-link-button class="bg-gray-50 hover:bg-green-500 hover:text-white py-0"
                                                             onmouseover="$(this).find('span').first().show(0); $(this).find('span').first().next().hide(0);"
                                                             onmouseout="$(this).find('span').first().hide(0); $(this).find('span').first().next().show(0);"
                                                             wire:click="toggleReceipt({{$r->id}})">
                                            <div class="w-full">
                                                <span class="text-white hidden">Mark as Sent</span>
                                                <span class="text-red-500">Not Sent</span>
                                            </div>
                                        </x-clear-link-button>
                                    @endif
                                </div>
                            @elseif($r->is_pending)
                                <x-clear-link-button
                                    class="bg-white  py-0">
                                    <span class="text-gray-500">Pending</span>
                                </x-clear-link-button>
                            @elseif($r->is_rejected ||$r->marked_as_unable_to_furfill)
                                <x-clear-link-button class="bg-gray-50 py-0 disabled bg-gray-300 text-black cursor-not-allowed" disabled>
                                    Denied
                                </x-clear-link-button>
                            @else
                                <div>
                                    -
                                </div>
                            @endif
                        </div>

                        <div class="col-start-5 col-span-1 mx-1 text-sm text-center py-1">
                            @if($r->is_pending)
                                <div class="space-x-4" wire:loading.class="opacity-25 disabled cursor-not-allowed">
                                    <span wire:click="rejectingRewardRequest({{ $r->id }})">
                                        <i class="fa fa-times-circle text-red-700 text-2xl cursor-pointer tooltip pl-1"
                                           title="Deny Reward"
                                           wire:loading.class="cursor-not-allowed"></i>
                                    </span>

                                    <span wire:click="approvingRewardRequest({{ $r->id }})">
                                        <i class="fa fa-check-circle text-green-700 text-2xl cursor-pointer tooltip pr-3"
                                           title="Approve Reward"
                                           wire:loading.class="cursor-not-allowed"></i>
                                    </span>
                                </div>
                            @else
                                @if($r->is_rejected || $r->marked_as_unable_to_furfill)
                                    <span class="wrapper">
                                        <i class="fa fa-times-circle text-red-700 text-2xl opacity-50"></i>
                                        <div class="tooltip-text">
                                            {{ $r->is_rejected ? 'Rejected' : 'Unable to Fulfill' }}
                                        </div>
                                    </span>
                                @else
                                    <span class="wrapper">
                                        <i class="fa fa-check-circle text-green-700 text-2xl opacity-75"></i>
                                        <div class="tooltip-text">Processed</div>
                                    </span>
                                @endif
                            @endif
                        </div>

                        <div class="col-start-6 col-span-2 mx-1 text-sm text-center  py-1">
                            {{$r->redemption_code}}
                        </div>
                        <div class="col-start-8 col-span-1 mx-1 text-sm text-center  py-1">
                            {{strlen($r->cost) <= 3  ? $r->cost : substr($r->cost, 0, -3) . ',' . substr($r->cost, -3)}}
                        </div>
                        <div class="col-start-9 col-span-1 mx-1 text-sm text-center  py-1">
                            {{$r->is_custom ? 1 : $r->value}}
                        </div>

                        @if(
                        json_decode($r->data) !== null
                        &&
                        json_decode($r->data)->tango_data !== null
                        )

                            <div class="col-start-10 col-span-1 mx-1 text-sm text-center  py-1">

                                {{json_decode(json_decode($r->data)->tango_data)->items[0]->currencyCode ?? $r->currency}}
                            </div>
                        @else

                            <div class="col-start-10 col-span-1 mx-1 text-sm text-center  py-1">
                                {{ $r->currency }}
                            </div>
                        @endif
                        <div class="col-start-11 col-span-4 mx-1 italic text-xs text-right sm:text-right md:text-left lg:text-left py-1">
                            {{ Timezone::convertToLocal($r->created_at, 'F jS, Y \- g:i A') }}
                        </div>

                        <div class="col-start-1 col-span-12 border-b border-gray-300 border-dashed mb-1"></div>
                    @empty
                        <div class="col-start-1 col-span-12 border-b border-gray-300 text-gray-500 border-dashed mb-1">
                            No Custom Reward Redemptions
                        </div>
                    @endforelse

                    <p class="col-start-1 col-span-12 border-t border-gray-400 mt-1"></p>

                    <a class="w-max col-start-1 col-span-12 mb-1 italic text-blue-800 text-sm mt-1 pt-1" href="/reward-redemption">
                        View Full Reward Redemption History
                    </a>
                </div>

                <div class="col-span-12 block sm:hidden overflow-auto">
                {{--                    variant 1: cards--}}
                    @forelse($redemptions->where('is_pending',1)->take(3) as $r)
                        <table class="w-full rounded mb-4 border border-gray-300 border-collapse">
                            <tbody class="flex-1">
                                <tr class="border">
                                    <td class="w-1/3 p-2.5 text-left text-sm font-semibold">Recipient Name</td>
                                    <td class="text-left text-sm">{{ $r->user->name }}</td>
                                </tr>

                                <tr class="border">
                                    <td class="w-1/3 p-2.5 text-left text-sm font-semibold">Reward Title</td>
                                    <td class="text-blue-600 text-left truncate" style="font-size: 0.750rem;line-height: 1.25rem;">
                                        <a href="/redemption/{{ $r->id }} truncate">{{ data_get(json_decode($r->data), 'title') }}</a>
                                    </td>
                                </tr>

                                <tr class="border">
                                    <td class="w-1/3 p-2.5 text-left text-sm font-semibold">Status <span class="italic font-normal">(Hover to Change)</span></td>
                                    <td class="text-left text-sm">
                                        @if(!($r->marked_as_unable_to_furfill || $r->is_rejected) && !$r->is_pending)
                                            <div class="@if($r->confirmed_reciept) text-green-500 @else text-red-500 @endif">
                                                @if($r->confirmed_reciept)
                                                    @if($r->tango_order_id)
                                                        <x-clear-link-button
                                                            class="bg-white  py-0">
                                                            <div class="w-full">
                                                                <span class="text-purple-800">Sent</span>
                                                            </div>
                                                        </x-clear-link-button>
                                                    @else

                                                    <x-clear-link-button class="bg-white hover:bg-red-500 hover:text-white py-0"
                                                                         onmouseover="$(this).find('span').first().show(0); $(this).find('span').first().next().hide(0);"
                                                                         onmouseout="$(this).find('span').first().hide(0); $(this).find('span').first().next().show(0);"
                                                                         wire:click="toggleReceipt({{$r->id}})">
                                                        <div class="w-full">
                                                            <span class="text-white hidden">Mark as Not Sent</span>
                                                            <span class="text-green-500">Sent</span>
                                                        </div>
                                                    </x-clear-link-button>
                                                    @endif
                                                @else
                                                    <x-clear-link-button class="bg-gray-50 hover:bg-green-500 hover:text-white py-0"
                                                                         onmouseover="$(this).find('span').first().show(0); $(this).find('span').first().next().hide(0);"
                                                                         onmouseout="$(this).find('span').first().hide(0); $(this).find('span').first().next().show(0);"
                                                                         wire:click="toggleReceipt({{$r->id}})">
                                                        <div class="w-full">
                                                            <span class="text-white hidden">Mark as Sent</span>
                                                            <span class="text-red-500">Not Sent</span>
                                                        </div>
                                                    </x-clear-link-button>
                                                @endif
                                            </div>
                                        @elseif($r->is_pending)
                                            <x-clear-link-button
                                                class="bg-white  py-0">
                                                <span class="text-gray-500">Pending</span>
                                            </x-clear-link-button>
                                        @elseif($r->is_rejected ||$r->marked_as_unable_to_furfill)
                                            <x-clear-link-button class="bg-gray-50 py-0 disabled bg-gray-300 text-black cursor-not-allowed" disabled>
                                                Denied
                                            </x-clear-link-button>
                                        @else
                                            <div>
                                                -
                                            </div>
                                        @endif
                                    </td>
                                </tr>

                                <tr class="border">
                                    <td class="w-1/3 p-2.5 text-left text-sm font-semibold">Approval</td>
                                    <td class="text-sm text-blue-600 text-left truncate">
                                        @if($r->is_pending)
                                            <div class="space-x-4" wire:loading.class="opacity-25 disabled cursor-not-allowed">
                                                <span wire:click="rejectingRewardRequest({{ $r->id }})">
                                                    <i class="fa fa-times-circle text-red-700 text-2xl cursor-pointer tooltip"
                                                       title="Deny Reward"
                                                       wire:loading.class="cursor-not-allowed"
                                                    ></i>
                                                </span>

                                                <span wire:click="approvingRewardRequest({{ $r->id }})">
                                                    <i class="fa fa-check-circle text-green-700 text-2xl cursor-pointer tooltip"
                                                       wire:loading.class="cursor-not-allowed"
                                                       title="Approve Reward"
                                                    ></i>
                                                </span>
                                            </div>
                                        @else
                                            @if($r->is_rejected || $r->marked_as_unable_to_furfill)
                                                <span class="wrapper">
                                                    <i class="fa fa-times-circle text-red-700 text-2xl opacity-50"></i>
                                                    <div class="tooltip-text">
                                                        {{ $r->is_rejected ? 'Rejected' : 'Unable to Fulfill' }}
                                                    </div>
                                                </span>
                                            @else
                                                <span class="wrapper">
                                                    <i class="fa fa-check-circle text-green-700 text-2xl opacity-75"></i>
                                                    <div class="tooltip-text">Processed</div>
                                                </span>
                                            @endif
                                        @endif
                                    </td>
                                </tr>

                                <tr class="border">
                                    <td class="w-1/3 p-2.5 text-left text-sm font-semibold">Unique Redemption Code</td>
                                    <td class="text-left text-sm ">{{ $r->redemption_code }}</td>
                                </tr>

                                <tr class="border">
                                    <td class="w-1/3 p-2.5 text-left text-sm font-semibold">Purchase Date</td>
                                    <td class="text-left text-sm italic">{{ Timezone::convertToLocal($r->created_at, 'F jS, Y \- g:i A') }}</td>
                                </tr>
                            </tbody>
                        </table>
                    @empty
                        <div class="col-start-1 col-span-12 border-b border-gray-300 border-dashed mb-1 text-gray-500">
                            No Custom Reward Redemptions
                        </div>
                    @endforelse

                    @if(count($redemptions))
                        <a class="w-full flex flex-row flex-no-wrap mb-1 italic text-blue-800 text-sm mt-8 pt-2 border-t border-gray-400" href="/reward-redemption">
                            View Full Reward Redemption History
                        </a>
                    @endif
                </div>
            </div>
        </div>

        <x-jet-modal wire:model="showRejectingModel" wire:click.away="resetRejectionModel()">
            <div class="p-4">
                <div class="text-lg">
                    {{ __('Card Redemption Request') }}
                </div>

                <div class="w-full mt-4">
                    <x-jet-label>Please provide rejection reason:</x-jet-label>

                    <x-text-area wire:model.defer="rejectionReason" class="w-full mt-2" rows="5"></x-text-area>

                    <x-jet-input-error for="rejectionReason"/>
                </div>

                <div class="flex justify-end w-full space-x-3 mt-5">
                    <x-jet-secondary-button wire:click="resetRejectionModel()">Cancel</x-jet-secondary-button>

                    <x-jet-button wire:click="rejectRedemptionRequest()">Reject</x-jet-button>
                </div>
            </div>
        </x-jet-modal>

        <x-jet-confirmation-modal wire:model="showApprovingModel" maxWidth="sm" wire:click.away="resetApprovingModel()">
            <x-slot name="title">
                {{ __('Approve Request') }}
            </x-slot>

            <x-slot name="content">
                {{ __('Are you sure you would like to approve redemption request?') }}
            </x-slot>

            <x-slot name="footer">
                <x-jet-secondary-button wire:click="resetApprovingModel()" wire:loading.attr="disabled">
                    {{ __('Nevermind') }}
                </x-jet-secondary-button>

                <x-jet-danger-button class="ml-2" wire:click="approveRewardRequest()" wire:loading.attr="disabled">
                    {{ __('Approve') }}
                </x-jet-danger-button>
            </x-slot>
        </x-jet-confirmation-modal>

{{--        <x-jet-modal wire:model="showApprovingModel" maxWidth="sm" wire:click.away="resetApprovingModel()">--}}
{{--            <div class="p-4">--}}
{{--                <div class="text-lg">--}}
{{--                    {{ __('Approve Request') }}--}}
{{--                </div>--}}

{{--                <div class="w-full mt-4">--}}
{{--                    <x-jet-label>Are You Sure?</x-jet-label>--}}
{{--                </div>--}}

{{--                <div class="flex justify-end w-full space-x-3 mt-8">--}}
{{--                    <x-jet-secondary-button wire:click="resetApprovingModel()">Cancel</x-jet-secondary-button>--}}

{{--                    <x-jet-button wire:click="approveRewardRequest()">Approve</x-jet-button>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </x-jet-modal>--}}
    </div>
</div>
