<x-app-layout>


    <div class="container mx-auto px-4 py-10 md:py-12">
        <div class="p-8 bg-white my-10 border border-gray-300 rounded rounded-t-lg ">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Modify Reward Status
            </h2>

            <div>
                <a href="/developer/rewards/update" class="text-blue-700">Update Tango Rewards</a>
            </div>

            <div name="description">
               
                <livewire:update-tangos/>

            </div>
        </div>
    </div>

</x-app-layout>
