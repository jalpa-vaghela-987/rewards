@php

    $team = Auth::user()->currentTeam;

@endphp

<x-app-layout>

    <div class="container mx-auto px-4 py-10 md:py-12">
        <div class="flex flex-wrap space-y-8 md:space-y-0">
            <div class="w-full md:w-1/3">
                <x-jet-section-title>
                    <x-slot name="title">
                        {{ __('Group Cards') }}
                    </x-slot>

                    <x-slot name="description">
                        {{ __('Celebrate a team member with a digital group card filled with personalized messages, GIFs, photos, and videos!') }}

                        <div class="my-5">
                            <x-link-button href="{{route('card.create')}}">
                                Create Group Card!
                            </x-link-button>
                        </div>
                    </x-slot>
                </x-jet-section-title>
            </div>

            <div class="w-full md:w-2/3 md:pl-10">
                <div class="bg-white p-5 shadow rounded">
                    @if(session()->has('message'))
                        <div class="text-green-500 text-md hover:text-green-500">
                            {{session('message')}}
                        </div>
                    @endif
                    <x-jet-section-title>
                        <x-slot name="title">
                            <span class="text-blue-800">{{ __('Active Group Cards') }}</span>
                            {{--                            <x-link-button class="fa fa-download" href="{{URL::to('/card/pdf/'.'active')}}" style="background-color: #6B7280"></x-link-button>--}}
                        </x-slot>
                        <x-slot name="description">
                            <div class="flex w-full mt-1 p-2 bg-white ">
                                @if(Auth::user()->cards()->where('cards.active', 1)->where('card_user.active',1)->where('sent_to_recipient',0)->orderByDesc('created_at')->count())
                                    <div class="owl-carousel new-arrivals-carousel owl-theme">
                                        @foreach(Auth::user()->cards()->where('cards.active', 1)->where('card_user.active',1)->where('sent_to_recipient',0)->orderByDesc('created_at')->get() as $c)
                                            <div class="theme bg-white m-3 border-2 border-gray-300 border-dashed ">
                                                @include('components.card-photo',['card' => $c, 'href'=> route('card.build', $c->id)])
                                                <div class="border border-gray-400"></div>
                                                <div class="flex m-2 italic text-xs justify-between">
                                            <span>Created by {{ data_get($c->creator, 'name')}}
                                                on {{\Carbon\Carbon::parse($c->created_at)->format('F jS, Y')}} to be
                                                sent
                                                to {{ data_get($c->receiver, 'name')}}
                                            </span>
                                                    @if(auth()->id() === $c->creator_id)
                                                        <span class="text-red-500 ">
                                                           <button id="confirm-delete" value="{{$c->id}}" onclick="myFunction({{$c->id}})"> <i class="fas fa-trash-alt"></i></button>
                                                        </span>
                                                        <span class="text-red-500 hidden">
                                                        <form action="{{ route('card.delete', $c->id) }}" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                             <button type="submit" id="first" card-id="{{$c->id}}">
                                                                <i class="fas fa-trash-alt"></i>
                                                            </button>
                                                        </form>
                                                    </span>
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    No active group cards.
                                @endif
                            </div>

                        </x-slot>
                    </x-jet-section-title>
                    <x-jet-section-title>
                        <x-slot name="title">
                            <span class="text-blue-800">{{ __('Sent Cards') }}</span>
                            {{--                            <x-link-button class="fa fa-download" href="{{URL::to('/card/pdf/'.'sent')}}" style="background-color: #6B7280"></x-link-button>--}}
                        </x-slot>

                        <x-slot name="description">
                            <div class="flex w-full mt-1 p-2 bg-white ">
                                @if(Auth::user()->cards()->where('cards.active', 1)->where('card_user.active',1)->where('sent_to_recipient',1)->orderByDesc('sent_at')->count())
                                    <div class="owl-carousel new-arrivals-carousel owl-theme">
                                        @foreach(Auth::user()->cards()->where('cards.active', 1)->where('card_user.active',1)->where('sent_to_recipient',1)->orderByDesc('sent_at')->get() as $c)
                                            <div class="item bg-white m-3 border-2 border-gray-300 border-dashed ">
                                                @include('components.card-photo',['card' => $c, 'href' => url('/card/view/'. $c->token)])
                                                <div class="border border-gray-400"></div>
                                                <div class="flex m-2 italic text-xs justify-between">
                                            <span>
                                                Sent to {{ data_get($c->receiver, 'name')}} on {{\Carbon\Carbon::parse($c->sent_at)->format('F jS, Y')}}
                                            </span>
                                                    @if(auth()->id() === $c->creator_id)
                                                        <span class="text-red-500 ">
                                                           <button id="confirm-delete" value="{{$c->id}}" onclick="myFunction({{$c->id}})"> <i class="fas fa-trash-alt"></i></button>
                                                        </span>
                                                        <span class="text-red-500 hidden">
                                                        <form action="{{ route('card.delete', $c->id) }}"
                                                               method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" id="second" card-id="{{$c->id}}">
                                                                <i class="fas fa-trash-alt"></i>
                                                            </button>
                                                        </form>
                                                    </span>
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    No sent cards.
                                @endif
                            </div>
                        </x-slot>
                    </x-jet-section-title>
                    <x-jet-section-title>
                        <x-slot name="title">
                            <span class="text-blue-800">{{ __('Received Cards') }}</span>
                            {{--                            <x-link-button class="fa fa-download" href="{{URL::to('/card/pdf/'.'receive')}}" style="background-color: #6B7280"></x-link-button>--}}
                        </x-slot>

                        <x-slot name="description">
                            <div class="flex w-full mt-1 p-2 bg-white">
                                @if(\App\Models\Card::where('active',1)->where('receiver_id',auth()->id())->orderByDesc('sent_at')->count())
                                    <div class="owl-carousel new-arrivals-carousel owl-theme">
                                        @foreach(\App\Models\Card::where('active',1)->where('receiver_id',auth()->id())->orderByDesc('sent_at')->get() as $c)
                                            @if($c->token)
                                                <div class="item bg-white m-3 border-2 border-gray-300 border-dashed ">
                                                    @include('components.card-photo', ['card' => $c, 'href'=> url('/card/view/'. $c->token)])
                                                    <div class="border border-gray-400"></div>
                                                    <div class="flex m-2 italic text-xs justify-between">
                                            <span>
                                                Sent by {{ data_get($c->creator, 'name') }}
                                                @if($count = $c->users()->wherePivot('active', 1)->count())
                                                    @if($count > 1)
                                                        & {{ $count - 1 }} others
                                                    @endif
                                                @endif
                                                on {{\Carbon\Carbon::parse($c->sent_at)->format('F dS, Y')}}
                                            </span>
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                @else
                                    No received cards.
                                @endif
                            </div>
                        </x-slot>
                    </x-jet-section-title>
                </div>
            </div>
        </div>
    </div>

    <livewire:welcome-group-card/>

    <x-confirmation-modal-box id="ConfirmModal">
            <x-slot name="title">
                <div class="break-all">
                    Group Cards delete
                </div>
            </x-slot>


            <x-slot name="content">
                Are you sure you would like to remove this group card?
                <input type="hidden" id="delete-id">
            </x-slot>
            <x-slot name="footer">
                <x-jet-danger-button class="delete">
                    Delete
                </x-jet-danger-button>
                <span class="p-2"></span>
                <x-jet-secondary-button onclick="$('#ConfirmModal').hide();">
                    {{ __('Nevermind') }}
                </x-jet-secondary-button>



            </x-slot>
    </x-confirmation-modal-box>
    <script>
        function myFunction(id) {

            if($('#ConfirmModal').is(":hidden")) ;
            $('#ConfirmModal').show();

            $('#delete-id').val(id);

        }

        // $('#confirm-delete').on('click', function (e) {
        //
        // });
    </script>
    <script>
        $(".delete").click(function () {
            var postBoxes = document.querySelectorAll('#second')
            postBoxes.forEach(function(postBox) {
                var id = postBox.getAttribute('card-id')

                if($('#delete-id').val() == id)
                {
                    // console.log($('#delete-id').val());
                    // alert(id);
                    $("#second").click();
                }
                })

            var cardsDelete =  document.querySelectorAll('#first')
            cardsDelete.forEach(function(cards){
                var id = cards.getAttribute('card-id')
                if($('#delete-id').val() == id){

                    $("#first").click();
                }
            })
            });
    </script>

</x-app-layout>

<script>

    document.addEventListener("livewire:load", function (event) {
        $(document).ready(function () {
            setTimeout(function () {
                $('.new-arrivals-carousel').owlCarousel({
                    loop: false,
                    margin: 10,
                    responsive: {
                        0: {
                            items: 1
                        },
                        600: {
                            items: 1
                        },
                        1000: {
                            items: 2
                        }
                    }
                });
            }, 500);
        });
    });

</script>
