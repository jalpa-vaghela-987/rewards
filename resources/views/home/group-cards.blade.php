<x-home-layout>
    <x-slot name="bg_url">
        /other/gifts/cartoon-people.jpg
    </x-slot>

    <x-slot name="section1">
        <div class="py-20 xl:py-32">
            <h1 class="ps-home-1405__title typ-hero-header bhrtyp-italic text-gray-900"
                style="font-size: 60px; line-height: 55px; text-align: center;">Robust Group Card Solution</h1>
            <div class="typ-subhead1 bhrtyp-center text-gray-800">{{ appName(true) }} allows you to send unlimited Group Cards to
                anyone for any occasion! All included.
            </div>
        </div>
    </x-slot>

    <x-slot name="section2">
        <div class="homeOverviewContent shadow-none flex flex-wrap">
            <div class="md:w-1/2 w-full text-center p-0 m-0 mb-10 md:mb-16 lg:mb-0">
                <img class="w-auto m-auto" alt="{{ appName(true) }} Overview" src="/scenes/rest-1.png"
                     data-src="/scenes/rest-1.png"
                     style="">
            </div>

            <!-- "/other/pink_sweater_v1.png" -->
            <div class="md:w-1/2 homeOverviewContent__left Animation__toRight">
                <h2 class="typ-title1 bhrcolor-gray12">Celebrate!</h2>
                <p class="bhrcolor-gray9">{{ appName(true) }} allows you to build Group Cards for any occasion. Whether it's a
                    colleague's
                    birthday, wedding day, or congratulations are in order— {{ appName(true) }} Group Cards can
                    deliver a powerful message. {{ appName(true) }} Group Cards allow you to enter a customizable
                    message, choose a variety of themes, and {{ appName(true) }} will take care of all the
                    administrative tasks.</p>
            </div>
        </div>
    </x-slot>

    <x-slot name="header3">
        <div class="homeFeatureTitle homeFeatureTitle--hiring">
            <h2 class="typ-stats bhrtyp-italic text-gray-600 pt-20">Capture Amazing Moments</h2>
        </div>
    </x-slot>

    <x-slot name="section3">
        <div class="homeFeatureContent">
            <div class="w-full">
                @include('home.group-card-snippet')
            </div>

            <div class="homeFeatureContentRight w-full mt-8 lg:mt-2  ">
                <h2 class="typ-title1 bhrcolor-gray12">Create & Customize!</h2>
                <p class="text-gray-800 homeFeatureContentRight__copy">
                    {{ appName(true) }} allows you to fully customize Group Gards of choose one of our many themes & backgrounds
                    to reflect any occasion. Contributors can upload their own media or choose dynamically from a
                    library of Gifs to help amplify the message.

                </p>
                <a class="Button bg-pink-400 m-auto lg:mx-0 mb-4 mt-2"
                   style="background: #F472B6;"
                   target="__blank" href="/group-card-example">View Full Card!</a>

            </div>
        </div>
    </x-slot>

    <x-slot name="header4">
        <div class="homeFeatureTitle homeFeatureTitle--hiring pt-32">
            <h2 class="typ-stats bhrtyp-italic text-blue-700 pt-20">Straightforward Selection Process</h2>
        </div>
    </x-slot>

    <x-slot name="section4">
        <div class="homeFeatureContent flex">
            <div class="w-full lg:w-1/2 xl:w-4/5 text-center lg:mr-10 p-0 m-0 mb-10 md:mb-16 lg:mb-0 mt-6 lg:-mt-20">
                <img src="/other/screenshots/card-add-people-2.png" class="shadow-xl lg:m-5 rounded-xl"
                     style="backface-visibility: hidden;">
            </div>

            <div class="homeFeatureContentRight w-full md:w-10/12 lg:w-1/2 lg:-mt-20">
                <p class="text-gray-700 homeFeatureContentRight__copy">
                    <h2 class="typ-title1 text-gray-700">{{ appName(true) }} Group Cards pairs perfectly with Teams and Rewards.</h2>
                    <p class="text-gray-700 homeFeatureContentRight__copy">
                        For all occasions that should be recongized in a group setting, {{ appName(true) }} Group Cards can help.
                        Utilize set teams to make sure no one gets left out and dynically add anyone at anytime to the card.<br>
                    </p>
                    <h2 class="typ-title1 text-gray-700">Share with all of your loved ones!</h2>
                    <p class="text-gray-700 homeFeatureContentRight__copy">
                        {{ appName(true) }} Group Cards can be shared externally with no login required. Share the most important
                        moments from work with the most important people in your life.
                    </p>
            </div>
        </div>
    </x-slot>
</x-home-layout>
