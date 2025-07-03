@if ($r->photo_path)
    <div
        style="min-height: 190px; max-height: 190px; height: 190px !important; min-width: 300px; max-width: 300px; width: 300px; !important;"
        class="border border-gray-400 shadow-xl rounded-xl m-auto m-2 sm:m-4 -ml-5 overflow-hidden bg-gray-100 front self-start mt-1">
        <img class="shadow-xl rounded-xl w-full h-full" src="{{ $r->photo_path ?? auth()->user()->company->logo_path }}">
    </div>
@else
    <div
        style="min-height: 190px; max-height: 190px; height: 190px !important; min-width: 300px; max-width: 300px; width: 300px; !important;"
        class="w-30 border border-gray-400 shadow-xl rounded-xl m-auto m-2 sm:m-4 -ml-5 overflow-hidden bg-gray-100 front self-start mt-1  ">
        <div class="font-handwriting text-xl mx-auto mt-3 w-full text-center flex flex-col break-words">
            {{ $title ?? "Reward" }}
        </div>

        <div class="w-full" style="height: 115px;">
            <img class="object-contain mx-auto mt-2" style="height:50px;"
                 src="{!! auth()->user()->company->logo_path !!}"/>
        </div>

        <div class="italic w-full text-sm mt-auto ml-3">
            {{ substr(auth()->user()->company->name, 0, 20) }} Custom Reward
        </div>
    </div>
@endif
