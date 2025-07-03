<x-home-layout>


<x-slot name="bg_url">
/other/gifts/leaving.jpg
</x-slot>

<x-slot name="bg_pos">
background-position: center -200px;
</x-slot>


    <div class="theme-page">
        <x-slot name="section1">

            <div class="py-20 xl:py-32">
                <h1 class="homeHero__title typ-hero-header bhrtyp-italic text-gray-900"
                    style="font-size: 40px; line-height: 55px; text-align: center;">Lower Voluntary Turnover & Increase Productivity</h1>
                <div class="typ-subhead1 bhrtyp-center text-gray-900 italic">Companies with highly effective recognition programs focused on employee engagement have 31% lower voluntary turnover
                    <br>
                    <a class="text-sm italic font-normal" href="https://www.gallup.com/workplace/236441/employee-recognition-low-cost-high-impact.aspx" target="_blank">According to Gallup</a>
                </div>
            </div>

        </x-slot>




        <x-slot name="section2">

            <div class="homeFeatureTitle homeFeatureTitle--hiring">
                        <h2 class="typ-stats bhrtyp-italic text-gray-900 pt-20">Reduce Turnover</h2>
                    </div>

            <div class="homeOverviewContent shadow-none flex flex-wrap">
                <div class="md:w-1/2 w-full text-center p-0 m-0 mb-10 md:mb-16 lg:mb-0">
                <img class="w-auto m-auto mt-12" alt="{{ appName(true) }} Overview" src="/scenes/meeting-1.png"
                     data-src="/scenes/meeting-1.png"
                     style="">
                </div>

                <!-- "/other/pink_sweater_v1.png" -->
                <div class="md:w-1/2 homeOverviewContent__left Animation__toRight p-2 px-4 lg:ml-24">
                    <h2 class="typ-title1 text-gray-800">Create an Inviting Culture</h2>
                    <p class="text-gray-700">
                        Research consistently shows that companies with employee recognition systems keep their best performing people the longest & create a positive environment for new top talent.
                    </p>
                        <p class="italic text-gray-700">According to <a class="" target="_blank" href="https://www.jobvite.com/wp-content/uploads/2018/04/2018_Job_Seeker_Nation_Study.pdf">Jobvite</a>, 32% of new hires who quit within the first 90 days of their employment cite company culture as their main reason for leaving.
                    </p>
                </div>
            </div>

        </x-slot>


        <x-slot name="header3">

             <div class="homeFeatureTitle homeFeatureTitle--hiring">
                        <h2 class="typ-stats bhrtyp-italic text-gray-600 pt-20">Increase Productivity</h2>
                    </div>
        </x-slot>


         <x-slot name="section3">


                    <div class="homeFeatureContent flex pb-16">
                        <div class="w-full lg:w-1/2 text-center lg:mr-10 p-0 m-0 mb-10 md:mb-16 lg:mb-0 mt-6 lg:mt-0">
                        <img class="w-full md:w-10/12 lg:w-full -mt-12 rounded" alt="{{ appName(true) }} Overview" src="/other/gifts/gears-3.png"
                             data-src="/other/gifts/gears-3.jpg">
                        </div>
                        <div class="homeFeatureContentRight w-full md:w-10/12 lg:w-1/2">
                            <p class="text-gray-800 homeFeatureContentRight__copy">
                             Positive feedback from {{ appName(true) }} does more than just help build a strong company culture. Shorter term rewards like Kudos can help increase employee productivity too.
                             <br> <br>
                             <p class="text-gray-800 homeFeatureContentRight__copy italic">
                             A recent <a
                         href="https://blog.hubspot.com/marketing/11-employee-feedback-statistics"
                         target="_blank" >HubSpot Study </a> found that 69% of workers said they would work harder if they were better appreciated. Gallup also found that companies with highly engaged workforces scored 17% higher on productivity measures.
                            </p>
                        </div>
                    </div>


        </x-slot>




               <x-slot name="header4">

             <div class="homeFeatureTitle homeFeatureTitle--hiring pt-32">
                        <h2 class="typ-stats bhrtyp-italic text-blue-700 pt-20">High Return on Spend</h2>
                    </div>
        </x-slot>


         <x-slot name="section4">

                    <div class="homeFeatureContent flex">
                        <div class="w-full lg:w-1/2 text-center lg:mr-10 p-0 m-0 mb-10 md:mb-16 lg:mb-0 mt-6 lg:-mt-20">
                             <img class="w-full md:w-10/12 lg:w-full rounded" alt="{{ appName(true) }} Overview" src="/other/gifts/chart-3.png"
                             data-src="/other/gifts/check.png">

                        </div>
                        <div class="homeFeatureContentRight w-full md:w-10/12 lg:w-1/2 lg:-mt-20">
                            <p class="text-gray-700 homeFeatureContentRight__copy">

                              <h2 class="typ-title1 text-gray-700">Reward Employees Directly</h2>
                               <p class="text-gray-700 homeFeatureContentRight__copy">

                              Spend goes directly to the employees who appreciate it most. {{ appName(true) }} is a low cost way to support employees everyday in a fair and positive way. Our platform allows you to easily monitor and measure employee engagement.

                            </p>

                            </p>

                            <h2 class="typ-title1 text-gray-700">Lower Cost Using In-House Rewards</h2>

                            <p class="text-gray-700 homeFeatureContentRight__copy">

                                {{ appName(true) }} allows you to create unlimited custom rewards for items your company already owns. These could include company swag, company gift cards, vacation days, remote working weeks, and much much more! This allows you to benefit your employees for only the low subscription cost of the platform and no outside rewards.

                            </p>

                        </div>
                    </div>


        </x-slot>



    </div>

</x-home-layout>
