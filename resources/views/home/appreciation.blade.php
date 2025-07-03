<x-home-layout>

    <x-slot name="bg_url">
/other/gifts/many-gifts.jpg
</x-slot>


    <div class="theme-page">
        <x-slot name="section1">
            <div class="py-20 xl:py-32">
                <h1 class="ps-home-1405__title typ-hero-header bhrtyp-italic text-gray-900"
                    style="font-size: 60px; line-height: 55px; text-align: center;">Show Appreciation</h1>
                <div class="typ-subhead1 bhrtyp-center text-gray-800">Employee rewards platform that allows you to show your appreciation for those that go above and beyond everyday.
                </div>
            </div>
        </x-slot>

        <x-slot name="header2">
            <h3 class="typ-section-header bhrtyp-italic bhrtyp-center bhrcolor-gray12">Build a Workplace
                Community.</h3>
          <!--   <div class="typ-subhead1 bhrtyp-center bhrcolor-gray9">How can {{ appName(true) }} help?</div>
 -->
        </x-slot>


        <x-slot name="section2">

            <div class="homeOverviewContent shadow-none flex flex-wrap">
                <div class="lg:w-1/2 w-full text-center p-0 m-0 mb-10 md:mb-16 lg:mb-0">
                    <img class="w-auto m-auto" alt="{{ appName(true) }} Overview" src="/scenes/gift-1.png"
                         data-src="/scenes/gift-1.png"
                         style="">
                </div>

                <!-- "/other/pink_sweater_v1.png" -->
                <div class="lg:w-1/2 homeOverviewContent__left">

                    <div class="m-1 sm:m-3 p-1 sm:p-3">
                        <h3 class="text-lg mb-5 font-semibold text-gray-700">Our platform gives your team a variety of ways to show appreciation. </h3>
                        <ol class="list-disc leading-8 ml-5">
                            <li class="text-blue-500"><div class="text-gray-800"> Publically reward employees with Kudos </div></li>
                            <li class="text-blue-500"><div class="text-gray-800"> Send group cards for any occasion to anyone </div></li>
                            <li class="text-blue-500"><div class="text-gray-800"> Never forget birthdays and work anniversaries special with automatic reminders </div></li>
                        </ol>
                    </div>


                </div>
            </div>

        </x-slot>



        <x-slot name="header3">

             <div class="homeFeatureTitle homeFeatureTitle--hiring">
                        <h2 class="typ-stats bhrtyp-italic text-gray-600 pt-20">Spend on Your Employees Directly</h2>
                    </div>
        </x-slot>


         <x-slot name="section3">


                    <div class="homeFeatureContent flex pb-16">
                        <div class="w-full lg:w-1/2 xl:w-4/5 text-center lg:mr-10 p-0 m-0 mb-10 md:mb-16 lg:mb-0 mt-6 lg:mt-0">
                        <img class="w-2/3 md:w-2/3 -mt-12" alt="{{ appName(true) }} Overview" src="/other/gifts/ribbon.png"
                             data-src="/other/screenshots/kudos-feed-1.png">
                        </div>
                        <div class="homeFeatureContentRight w-full md:w-10/12 lg:w-1/2">
                            <p class="text-gray-800 homeFeatureContentRight__copy mt-16  p-3 md:p-1">
                            {{ appName(true) }} enables you to allocate spend back straight back to your employees and allows them to use it how they want! <br><br>
                            With 50+ partner gift card options or unlimited custom rewards, your employees will love redeeming those well deserved Kudos for real rewards.

                            </p>

                        </div>
                    </div>


        </x-slot>




               <x-slot name="header4">

             <div class="homeFeatureTitle homeFeatureTitle--hiring pt-32 text-center">
                        <h2 class="typ-stats bhrtyp-italic text-blue-700 pt-20">Reward Birthdays & Work Anniversaries</h2>
                    </div>
        </x-slot>


         <x-slot name="section4">

             <div class="homeFeatureContent flex pb-16">
                        <div class="w-full lg:w-1/2 xl:w-4/5 text-center lg:mr-10 p-0 m-0 mb-10 md:mb-16 lg:mb-0 mt-6 lg:mt-0">
                        <img class="w-full -mt-12" alt="{{ appName(true) }} Overview" src="/scenes/rest-1.png"
                             data-src="/other/screenshots/kudos-feed-1.png">
                        </div>
                        <div class="homeFeatureContentRight w-full md:w-10/12 lg:w-1/2">
                            <p class="text-gray-800 homeFeatureContentRight__copy mt-16 p-3 md:p-1">
                           {{ appName(true) }} easily allows you to automatically provide Kudos and public recognition to employees on birthdays and work anniversaries. Show your people how much you value them on the days that matter most and reward those who stick around the longest!
                           <br><br>
                           Employees will be reminded of these special days and encouraged to send group cards. An easy way to take a major step towards a culture built on positivity.

                            </p>

                        </div>
                    </div>


        </x-slot>



    </div>

</x-home-layout>
