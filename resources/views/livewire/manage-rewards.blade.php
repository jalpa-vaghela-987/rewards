<div class="container mx-auto px-4 py-10 md:py-12">
    <div class="p-8 bg-white my-10 border border-gray-300 rounded rounded-t-lg ">
        <div>
{{--            <div class="p-8 bg-white my-4">--}}
                <div name="description">
                    <div class="grid grid-cols-12 w-full my-5 py-3 rounded">
                        <h3 class="text-lg col-start-1 col-span-12 mb-3 italic pb-2">
                            Reward Redemptions
                            <a href="/export-reward">
                                <span class="text-lg float-right text-blue-700">
                                    <i class="fas fa-upload text-lg cursor-pointer  text-gray-700 "></i>
                                    Export
                                </span>
                            </a>
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

                            @forelse($rewards as $r)
                                <div class="col-start-1 col-span-1 mx-1 text-left text-sm py-1">
                                    {{ $r->user->name }}
                                </div>

                                <div class="col-start-2 col-span-1 mx-1 text-sm text-blue-600 text-left py-1 truncate">
                                    <a href="/redemption/{{$r->id}}">
                                        {{ data_get(json_decode($r->data), 'title') }}
                                    </a>
                                </div>

                                <div class="col-start-3 col-span-2 mx-1 text-sm text-center py-1">
                                    @if(!($r->marked_as_unable_to_furfill || $r->is_rejected) && !$r->is_pending)
                                        <div
                                            class="@if($r->confirmed_reciept) text-green-500 @else text-red-500 @endif">
                                            @if($r->confirmed_reciept)
                                                @if($r->tango_order_id)
                                                    <x-clear-link-button
                                                        class="bg-white  py-0">
                                                        <div class="w-full">
                                                            <span class="text-purple-800">Sent</span>
                                                        </div>
                                                    </x-clear-link-button>

                                                @else
                                                <x-clear-link-button
                                                    class="bg-white hover:bg-red-500 hover:text-white py-0"
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
                                                <x-clear-link-button
                                                    class="bg-gray-50 hover:bg-green-500 hover:text-white py-0"
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
                                    @elseif($r->is_pending )
                                        <x-clear-link-button class="bg-white  py-0">
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

                                <div class="col-start-5 col-span-1 mx-1 text-sm py-1 text-center">
                                    @if($r->is_pending)
                                        <div class="space-x-4"
                                             wire:loading.class="opacity-25 disabled cursor-not-allowed ">
                                            <span wire:click="rejectingRewardRequest({{ $r->id }})">
                                                <i class="fa fa-times-circle text-red-700 text-2xl cursor-pointer pl-1"
                                                   wire:loading.class="cursor-not-allowed"></i>
                                            </span>

                                            <span wire:click="approveRewardRequest({{ $r->id }})">
                                                <i class="fa fa-check-circle text-green-700 text-2xl cursor-pointer pr-3"
                                                   wire:loading.class="cursor-not-allowed"></i>
                                            </span>
                                        </div>
                                    @else
                                        @if($r->is_rejected || $r->marked_as_unable_to_furfill)
                                            <span class="text-center tooltip" title="{{ $r->is_rejected ? 'Rejected' : 'Unable to Fulfill' }}">
                                                <i class="fa fa-times-circle text-red-700 text-2xl opacity-50 "></i>
                                            </span>
                                        @else
                                            <span class="text-center tooltip" title="Processed">
                                                <i class="fa fa-check-circle text-green-700 text-2xl opacity-75 text-center"></i>
                                            </span>
                                        @endif
                                    @endif
                                </div>

                                <div class="col-start-6 col-span-2 mx-1 text-sm text-center  py-1">
                                    {{$r->redemption_code}}
                                </div>
                                <div class="col-start-8 col-span-1 mx-1 text-sm text-center  py-1">
                                    {{strlen($r->cost) <= 3 ? $r->cost : substr($r->cost, 0, -3) . ',' . substr($r->cost, -3)}}
                                </div>
                                <div class="col-start-9 col-span-1 mx-1 text-sm text-center  py-1">
                                    {{$r->value}}
                                </div>

                                {{--                                @if(isset(json_decode(json_decode($r->data)->tango_data)->items[0]->currencyCode) )--}}
                                {{--                                    <div class="col-start-10 col-span-1 mx-1 text-sm text-center  py-1">--}}
                                {{--                                        {{json_decode(json_decode($r->data)->tango_data)->items[0]->currencyCode}}--}}
                                {{--                                    </div>--}}
                                {{--                                @else--}}
                                <div class="col-start-10 col-span-1 mx-1 text-sm text-center  py-1">
                                    {{$r->currency}}
                                </div>
                                {{--                                @endif--}}

                                <div
                                    class="col-start-11 col-span-4 mx-1 italic text-xs text-right sm:text-right md:text-left lg:text-left py-1">
                                    {{ Timezone::convertToLocal($r->created_at, 'F jS, Y \- g:i A') }}
                                </div>

                                <div class="col-start-1 col-span-12 border-b border-gray-300 border-dashed mb-1"></div>
                            @empty
                                <div
                                    class="col-start-1 col-span-12 border-b border-gray-300 text-gray-500 border-dashed mb-1">
                                    No Custom Reward Redemptions
                                </div>
                            @endforelse

                        </div>

                        <div class="col-span-12 block sm:hidden">
                            {{--                    variant 1: cards--}}
                            @forelse($rewards as $r)
                                <table class="w-full flex flex-row flex-no-wrap rounded overflow-hidden mb-4 border border-gray-300 border-collapse">
                                    <tbody class="flex-1">
                                        <tr class="border">
                                            <td class="w-1/3 p-2.5 text-left text-sm font-semibold">Recipient Name</td>
                                            <td class="text-left text-sm">{{ $r->user->name }}</td>
                                        </tr>

                                        <tr class="border">
                                            <td class="w-1/3 p-2.5 text-left text-sm font-semibold">Reward Title</td>
                                            <td class="text-sm text-blue-600 text-left truncate">
                                                <a href="/redemption/{{ $r->id }} truncate">{{ data_get(json_decode($r->data), 'title') }}</a>
                                            </td>
                                        </tr>

                                        <tr class="border">
                                            <td class="w-1/3 p-2.5 text-left text-sm font-semibold">Status <span
                                                    class="italic font-normal">(Hover to Change)</span></td>
                                            <td class="text-left text-sm">
                                                @if(!($r->marked_as_unable_to_furfill || $r->is_rejected) && !$r->is_pending)
                                                    <div
                                                        class="@if($r->confirmed_reciept) text-green-500 @else text-red-500 @endif">
                                                        @if($r->confirmed_reciept)
                                                            @if($r->tango_order_id)
                                                                <x-clear-link-button
                                                                    class="bg-white  py-0">
                                                                    <div class="w-full">
                                                                        <span class="text-purple-800">Sent</span>
                                                                    </div>
                                                                </x-clear-link-button>
                                                            @else
                                                            <x-clear-link-button
                                                                class="bg-white hover:bg-red-500 hover:text-white py-0"
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
                                                            <x-clear-link-button
                                                                class="bg-gray-50 hover:bg-green-500 hover:text-white py-0"
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
                                                @elseif($r->is_pending )

                                                    <x-clear-link-button
                                                        class="bg-white  py-0">
                                                        <span class="text-gray-500">Pending</span>
                                                    </x-clear-link-button>
                                                @elseif($r->is_rejected ||$r->marked_as_unable_to_furfill)
                                                    <x-clear-link-button
                                                        class="bg-gray-50 py-0 disabled bg-gray-300 text-black cursor-not-allowed"
                                                        disabled>
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
                                                    <div class="space-x-4"
                                                         wire:loading.class="opacity-25 disabled cursor-not-allowed ">
                                                        <span wire:click="rejectingRewardRequest({{ $r->id }})">
                                                            <i class="fa fa-times-circle text-red-700 text-2xl cursor-pointer"
                                                               wire:loading.class="cursor-not-allowed"></i>
                                                        </span>

                                                        <span wire:click="approveRewardRequest({{ $r->id }})">
                                                            <i class="fa fa-check-circle text-green-700 text-2xl cursor-pointer"
                                                               wire:loading.class="cursor-not-allowed"></i>
                                                        </span>
                                                    </div>
                                                @else
                                                    @if($r->is_rejected || $r->marked_as_unable_to_furfill)
                                                        <span class="text-center tooltip" title="{{ $r->is_rejected ? 'Rejected' : 'Unable to Fulfill' }}">
                                                            <i class="fa fa-times-circle text-red-700 text-2xl opacity-50 "></i>
                                                        </span>
                                                    @else
                                                        <span class="text-center tooltip" title="Processed">
                                                            <i class="fa fa-check-circle text-green-700 text-2xl opacity-75 text-center"></i>
                                                        </span>
                                                    @endif
                                                @endif
                                            </td>
                                        </tr>

                                        <tr class="border">
                                            <td class="w-1/3 p-2.5 text-left text-sm font-semibold">
                                                Unique Redemption Code
                                            </td>
                                            <td class="text-left text-sm ">{{ $r->redemption_code }}</td>
                                        </tr>

                                        <tr class="border">
                                            <td class="w-1/3 p-2.5 text-left text-sm font-semibold">Kudo</td>
                                            <td class="text-left text-sm ">{{strlen($r->cost) <= 3 ? $r->cost : substr($r->cost, 0, -3) . ',' . substr($r->cost, -3)}}</td>
                                        </tr>

                                        <tr class="border">
                                            <td class="w-1/3 p-2.5 text-left text-sm font-semibold">Amount</td>
                                            <td class="text-left text-sm ">{{$r->value}}</td>
                                        </tr>

                                        <tr class="border">
                                            <td class="w-1/3 p-2.5 text-left text-sm font-semibold">Currency</td>
                                            <td class="text-left text-sm ">
                                                {{--                                            @if(isset(json_decode(json_decode($r->data)->tango_data)->items[0]->currencyCode) )--}}
                                                {{--                                                <div class="col-start-10 col-span-1 mx-1 text-sm text-left  py-1">--}}
                                                {{--                                                    {{json_decode(json_decode($r->data)->tango_data)->items[0]->currencyCode}}--}}
                                                {{--                                                </div>--}}
                                                {{--                                            @else--}}
                                                <div class="col-start-10 col-span-1 mx-1 text-sm text-left  py-1">
                                                    {{$r->currency}}
                                                </div>
                                                {{--                                            @endif--}}
                                            </td>
                                        </tr>

                                        <tr class="border">
                                            <td class="w-1/3 p-2.5 text-left text-sm font-semibold">Purchase Date</td>
                                            <td class="text-left text-sm italic">{{ Timezone::convertToLocal($r->created_at, 'F jS, Y \- g:i A') }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            @empty
                                <div
                                    class="col-start-1 col-span-12 border-b border-gray-300 border-dashed mb-1 text-gray-500">
                                    No Custom Reward Redemptions
                                </div>
                            @endforelse

                        </div>
                    </div>
{{--                </div>--}}


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
            </div>
        </div>

    </div>
</div>
