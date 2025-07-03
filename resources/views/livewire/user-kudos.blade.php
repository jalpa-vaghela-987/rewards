<div class="w-full sm:flex">
    <div class="sm:w-2/4 w-full text-center sm:text-left">
        <div class="sm:mt-7 sm:mx-5 mx-8 mt-5">
            @forelse($points as $point)
                @include('components.standard-social-card', [
                    'point'         => $point,
                    'showOptions'   => false,
                    'showEdit'      => false,
                ])
            @empty
                <div class="p-4 text-gray-500">
                    No {{ getReplacedWordOfKudos() }} Sent or Received for Selected User. <br> <a class="text-blue-700" href="{{ route('kudos.feed') }}">go back</a>
                </div>
            @endforelse
        </div>
    </div>
</div>
