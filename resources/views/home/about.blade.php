<x-home-layout>

     <x-slot name="bg_url">
/other/gifts/wood.jpg
</x-slot>

<x-slot name="bg_pos">
background-position: center -180px;
}
</x-slot>

        <x-slot name="section1">
            <div class="py-20 xl:py-32">
                <h1 class="ps-home-1405__title typ-hero-header bhrtyp-italic text-gray-900"
                    style="font-size: 60px; line-height: 55px; text-align: center;">About {{ appName(true) }}</h1>
                <div class="typ-subhead1 bhrtyp-center text-gray-800">{{ appName(true) }} is a small team with the goal to
                    bring positivity to the workplace.
                </div>
            </div>
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
                        <h3 class="text-2xl mb-5 font-semibold text-gray-700 font-handwriting">{{ appName(true) }} was founded with the ambitious goal to make all employees at a company feel valued.</h3>
                        <div class="my-5">{{ appName(true) }} is proudly a Boston based company.</div>
                        <div class="text-gray-800 font-semibold">345 Harrison Ave, Boston, MA 02118 </div>
                    </div>


                </div>
            </div>

        </x-slot>



        <x-slot name="header3">

             <div class="homeFeatureTitle homeFeatureTitle--hiring">
                        <h2 class="typ-stats bhrtyp-italic text-gray-600 pt-20">Inspiration</h2>
                    </div>
        </x-slot>


         <x-slot name="section3">


                    <div class="homeFeatureContent flex pb-16">
                        <div class="w-full lg:w-1/2 xl:w-4/5 text-center lg:mr-10 p-0 m-0 mb-10 md:mb-16 lg:mb-0 mt-6 lg:mt-0">
                        <img class="w-full" alt="{{ appName(true) }} Overview" src="/scenes/rest-1.png"
                             data-src="/other/screenshots/kudos-feed-1.png">
                        </div>
                        <div class="homeFeatureContentRight w-full md:w-10/12 lg:w-1/2">
                            <p class="text-gray-800 homeFeatureContentRight__copy mt-16  p-3 md:p-1">
                           Our team realized the severe lack of engagement between employees, especially in 2020 with fully remote workplaces. {{ appName(true) }} believes a single act of kindness benefits not only employee's wellbeing, but also other factors like retention, sense of community, quality of work, mental health, and workplace inclusion. <br><br>We hope every company will implement an employee rewards platform.
                            </p>

                        </div>
                    </div>


        </x-slot>




</x-home-layout>
