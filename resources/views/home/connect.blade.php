<x-home-layout>

<x-slot name="bg_url">
/scenes/meeting-1.png
</x-slot>

    <div class="theme-page">

        <x-slot name="section1">
            <div class="py-20 xl:py-32">
                <h1 class="ps-home-1405__title typ-hero-header bhrtyp-italic text-gray-900"
                    style="font-size: 60px; line-height: 55px; text-align: center;">Opt-in Automated Networking Capability</h1>
                <div class="typ-subhead1 bhrtyp-center bhrcolor-gray9">No hassle automated one-on-one chats to enhance workplace connections via email.
                </div>
            </div>
        </x-slot>


        <x-slot name="section2">



            <div class="homeFeatureTitle homeFeatureTitle--hiring">
                        <h2 class="typ-stats bhrtyp-italic text-pink-900 pt-20">Foster Mentorship</h2>
                    </div>


            <div class="homeOverviewContent shadow-none flex flex-wrap">
                <div class="lg:w-1/2 w-full text-center p-1 m-3 mb-10 md:mb-16 lg:mb-3 lg:-mt-14">
                    <img class="w-auto m-auto  shadow-xl rounded" alt="{{ appName(true) }} Overview" src="/other/screenshots/connect-2.png"
                         data-src="/scenes/meeting-1.png"
                         style="">
                </div>

                <!-- "/other/pink_sweater_v1.png" -->
                <div class="lg:w-1/2 homeOverviewContent__left Animation__toRight">
                    <h2 class="typ-title1 text-gray-700">{{ appName(true) }} Connect</h2>
                    <p class="text-gray-600">Our platform enables users to opt-in to allow one-on-one meetings with other members of your company. {{ appName(true) }} uses a personalized preference based match making process to automatically make connections and block off available meeting times for you.
                    <br><br> This easy to navigate system operates entirely via email calendar invitations and does not require any ongoing monitoring. </p>
                </div>
            </div>

        </x-slot>



    </div>


</x-home-layout>



