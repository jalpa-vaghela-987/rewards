<x-app-layout>
    <script src="https://cdn.rawgit.com/nnattawat/flip/master/dist/jquery.flip.min.js"></script>

    <div class="container mx-auto px-4 py-5 md:py-5">
        <div class="p-5 bg-white my-5 border border-gray-300 rounded rounded-t-lg ">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Rewards Summary for {{ auth()->user()->company->name }}
            </h2>

            <x-link-button href="/rewards/create/new" class="mt-3">
                Create New Custom Reward!
            </x-link-button>

            <livewire:manage-custom-rewards />

            <h2 class="italic text-sm text-gray-800 leading-tight my-1 mt-5 pt-2 border-t border-gray-200">
                Company Rewards Settings
            </h2>

            <livewire:company-reward-settings />
        </div>

        <div class="">
            <form action="" method="GET">
                <x-jet-label class="font-bold" for="currency" value="{{ __('Select Gift Card Currency') }}"/>
                <select name="currency"
                        class="border-gray-300 focus:border-indigo-300 focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mr-5 my-1 w-40 sm:w-38 md:w-28 lg:w-44"
                        onchange="this.form.submit()">
                    @foreach(\App\Models\Tango::all()->where('disable',0)->where('active',1)->pluck("currency")->flatten()->unique()->sort()->values()->all() as $currency)
                        <option
                            value="{{ $currency }}" {{ request('currency') === $currency  ? 'selected': '' }}>
                            {{ $currency }}
                        </option>
                    @endforeach
                </select>
            </form>
        </div>

        <h2 class="font-semibold text-lg text-gray-800 leading-tight my-2 pt-5 ">
            Custom {{ substr(Auth::user()->company->name, 0, 20) }} Rewards
        </h2>

        <h2 class="italic text-sm text-gray-800 leading-tight my-1 pt-2 border-t border-gray-500">
            Hover over the card to preview.
        </h2>

        <div class="text-xs italic w-full mb-3">
            {{ appName() }} allows admin users to create custom rewards that can be redeemed internally! These custom rewards can include local parter gift cards, perks, travel, and gift cards from corporate credit card points.
        </div>

        <livewire:custom-rewards-cards />

        <livewire:tango-card-list />

        <livewire:tango-card-list disabled="true" />

        <h2 class="font-semibold text-lg text-gray-800 leading-tight my-2 pt-5 ">
            Disabled Custom {{ substr(Auth::user()->company->name, 0, 20) }} Rewards
        </h2>

        <div class="space-y-5 border-b-2 border-gray-300 my-5"></div>

        <livewire:custom-rewards-cards :disabled=true />

        <div class="space-y-5 border-b-2 border-gray-300 my-10"></div>

        <script type="text/javascript">
            $('.gift_card').flip({
                trigger: 'hover'
            });
        </script>
    </div>
</x-app-layout>
