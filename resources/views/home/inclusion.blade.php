<x-home-layout>

    <x-slot name="bg_url">
/other/gifts/group.jpg
</x-slot>

 <x-slot name="bg_pos">
background-position: center 100px;
}

@media only screen and (min-width: 800px){
    .top-fade{
    background-size: contain;
    }
}
</x-slot>


    <div class="theme-page">

        <x-slot name="section1">
            <div class="py-20 xl:py-32">
                <h1 class="ps-home-1405__title typ-hero-header bhrtyp-italic text-gray-900"
                    style="font-size: 60px; line-height: 55px; text-align: center;">Create an Inclusive Culture</h1>
                <div class="typ-subhead1 bhrtyp-center bhrcolor-gray9">The {{ appName(true) }} platform allows every member of your team feel valued.
                </div>
            </div>
        </x-slot>


        <x-slot name="section2">

                <div class="homeFeatureTitle homeFeatureTitle--hiring">
                        <h2 class="typ-stats bhrtyp-italic text-gray-900 pt-20">Give Employees a Voice</h2>
                    </div>


            <div class="homeOverviewContent shadow-none flex flex-wrap">
                <div class="md:w-1/2 w-full text-center p-0 m-0 mb-10 md:mb-16 lg:mb-0">
                    <img class="w-auto m-auto" alt="{{ appName(true) }} Overview" src="/scenes/rest-1.png"
                         data-src="/scenes/rest-1.png"
                         style="">
                </div>

                <!-- "/other/pink_sweater_v1.png" -->
                <div class="md:w-1/2 homeOverviewContent__left Animation__toRight ml-1">
                    <h2 class="typ-title1 bhrcolor-gray12">Engage with Every Employee</h2>
                    <p class="bhrcolor-gray9">By utilizing the features {{ appName(true) }} has to offer, you are enabling all employees to interact much more freely and in an inclusive manner. PerkSweet encourages interaction across all divisions and seniority levels.<br> <br> Leave no employee behind and easily engage with all of your employees.
                </div>
            </div>

        </x-slot>



    </div>


</x-home-layout>
