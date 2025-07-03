<div>
    <div class="shadow-2xl card-main-background" style="">
        <div class="h-24 text-gray-900 font-extrabold text-3xl mt-0 justify-center text-center rounded shadow-2xl flex align-middle flex-col w-full
		font-handwriting" style="background: {{$this->card->banner_color}}">
            {{$this->card->headline}}

        </div>
        @if(Auth::user()->id == $this->card->creator->id)
            <x-link-button wire:click="$toggle('confirmingSend')" wire:loading.attr="disabled"
                           class="m-3 float-right shadow bg-red-300">
                Send to {{$this->card->receiver->name}}!
            </x-link-button>

            <x-secondary-link-button href="{{route('card.build', $this->card->id)}}"
                                     class="m-3 float-right shadow">
                Edit Card
            </x-secondary-link-button>
        @endif
        <div class="flex pb-96 pt-12 w-full grid lg:grid-cols-3 md:grid-cols-2 grid-cols-1 ">
            <!-- // prior peoples entries -->
            @php
                $card_element_exists = false;
            @endphp

            @foreach($this->card->card_elements->where('active',1) as $ce)
                @if ($this->card->users()->wherePivot('active', 1)->wherePivot('user_id', $ce->user->id)->exists())
                    @include('cards.card_view_form')
                @endif
            @endforeach
        </div>
    </div>


    <!-- Confirmation Modal -->
    <x-confirmation-modal wire:model="confirmingSend">
        <x-slot name="title">
            Send to {{$this->card->receiver->name}}!
        </x-slot>

        <x-slot name="content">
            Are you sure you want to send this group card to {{$this->card->receiver->name}}? This will lock the card as
            final and anyone who has not contributed will no longer be able to contribute.
        <!--              @if(Auth::user()->company->in_trial_mode)
            <br><br>
           <div class="italic">You cannot send in trial model. Register for the full {{ appName() }} platform to send card!
                <br>
                Contact <a href="mailto:sales@perksweet.com" class="text-blue-700  text-md hover:text-blue-500">Sales@PerkSweet.com</a>
            </div><br>
            @endif -->
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('confirmingSend')" wire:loading.attr="disabled">
                {{ __('Nevermind') }}
            </x-jet-secondary-button>

            <x-jet-secondary-button class="ml-2 bg-green-300" wire:click="sendCard" wire:loading.attr="disabled"
            >
                {{ __('Send it!') }}
            </x-jet-secondary-button>
        </x-slot>
    </x-confirmation-modal>

    <style type="text/css">
        @media screen and (min-width: 1000px) {
            .card-main-background {
                background-image: url('{{$card->background_photo_path}}');
                /*background-size: cover;*/
                min-height: 600px;
                background-size: 105% auto;
                background-attachment: fixed;
            }
        }

        @media screen and (max-width: 1000px) and (min-width: 500px) {
            .card-main-background {
                background-image: url('{{$card->background_photo_path}}');
                /*background-size: cover;*/
                max-width: 100%;
                height: auto;
                background-size: 929px 870px;
                background-attachment: fixed;
            }
        }

        @media screen and (max-width: 500px) {
            .card-main-background{
                background-image: url('{{$card->background_photo_path}}');
                background-size: cover;
                /*max-width: 100%;*/
                height: 100%;
                /*background-size: 389px 843px;*/
                background-repeat:repeat-x;
                background-attachment: fixed;
            }
        }
    </style>
</div>
