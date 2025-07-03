<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 justify-center mb-3">
    @forelse($cards as $r)
    <div class="gift_card self-start" wire:ignore
         x-data="{
            is_disabled: null,
            approval_needed: null,
            setReward(approval, disabled) {
                this.approval_needed = approval;
                this.is_disabled = disabled;
            },
            toggleApproval(rewardId) {
                @this.toggleApproval(rewardId);

                this.approval_needed = !this.approval_needed;
            },
            toggleDisable(rewardId) {
                @this.toggleDisable(rewardId);

                this.is_disabled = !this.is_disabled;
            }
         }"
         x-init="setReward({{$r->approval_needed}}, {{$r->disabled}})"
    >
        @if ($r->photo_path)
            <div
                style="min-height: 190px; max-height: 190px; height: 190px !important; min-width: 300px; max-width: 300px; width: 300px; !important;"
                class="border border-gray-400 shadow-xl rounded-xl m-auto m-2 sm:m-4 overflow-hidden bg-gray-100 front self-start mt-1">
                <img class="shadow-xl rounded-xl w-full h-full" src="{{ $r->photo_path }}">
            </div>
        @else
            <div
                style="min-height: 190px; max-height: 190px; height: 190px !important; min-width: 300px; max-width: 300px; width: 300px; !important;"
                class="border border-gray-400 shadow-xl rounded-xl m-auto m-2 sm:m-4 overflow-hidden bg-gray-100 front self-start mt-1">
                <div class="font-handwriting text-xl mx-auto mt-3 w-full text-center flex flex-col break-words">
                    {{ $r->title ?? "Reward Title" }}
                </div>

                <div class="w-full" style="height: 115px;">
                    <img class="object-contain mx-auto mt-2" style="height:50px;" src="{!! Auth::user()->company->logo_path !!}"/>
                </div>

                <div class="italic w-full text-sm mt-auto ml-3">
                    {{ substr(Auth::user()->company->name, 0, 20) }} Custom Reward
                </div>
            </div>
        @endif

        <div class="rounded-xl overflow-hidden shadow-xl max-w-xs sm:mx-3 bg-white gift_card_info back self-start m-1 overflow-x-hidden"
             style="min-width: 150px;">
            <div style="min-height: 100px;">
                <div class="text-center px-3 pb-6 pt-2">
                    <a class="text-black text-xls bold font-sans py-5 cursor-auto break-words truncate" href="">
                        {{ $r->title }}
                    </a>

                    <div class="text-center text-xs italic">
                        <span x-text="approval_needed ? 'Manual Approval' : 'Instant Approval'"></span>

                            <span> | {{ $r->currency }}</span>
                    </div>

                    <div class="w-full border-b-2"></div>

                    <div class="mt-2 text-xs font-sans font-light text-grey-dark italic break-words overflow-auto" style="height: 150px; text-overflow: ellipsis;">
                        @if(strlen($r->description) >550)
                            {{substr($r->description,0,555)}} ....
                        @else
                            {{ $r->description }}
                        @endif
                    </div>
                    <div class="mt-2 mb-4"> Cost:<span class="font-semibold">{{$r->cost}}</span></div>
                    @if($r->enable_inventory_tracking)
                        <div>Inventory Remaining: <span class="font-semibold">{{$r->stock_amount}}</span></div>
                    @endif
                    <div>Redeemed Amount: <span class="font-semibold">{{$r->redemptions ? $r->redemptions->count() : 0}}</span></div>

                </div>
            </div>

            <div class="flex justify-around">
                <a class="wrapper m-5 text-sm" @click="toggleApproval({{ $r->id }})">
                    <span>
                        <i class="fas fa-users-cog text-2xl cursor-pointer" x-bind:class="approval_needed ? 'text-gray-700' : 'text-gray-300'"></i>
                    </span>

                    <div class="tooltip-text">
                        <span x-text="approval_needed ? 'Enable Instant Approval' : 'Enable Manual Approval'"></span>
                    </div>
                </a>

                <a class="wrapper m-5 text-sm" @click="toggleDisable({{ $r->id }})">
                    <span>
                        <i class="fas fa-ban text-2xl cursor-pointer" x-bind:class="is_disabled ? 'text-gray-300' : 'text-gray-700'"></i>
                    </span>

                    <div class="tooltip-text">
                        <span x-text="is_disabled ? 'Enable Card' : 'Disable Card'"></span>
                    </div>
                </a>

                <a class="wrapper m-5 text-sm" href="/rewards/company/reward/{{$r->id}}">
                    <span>
                        <i class="fas fa-edit text-xl cursor-pointer"></i>
                    </span>

                    <div class="tooltip-text">{{ __('Edit') }}</div>
                </a>

                <a class="wrapper m-5 text-sm" wire:click="confirmingDeleteCustomReward({{ $r->id }})">
                    <span>
                        <i class="fas fa-trash text-xl cursor-pointer text-red-500"></i>
                    </span>

                    <div class="tooltip-text">{{ __('Delete') }}</div>
                </a>
            </div>


{{--            <div class="m-5 flex justify-content-center justify-between">--}}
{{--                <x-jet-danger-button wire:click="confirmingDeleteCustomReward({{ $r->id }})">--}}
{{--                    {{ __('Delete') }}--}}
{{--                </x-jet-danger-button>--}}

{{--                <x-link-button href="/rewards/{{$r->id}}">--}}
{{--                    {{ __('Redeem') }}--}}
{{--                </x-link-button>--}}

{{--                <x-secondary-link-button href="/rewards/company/reward/{{$r->id}}">--}}
{{--                    {{ __('Edit') }}--}}
{{--                </x-secondary-link-button>--}}
{{--            </div>--}}
        </div>
    </div>
    @empty
    <div class="mt-5 italic col-span-2">
        Looks like you do not have any {{($disabled) ? "disabled " : ""}}custom rewards yet.
    </div>
    @endforelse

    <!-- Delete Custom Reward Confirmation Modal -->
    <x-jet-confirmation-modal wire:model="confirmingCustomRewardDeletion">
        <x-slot name="title">
            {{ __('Delete Custom Rewards') }}
        </x-slot>

        <x-slot name="content">
            {{ __('Are you sure you want to delete this custom reward?') }}
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('confirmingCustomRewardDeletion')" wire:loading.attr="disabled">
                {{ __('Nevermind') }}
            </x-jet-secondary-button>

            <x-jet-danger-button class="ml-2" wire:click="deleteCustomReward" wire:loading.attr="disabled">
                {{ __('Delete') }}
            </x-jet-danger-button>
        </x-slot>
    </x-jet-confirmation-modal>
</div>
