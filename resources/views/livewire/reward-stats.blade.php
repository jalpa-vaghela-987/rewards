<div class="flex flex-col">
    <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
        <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
            <div class="w-full mb-5">
                <x-jet-input class="w-1/4" type="text" wire:model="search" placeholder="Search Reward ..." autofocus/>
                <a href="/export-reward-stats" class="w-full ">
                    <span class="text-lg float-right pt-5 mr-3">
                        <i class="fas fa-upload text-xl cursor-pointer  text-gray-700 "></i>
                         Export
                    </span>
                </a>
            </div>

            <div class="shadow overflow-hidden border-b border-gray-200 sm: rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" width="5%" wire:click="sort('title')"
                            class="cursor-pointer px-6 py-3 max-w-[3.23rem] text-left text-xs font-medium text-gray-500 uppercase tracking-wider font-bold">
                            Title
                            <span>
                                @if($sortColumn === 'title')
                                    <i class="fa {{$sortDirection === 'asc' ? 'fa-chevron-up' : 'fa-chevron-down'}}"></i>
                                @else
                                    <i class="fas fa-sort"></i>
                                @endif
                            </span>
                        </th>

                        <th scope="col" wire:click="sort('cost')"
                            class="cursor-pointer px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider font-bold">
                            Amount in {{ getReplacedWordOfKudos() }}
                            <span>
                                @if($sortColumn === 'cost')
                                    <i class="fa {{$sortDirection === 'asc' ? 'fa-chevron-up' : 'fa-chevron-down'}}"></i>
                                @else
                                    <i class="fas fa-sort"></i>
                                @endif
                            </span>
                        </th>
{{--                        <th scope="col"--}}
{{--                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider font-bold">--}}
{{--                            Inventory Tracking Enabled--}}
{{--                        </th>--}}
                        <th scope="col" wire:click="sort('stock_amount')"
                            class="cursor-pointer px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider font-bold">
                            Stock Left
                            @if($sortColumn === 'stock_amount')
                                <i class="fa {{$sortDirection === 'asc' ? 'fa-chevron-up' : 'fa-chevron-down'}}"></i>
                            @else
                                <i class="fas fa-sort"></i>
                            @endif
                        </th>
                        <th scope="col" wire:click="sort('inventory_redeemed')"
                            class="cursor-pointer px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider font-bold">
                            Amount Redeemed
                            @if($sortColumn === 'inventory_redeemed')
                                <i class="fa {{$sortDirection === 'asc' ? 'fa-chevron-up' : 'fa-chevron-down'}}"></i>
                            @else
                                <i class="fas fa-sort"></i>
                            @endif
                        </th>
                        <th scope="col" wire:click="sort('type')"
                            class="cursor-pointer px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider font-bold">
                            Type
                            @if($sortColumn === 'type')
                                <i class="fa {{$sortDirection === 'asc' ? 'fa-chevron-up' : 'fa-chevron-down'}}"></i>
                            @else
                                <i class="fas fa-sort"></i>
                            @endif
                        </th>
                        <th scope="col" wire:click="sort('tango_currency')"
                            class="cursor-pointer px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider font-bold">
                            Currency
                            @if($sortColumn === 'tango_currency')
                                <i class="fa {{$sortDirection === 'asc' ? 'fa-chevron-up' : 'fa-chevron-down'}}"></i>
                            @else
                                <i class="fas fa-sort"></i>
                            @endif

                        </th>
                        <th scope="col"
                            class="cursor-pointer px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider font-bold">
                            Last Redeemed By
                        </th>
                    </tr>
                    </thead>

                    <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($rewards as $reward)
                        <tr class="">
                            <td class="px-6 py-4 whitespace-nowrap truncate text-sm text-gray-900" style="max-width: 18rem;">
                                <a class="text-indigo-500 hover:text-indigo-700 font-semibold" href="{{ route('rewards.redeem', ['reward' => $reward]) }}">
                                    {{ $reward->title }}
                                </a>
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $reward->cost ? $reward->cost:'Variable' }}</div>
                            </td>

{{--                            <td class="px-6 py-4 whitespace-nowrap">--}}
{{--                                <div class="text-sm text-gray-900">{{ $reward->enable_inventory_tracking ? 'Yes' : 'No' }}</div>--}}
{{--                            </td>--}}

                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <div class="text-sm text-gray-900">
                                    {{ $reward->type !== 'Custom Reward' ? 'Unlimited' : ($reward->enable_inventory_tracking ? $reward->stock_amount : 'N/A') }}
                                </div>
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <div class="text-sm text-gray-900">
                                    {{ $reward->inventory_redeemed ? $reward->inventory_redeemed : '0'  }}
{{--                                    {{ $reward->enable_inventory_tracking ? $reward->inventory_redeemed : '0' }}--}}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <div class="text-sm text-gray-900">
                                    @if($reward->type == 'Custom Reward')
                                        {{ $reward->type }}
                                    @else
                                        {{ 'Partner Rewards' }}
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <div class="text-sm text-gray-900">
                                    {{$reward->tango_currency}}
                                </div>
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
{{--                                    <div class="flex-shrink-0 h-10 w-10">--}}
{{--                                        <img class="h-10 w-10 rounded-full" src="{{ $reward->recent_redemption->user->profile_photo_url }}" alt=""/>--}}
{{--                                    </div>--}}

                                    <div class="" wire:loading.class.delay="opacity-40">
                                        @if(data_get($reward, 'recent_redemption.user'))
                                            <div class="text-sm font-medium text-gray-900">
                                                By
                                                <a class="text-indigo-500 hover:text-indigo-700 font-semibold" href="{{route('profile.user', ['user' => $reward->recent_redemption->user])}}">
                                                    {{ $reward->recent_redemption->user->name }}
                                                </a>
                                                at {{ defaultDateFormat($reward->recent_redemption->created_at) }}
                                            </div>
                                        @else
                                            <div class="text-sm font-medium text-gray-900">
                                                N/A
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap" colspan="100%">
                                <div class="flex items-center justify-center text-gray-600 h-16 opacity-50 text-md">
                                    <span class="mr-3"><i class="fa fa-envelope"></i></span>
                                    <span class="text-lg">No Redemptions Found ...</span>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>

                <div class="p-5">
                    {{ $rewards->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
