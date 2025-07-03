<div>
    @if($disabled)
        <h2 class="font-semibold text-lg text-gray-800 leading-tight my-2 pt-5 ">
            View {{ appName() }} Disable Partner Gift Cards
        </h2>

        <h2 class="italic text-sm text-gray-800 leading-tight my-1 pt-2 border-t border-gray-500">
            Hover over the gift card to preview.
        </h2>
    @else
        <h2 class="font-semibold text-lg text-gray-800 leading-tight my-2 pt-5 ">
            View {{ appName() }} Partner Gift Cards
        </h2>

        <h2 class="italic text-sm text-gray-800 leading-tight my-1 pt-2 border-t border-gray-500">
            Hover over the gift card to preview.
        </h2>

        <div class="text-xs italic w-full">
            The merchants represented are not sponsors of the rewards or otherwise affiliated with {{ appName() }}. The logos and other identifying marks attached are trademarks of and owned by each represented company and/or its affiliates. Please visit each company's website for additional terms and conditions.
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 justify-center mt-2" wire:ignore>
        @forelse($rewards as $r)
            <div class="gift_card self-start" wire:ignore>
                @include('components.tango-card', ['r' => $r])
            </div>
        @empty
            <div class="mt-5 italic col-span-2">
                Looks like you do not have any {{($disabled) ? "disabled" : ""}} gift cards.
            </div>
        @endforelse
    </div>

{{--    <div class="m-5 text-center col-start-1 grid-cols-12">--}}
{{--        {{ $rewards->links() }}--}}
{{--    </div>--}}
</div>
