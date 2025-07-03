<div>
    <x-tour-modal wire:model="ShowProductTour">
        <x-slot name="slot">
            <div class="p-3 md:p-4 bg-pink-100 border-b-2 border-pink-200 border-solid">
                <h2 class="w-full text-2xl font-semibold text-center font-handwriting">Explore your {{ getReplacedWordOfKudos() }} Wallet!</h2>
            </div>
            <div class="md:p-4 bg-white overflow-y-scroll" style="height: 32rem;">
                <div class="p-2 m-1">
                    <div class="italic text-sm">
                        From your {{ getReplacedWordOfKudos() }} Wallet, any {{ getReplacedWordOfKudos() }} you received from coworkers can be redeemed for real rewards!
                        Your {{ getReplacedWordOfKudos() }} Wallet will also display previously redeemed rewards and a summary of {{ getReplacedWordOfKudos() }} you
                        received along with how you spent them.
                    </div>
                    <h2 class="w-full text-xl font-semibold text-left font-handwriting mt-6">Where are the rewards?</h2>
                    <div class="text-sm">
                        If you do not see any rewards yet don't worry. Companies often take some time to populate
                        {{ appName() }} with rewards for their employees, but do not let that stop you from earning valuable
                        {{ getReplacedWordOfKudos() }}!
                    </div>
                    <h2 class="w-full text-xl font-semibold text-left font-handwriting mt-6">What can I redeem my {{ getReplacedWordOfKudos() }}
                        for?</h2>
                    <div class="text-sm">
                        {{ appName() }} partners with 50+ brands that enable you to instantly redeem {{ getReplacedWordOfKudos() }} for gift cards.
                        <br>
                        Your company may also choose to include custom rewards like company perks, company swag, custom
                        gift cards ect.
                    </div>
                    <div class="w-full text-center grid grid-cols-1 md:grid-cols-2 ">
                             <img style="height: 150px;"
                             src="https://dwwvg90koz96l.cloudfront.net/images/brands/b942204-300w-326ppi.png"
                             class="shadow-xl m-5 rounded-xl" style="backface-visibility: hidden;">
                        <img style="height: 150px;"
                             src="https://dwwvg90koz96l.cloudfront.net/images/brands/b328386-300w-326ppi.png"
                             class="shadow-xl m-5 rounded-xl" style="backface-visibility: hidden;">
                        <img style="height: 150px;"
                             src="https://dwwvg90koz96l.cloudfront.net/images/brands/b663882-300w-326ppi.png"
                             class="shadow-xl m-5 rounded-xl" style="backface-visibility: hidden;">
                        <img style="height: 150px;"
                             src="https://dwwvg90koz96l.cloudfront.net/images/brands/b314169-300w-326ppi.png"
                             class="shadow-xl m-5 rounded-xl" style="backface-visibility: hidden;">
                        <img style="height: 150px;"
                             src="https://dwwvg90koz96l.cloudfront.net/images/brands/b750202-300w-326ppi.png"
                             class="shadow-xl m-5 rounded-xl" style="backface-visibility: hidden;">
                        <img style="height: 150px;"
                             src="https://dwwvg90koz96l.cloudfront.net/images/brands/b300130-300w-326ppi.png"
                             class="shadow-xl m-5 rounded-xl" style="backface-visibility: hidden;">
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
