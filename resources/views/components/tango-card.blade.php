<div class="front">
    <img src="{{$r->photo_path}}" class="shadow-xl m-0 sm:m-5 my-3 sm:my-5 rounded-xl">
</div>

<div class="rounded-xl overflow-hidden overflow-x-hidden shadow-xl max-w-xs bg-white gift_card_info back self-start mx-0 sm:mx-3 m-0 sm:m-1 my-1"
     style="min-width: 150px;"
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
    <div style="min-height: 100px;">
        <div class="text-center px-3 pb-6 pt-2">
            <a class="text-black text-xls bold font-sans py-5" href="">
                {{ $r->title }}
            </a>

            <div class="text-center text-xs italic">
                <span x-text="approval_needed ? 'Manual Approval' : 'Instant Approval'"></span>
{{--                @if($r->approval_needed)--}}
{{--                    <span>Manual Approval</span>--}}
{{--                @else--}}
{{--                    <span>Instant Approval</span>--}}
{{--                @endif--}}

                @if($r->currency)
                    <span> | {{ $r->currency }}</span>
                @endif
            </div>

            <div class="w-full border-b-2"></div>

        <!-- <p class="mt-2 text-sm font-sans font-light text-grey-dark italic">Value: ${{$r->value}}</p>
<p class="mt-2 text-sm font-sans font-light text-grey-dark italic">Cost: {{ number_format($r->cost) }} {{ getReplacedWordOfKudos() }}</p> -->

            <div class="mt-2 text-xs font-sans font-light text-grey-dark italic overflow-ellipsis"
                 style="height: 145px; text-overflow: ellipsis; overflow: hidden">
                {!! $r->description !!}
            </div>
        </div>
    </div>

    <div class="flex justify-around">
        {{--        <a class="wrapper m-4 cursor-pointer text-sm" href="/rewards/{{$r->id}}">--}}
        {{--            <img class="h-7 w-7" src="/other/reward/gift_card_icon.png" />--}}

        {{--            <div class="tooltip-text">Redeem</div>--}}
        {{--        </a>--}}

        <a class="wrapper m-5 text-sm" @click="toggleApproval({{ $r->id }})">
            <span>
                <i class="fas fa-users-cog text-2xl cursor-pointer" x-bind:class="approval_needed ? 'text-gray-700' : 'text-gray-300'"></i>
            </span>

            <div class="tooltip-text">
                <span x-text="approval_needed ? 'Enable Instant Approval' : 'Enable Manual Approval'"></span>
            </div>
        </a>
        <a class="wrapper m-5 text-sm" @click="toggleDisable({{ $r->id }}, '{{$currency=request('currency')}}')">
            <span>
                <i class="fas fa-ban text-2xl cursor-pointer" x-bind:class="is_disabled ? 'text-gray-300' : 'text-gray-700'"></i>
            </span>

            <div class="tooltip-text">
                <span x-text="is_disabled ? 'Enable Card' : 'Disable Card'"></span>
            </div>
        </a>
    </div>
</div>
