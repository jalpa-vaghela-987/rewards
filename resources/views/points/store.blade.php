<x-app-layout>
    <div class="grid grid-cols-1 xl:mx-64 lg:mx-32 md:mx-16 sm:mx-2 p-5 bg-white my-5 shadow rounded">
        <div class="text-black">You sent {{ number_format($point->amount) }} @if($point->is_super) super @endif {{ getReplacedWordOfKudos() }}
            to {{$point->reciever->name}}!
        </div>
        <div class="italic text-sm pt-5"> Thank you for providing feedback.</div>
    </div>


    <div class="grid grid-cols-1 xl:mx-64 lg:mx-32 md:mx-16 sm:mx-2 p-5">
        @include('components.social-card',['point'=>$point])
    </div>
</x-app-layout>
