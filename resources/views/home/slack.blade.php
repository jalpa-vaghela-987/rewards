<x-home-layout>

    <div class="theme-page">

        <x-slot name="section1">
            <div class="py-5 xl:py-12 text-center">
                <div class="text-center my-32 py-10 md:flex m-auto items-center justify-center
                ">
                <div>
                <img src="/other/perksweet2.png" style="height: 150px;">
                </div>
                <h1 class="ps-home-1405__title typ-hero-header bhrtyp-italic text-gray-900 pt-4 md:pt-16"
                    style="font-size: 60px; line-height: 55px; text-align: center;">+</h1>
                <div class="md:mx-10 md:mt-10">
                <img src="/other/Slack_logo.png" style="height: 80px;">
                </div>
                </div>
                <div class="typ-subhead1 bhrtyp-center text-gray-800 -my-10" style="margin: -50px 0 0;">Amplify the {{ appName() }} experience with Slack. <br>{{ appName() }} integrates seamlessly with Slack allowing you to leverage the
                    {{ appName() }} application without changing your daily workflow.
                </div>
            </div>
        </x-slot>


        <x-slot name="section2">
            <h3 class="typ-section-header bhrtyp-italic bhrtyp-center bhrcolor-gray12">The {{ appName() }} Slack App</h3>

            <div class="homeOverviewContent shadow-none flex flex-wrap">
                <div class="md:w-1/2 w-full text-center p-0 m-0 md:m-6 -mt-10 md:mb-10 md:mb-16 lg:mb-0">
                    <img class="w-auto m-auto rounded shadow" alt="{{ appName() }} Overview" src="/other/screenshots/slack3.png"
                         data-src="/scenes/rest-1.png"
                         style="">
                </div>

                <!-- "/other/pink_sweater_v1.png" -->

                <div class="md:w-1/2 homeOverviewContent__left Animation__toRight mt-14">

                    <!-- <h2 class="typ-title1 bhrcolor-gray12">The {{ appName() }} Slack App</h2> -->
                    <p class="text-gray-900">
                        The {{ appName() }} Slack app allows users to see Kudos sent on a company channel. This allows everyone to easily chime in and continue the recognition right from Slack!
                    </p>

                     <div class="homeFeatureContentRightLinks">
                                <a class="text-center Button" href="https://slack.com/apps/A023E3TJ2B1-perksweet?tab=more_info" target="__blank">View us on the Slack App Store!</a>
                            </div>
                     <p class="text-gray-900">
                        In order to integrate Slack with {{ appName() }}, administrator users can navigate to your <a href="/company/manage" class="text-blue-700">company settings page</a> and select the <span class="italic text-black font-semibold">Add to Slack</span> button. From there, approve PerkSweer and choose a channel to post on! That's it, you're all done.
                    </p>
                     <p class="text-gray-900 italic">
                         {{ appName() }} will not be able to read messages or modify any content. {{ appName() }} will only be authorized to contribute messages to the channel specified.
                     </p>
                </div>
            </div>

        </x-slot>



    </div>


</x-home-layout>
