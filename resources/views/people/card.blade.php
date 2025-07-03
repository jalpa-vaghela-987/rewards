<div
    class="w-full h-full rounded rounded-t-lg overflow-hidden bg-white border border-gray-300 px-1 py-2 self-start  flex flex-col justify-between"
    style="min-width: 100px; ">
    <div class="mt-3 my-2">
        <a href="{{ route('profile.user',['user' => $user->id])}}" class="flex justify-center">
            @if(str_starts_with($user->profile_photo_url, 'https://ui-avatars.com/api/'))
            <img src="{{ $user->profile_photo_url }}" class="rounded-full hover:bg-gray-100 h-16">
            @else
                <img src="{{ $user->profile_photo_url }}" class="rounded-full hover:bg-gray-100 h-16 w-16">
            @endif
        </a>

        <div class="text-center p-1 mt-1">
            <a class="text-black sm:text-xs xs:text-lg bold font-sans hover:bg-gray-100 p-1 lg:text-xs "
               href="{{ route('profile.user',['user' => $user->id])}}">
                {{ $user->name }}

                <a href="mailto:{{ $user->email }}" class="text-sm text-gray-500">
                    <i class="fa fa-envelope text-indigo-400 hover:text-indigo-700 tooltip" title="{{ $user->email }}"></i>
                </a>
            </a>

            <p class="my-2 mb-5 text-sm font-sans font-light text-grey-dark italic sm:text-xs">
                {{$user->position}}
            </p>

            <div class="space-x-5 text-center items-center">
                @if($user->birthday)
                    <span>
                        <i class="fa fa-birthday-cake text-pink-400 tooltip" title="Birthday: {{ $user->birthday->format('F jS') }}"></i>
                    </span>
                @endif

                @if($user->anniversary)
                    <span>
                        <i class="fas fa-university text-gray-900 tooltip" title="Start Date: {{ $user->anniversary->format('F jS, Y') }}"></i>
                    </span>
                @endif

                @if(auth()->id() !== $user->id)
                    <a href="{{ route('kudos-show', ['user' => $user->id]) }}">
{{--                        <span class="text-red-500 tooltip" title="Give {{ getReplacedWordOfKudos() }}">👏</span>--}}
                        <i class="fa-solid fa-hands-clapping text-blue-500 tooltip" title="Give {{ getReplacedWordOfKudos() }}"></i>
                    </a>

                    <a href="{{ route('card.create', ['user' => $user->id]) }}">
                        <i class="fa fa-object-group text-red-500 tooltip" title="Send Group Card"></i>
                    </a>
                @endif
            </div>
        </div>
    </div>

    @if(auth()->check() && auth()->user()->role === 1)
        <div class="text-left text-sm mt-3 border-gray-200 border-t -my-2 p-2 text-gray-600">
            <div class="text-xs italic underline text-center mb-1">Company Admin Only</div>
            <p class="text-xs text-center">{{ number_format($user->points) }} {{ getReplacedWordOfKudos() }} to Spend</p>
            <p class="text-xs text-center mt-1">{{ number_format($user->points_to_give) }} {{ getReplacedWordOfKudos() }} available
                to give away</p>
        </div>

    <!--  <div class="text-center text-sm mt-3 border-gray-200 border-t -mx-2 -my-2 p-2 text-gray-600">
            <a class="text-sm text-blue-700" href="{{ route('user.kudos', $user->id) }}">See Kudos</a>
        </div> -->
    @endif
</div>
