<x-app-layout>
    <x-slot name="header">
        Reward Redemptions
    </x-slot>

    <div class="block md:flex mx-10 my-5">
        @include('components.profile-card', ['user' => Auth::user()])

        <div class="w-full md:w-3/5 p-8 bg-white lg:ml-10 shadow-md rounded rounded-t-lg ">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ getReplacedWordOfKudos() }} Summary for {{Auth::user()->name}}
            </h2>

            <div name="description">
                You currently have <b>{{Auth::user()->points}}</b> {{ getReplacedWordOfKudos() }} available <br>
                <span class="italic text-sm">You may use these {{ getReplacedWordOfKudos() }} to buy awesome rewards!</span><br>
            </div>
        </div>
    </div>


    <div class="grid grid-cols-1 md:grid-cols-4 mx-10 my-5 p-5">

    <!--  @if(count(Auth::user()->currentTeam->users) <1)
            Please add your team to view them here
        @endif -->

        @foreach(\App\Models\Reward::get() as $r)
            <div class="rounded rounded-t-lg overflow-hidden shadow max-w-xs my-3 bg-white mx-5"
                 style="min-width: 150px;">
                <!--  <img src='' class="w-full" /> -->
                <!-- <div class="flex justify-center -mt-8">
                    <img src="" class="rounded-full -mt-3">
                </div> -->
                <div style="min-height: 250px;">
                    <div class="text-center px-3 pb-6 pt-2">
                        <a class="text-black text-xls bold font-sans py-5" href="">{{ $r->title }}</a>
                        <div class="w-full border-b-2"></div>
                        <p class="mt-2 text-sm font-sans font-light text-grey-dark italic">Value: {{currencyNumber($r->value, $r->currency)}}</p>
                        <p class="mt-2 text-sm font-sans font-light text-grey-dark italic">
                            Cost: {{$r->cost}} {{ getReplacedWordOfKudos() }}</p>
                        <p class="mt-2 text-sm font-sans font-light text-grey-dark italic">{{$r->description}}</p>
                    </div>
                </div>
                <x-link-button class="ml-5 mr-5 my-3" href="/rewards/{{$r->id}}">
                    {{ __('Redeem') }}
                </x-link-button>
            </div>
        @endforeach
    </div>
</x-app-layout>
