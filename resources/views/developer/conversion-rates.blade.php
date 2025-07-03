<x-app-layout>
    <div class="container mx-auto px-4 py-10 md:py-12">
        <div class="flex flex-col">
            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                    <div class="w-full mb-5">Conversion Rates</div>
                    @forelse($conversionRates as $conversionRate)
                        <livewire:conversion-rate :conversionRate="$conversionRate"/>
                    @empty
                        <div class="flex items-center justify-center text-gray-600 h-8">
                            <span class="mr-5"><i class="fa fa-envelope"></i></span>
                            No Conversion Rates Found ...
                        </div>
                    @endforelse

                    {!! $conversionRates->links() !!}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
