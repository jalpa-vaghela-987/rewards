<div class="shadow-2xl card-main-background">
    <div class="h-24 text-gray-900 font-extrabold text-3xl mt-0 justify-center text-center rounded shadow-2xl flex align-middle flex-col w-full
		font-handwriting" style="background: {{$this->card->banner_color}}; ">
        {{$this->card->headline}}
    </div>

    @if(auth()->id() == $this->card->creator_id)
        <x-link-button href="{{route('card.preview',['card'=>$this->card])}}" class="m-3 float-right shadow bg-red-300">
            View Preview & Send!
        </x-link-button>

        <x-secondary-link-button href="{{route('card.edit',['card'=>$this->card])}}" class="m-3 float-right shadow  xs:ml-6">
            Modify Settings
        </x-secondary-link-button>

        <x-link-button href="{{route('card.people',['card'=>$this->card])}}" class="m-3 float-right shadow xs:ml-8">
            Modify People
        </x-link-button>

        <x-secondary-link-button wire:click="confirmingSendNotifyPeople()" class="m-3 float-right shadow bg-red-300  xs:ml-8">
            <span>
                Send Reminder
            </span>
            <span class="tooltip -mr-0.5 pl-1" title="Send a reminder email and notification to everyone invited to the group card">
                <i class="fas fa-question-circle"></i>
            </span>
        </x-secondary-link-button>
    @endif
    <div class="flex pb-96 pt-12 w-full grid lg:grid-cols-3 md:grid-cols-2 grid-cols-1 ">
        <!-- // prior peoples entries -->
        @php
            $card_element_exists = false;
        @endphp

        @foreach($this->card->card_elements->where('active',1) as $ce)
            @if($ce->user->id == Auth::user()->id)
                @php
                    $card_element_exists = true;
                @endphp

                @if ($this->card->users()->wherePivot('active', 1)->wherePivot('user_id', $ce->user->id)->exists())
                    @include('cards.card_edit_form')
                @endif
            @else
                @if ($this->card->users()->wherePivot('active', 1)->wherePivot('user_id', $ce->user->id)->exists())
                    @include('cards.card_view_form')
                @endif
            @endif
        @endforeach

        @if(!$card_element_exists)
            @include('cards.card_edit_form')
        @endif
    </div>
    <x-jet-confirmation-modal wire:model="confirmingSendNotifyPeople">
        <x-slot name="title">
            {{ __('Send Reminder') }}
        </x-slot>

        <x-slot name="content">
            {{ __('Are you sure you would like to Send a reminder email and notification to everyone invited to the group card') }}
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$set('confirmingSendNotifyPeople', false)"
                                    wire:loading.attr="disabled">
                {{ __('Nevermind') }}
            </x-jet-secondary-button>

            <x-jet-danger-button class="ml-2" wire:click="remindNonContributedUsers()" wire:loading.attr="disabled">
                {{ __('Send Reminder') }}
            </x-jet-danger-button>
        </x-slot>
    </x-jet-confirmation-modal>
</div>


