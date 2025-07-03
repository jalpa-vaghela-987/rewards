<div>

        <x-tour-modal wire:model="ShowProductTour">
            <x-slot name="slot">
                 <div class="p-3 md:p-4 bg-pink-100 border-b-2 border-pink-200 border-solid">
                    <h2 class="w-full text-2xl font-semibold text-center font-handwriting">Giving {{ getReplacedWordOfKudos() }}!</h2>
                </div>
                <div class="md:p-4 bg-white overflow-y-scroll" style="height: 32rem;">
                    <div class="p-2 m-1">
                       <div class="italic text-sm">
                           When giving {{ getReplacedWordOfKudos() }}, {{ appName() }} allows you to choose between giving regular {{ getReplacedWordOfKudos() }} or super {{ getReplacedWordOfKudos() }}. You should also include a meaningful message and don't be afraid to use emojis! <span class="ql-emojiblot" data-name="sunglasses">﻿<span contenteditable="false"><span class="ap ap-sunglasses">😎</span></span>﻿</span>
                       </div>
                       <h2 class="w-full text-xl font-semibold text-left font-handwriting mt-6">When should I send {{ getReplacedWordOfKudos() }}?</h2>
                        <div class="text-sm">
                            <div class="text-md font-semibold mt-2">Send {{ getReplacedWordOfKudos() }} for anything!</div>
                            <ul class="list-disc p-1 m-1 leading-6">
                                <li>Helping out on a side project</li>
                                <li>Closing a sale</li>
                                <li>Taking extra care on an assignment</li>
                                <li>Showing initiative</li>
                            </ul>
                         </div>
                       <h2 class="w-full text-xl font-semibold text-left font-handwriting mt-6">Checkout an Example</h2>
                       <img class="w-full mt-3 shadow rounded" alt="{{ appName() }} Overview" src="/other/screenshots/kudos-create.png"
                             data-src="/other/screenshots/kudos-feed-1.png">


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
