<x-guest-layout>
    <x-jet-authentication-card
        style="background-image: url({{asset('/other/stock/yellow-rounded.png')}}); background-size: cover;">
        <x-slot name="logo">
            <image src="{{$company->logo_path}}" style="margin:auto; max-width: 150px; padding-top: 20px;"/>
        </x-slot>
        <h2 class="pb-1 my-2 text-xl font-semibold">{{$company->name}}</h2>
        <div class="text-md font-handwriting font-semibold mt-6 text-pink-600">
            Next, tell us a little about yourself.
        </div>

        <!-- <p>{{$user}} are using {{$company->name}} connect</p> -->
        @livewire('company-user',$data)
    </x-jet-authentication-card>
</x-guest-layout>
