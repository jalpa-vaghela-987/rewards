<div>

        <x-tour-modal wire:model="ShowProductTour">
            <x-slot name="slot">
                 <div class="p-3 md:p-4 bg-pink-100 border-b-2 border-pink-200 border-solid">
                    <h2 class="w-full text-2xl font-semibold text-center font-handwriting">Digital Group Cards</h2>
                </div>
                <div class="md:p-4 bg-white overflow-y-scroll" style="height: 32rem;">
                    <div class="p-2 m-1">
                       <div class="italic text-sm">
                           {{ appName() }} allows you to build digital group cards for any occasion. Whether it's a colleague's birthday, wedding day, or congratulations are in order— {{ appName() }} Group Cards can deliver a powerful message.
                       </div>
                       <h2 class="w-full text-xl font-semibold text-left font-handwriting mt-6">How do Group Cards Work?</h2>
                        <div class="text-sm mt-2">
                            <h4 class="text-lg font-semibold mt-2">Step 1: The Set Up</h4>
                            The group card process is straightforward and easy to follow. First, select your group card recipient and choose a theme from {{ appName() }}'s variety of customizable defaults or create something entirely new!
                            <h4 class="text-lg font-semibold mt-2">Step 2: Choose Contributors</h4>
                            Select who you would like to be able to contribute to the group card. You can choose individually, by team, or include the entire company. These users will be notified that they were invited to contribute to a new group card.
                            <h4 class="text-lg font-semibold mt-2">Step 3: Create</h4>
                            Users can include a meaningful message with the option to upload a photo or include a GIF.
                            <h4 class="text-lg font-semibold mt-2">Step 4: Share!</h4>
                            After you decide the card is ready to be shared with the recipient, preview the final product and send the card. {{ appName() }} will handle the delivery.
                         </div>
                       <h2 class="w-full text-xl font-semibold text-left font-handwriting mt-6">Check out an Example!</h2>
                       <div class="text-sm">
                            @include('home.group-card-snippet')
                         </div>

                </div>
            </div>

                 <div class="p-2 md:p-4 bg-blue-50 border-t-2 border-blue-100 border-solid">
                    <x-link-button wire:click="$set('ShowProductTour', false)">
                        Got it
                    </x-link-button>
                </div>

            </x-slot>


        </x-tour-modal>
</div>
