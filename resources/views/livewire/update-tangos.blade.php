<div>
    @if(Auth::user()->company->show_multiple_currencies)
        <div class="mt-5">
            <form action="" method="GET">
                <x-jet-label class="font-bold" for="currency" value="{{ __('Select Gift Card Currency') }}"/>
                <select name="currency"
                        class="border-gray-300 focus:border-indigo-300 focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mr-5 my-1 w-40 sm:w-38 md:w-28 lg:w-44"
                        onchange="this.form.submit()">
                    @foreach(\App\Models\Tango::all()->where('disable',0)->where('active',1)->pluck("currency")->flatten()->unique()->sort()->values()->all() as $currency)
                        <option
                            value="{{ $currency }}" {{ (request('currency') ? request('currency'): auth()->user()->currency) === $currency  ? 'selected': '' }}>
                            {{ $currency }}
                        </option>
                    @endforeach
                </select>
            </form>
        </div>
    @endif
  <div class="grid grid-cols-1 md:grid-cols-4 mx-10 my-5 p-5">
    @foreach($tangos as $r)

    <div class="rounded rounded-t-lg overflow-hidden shadow max-w-xs my-3 bg-gray-50 shadow mx-5" style="min-width: 150px;">

    <div style="min-height: 250px;">
        <div class="text-center px-3 pb-6 pt-2">
            <p class="text-black text-lg bold font-sans py-5" >{{ $r->title }}</p>
            <p class="text-black text-sm italic font-sans py-5" href="">Currency: {{ $r->currency }}</p>
        </div>
    </div>

<x-clear-link-button
    class="bg-white py-0"
    wire:click.prevent="toggle_status({{$r->id}})"
    >

     <div class="w-full">

        @if($r->disabled)
            <span class="text-red-500">Disabled</span>
        @else
            <span class="text-green-500">Enabled</span>
        @endif

     </div>

</x-clear-link-button>


</div>
    @endforeach
    </div>
</div>
