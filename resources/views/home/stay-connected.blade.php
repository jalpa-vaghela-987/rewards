<x-home-layout>

<x-slot name="bg_url">
/scenes/rest-1.png
</x-slot>

    <div class="theme-page">
        <x-slot name="section1">
            <div class="py-20 xl:py-32">
                <h1 class="homeHero__title typ-hero-header bhrtyp-italic text-gray-900"
                    style="font-size: 60px; line-height: 55px; text-align: center;">Stay Connected</h1>
                <div class="typ-subhead1 bhrtyp-center text-gray-800">{{ appName() }} provides a full "sweet" of features to help
                    teams stay connect. Whether remote or in-person, {{ appName() }} can help!
                </div>
            </div>
        </x-slot>

        <x-slot name="section2">

            <div class="homeOverviewContent shadow-none flex flex-wrap">
                <div class="md:w-1/2 w-full text-center p-0 m-0 mb-10 md:mb-16 lg:mb-0">
                    <img class="w-auto m-auto" alt="{{ appName() }} Overview" src="/scenes/rest-1.png"
                         data-src="/scenes/rest-1.png"
                         style="">
                </div>

                <!-- "/other/pink_sweater_v1.png" -->
                <div class="md:w-1/2 homeOverviewContent__left Animation__toRight">
                    <h2 class="typ-title1 bhrcolor-gray12">Easily Stay Connected</h2>
                    <p class="bhrcolor-gray9">{{ appName() }} effortlessly helps your team stay engaged and connected. By using {{ appName() }} you enable your employees to interact in ways you may not have ever foreseen. Through {{ appName() }} Kudos, Cards, and One-on-Ones your employees will feel at home.
                </div>
            </div>

        </x-slot>

    </div>



</x-home-layout>
