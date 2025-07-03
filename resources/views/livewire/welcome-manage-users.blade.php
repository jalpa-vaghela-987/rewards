<div>

        <x-tour-modal wire:model="ShowProductTour">
            <x-slot name="slot">
                 <div class="p-3 md:p-4 bg-pink-100 border-b-2 border-pink-200 border-solid">
                    <h2 class="w-full text-2xl font-semibold text-center font-handwriting">Populate {{ appName() }} & Build a Workplace Community</h2>
                </div>
                <div class="md:p-4 bg-white overflow-y-scroll" style="height: 32rem;">
                    <div class="p-2 m-1">
                       <div class="italic text-sm">
                           {{ appName() }} allows you to easily invite employees so you can start rewarding them for the hard work they put in everyday.
                       </div>
                       <h2 class="w-full text-xl font-semibold text-left font-handwriting mt-6">User Level & Role</h2>
                        <div class="text-sm mt-2">

                            <h4 class="text-lg font-semibold mt-2">User Level ({{ getReplacedWordOfKudos() }} Allowance)</h4>
                            Users receive {{ getReplacedWordOfKudos() }} to send to co-workers on the first of each month. {{ appName() }} allows you to set the amount or allowance of Kudos the user receives by selecting a level. <br><br>

                            Generally, more senior employees will have a higher level which allows them to give out more
                            {{ getReplacedWordOfKudos() }} each month. These levels are customizable in the Company Settings page.
                            <br><br>
                            In {{ appName() }}, 100 {{ getReplacedWordOfKudos() }} is equivalent to $1.00 worth of rewards.

                             <h4 class="text-lg font-semibold mt-2">Standard User or Administrator User</h4>
                            <div class="mb-1">{{ appName() }} defines two types of users at a company.</div>
                             <span class="font-bold">Standard Users</span> do not have the ability to modify company settings or invite other users, but have full platform capabilities. <br>
                            <span class="font-bold">Administrator Users</span> have full access to company settings, {{ appName() }} analytics, billing, and user management.

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
