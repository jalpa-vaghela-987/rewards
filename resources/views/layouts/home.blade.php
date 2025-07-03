<x-guest-layout>

    @include('home.home-top')
       <!-- Global site tag (gtag.js) - Google Analytics -->


    <div class="home top-fade mt-32 lg:mt-1" >
       <div class="w-full" style="backdrop-filter: blur(4px); background: rgba(255,255,255,.5);">
            @if(isset($section1) || isset($largeSection))
            <section class="ps-home-1405 theme-section-1 " aria-label="" style="">
                @if(isset($largeSection))
                <div class="ps-home-1405__bgContainer js-parallax -mt-16 lg:-mt-24 xl:-mt-32 large-section-container" style="transform: translate3d(0px, 0px, 0px);">
                    <div class="ps-hps-home-1405__bg home_setup_desktop_4040 bg-gray-50"></div>

                    <div class="ps-hps-home-1405__content">
                        <div class="bhrsection-padding">
                            <div class="bhrsection-container-large bhrcolor-white">
                                <div class="ps-hps-home-1405__container m-auto mt-0">
                                    {{ $largeSection }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="ps-hps-home-1405__extra large-section-extra">
                    <img class="js-banner-blank" src="./public_files/blank-hero.png">
                </div>
                @else
                <div class="ps-home-1405__bgContainer js-parallax -mt-32 lg:-mt-32 xl:-mt-48" style="transform: translate3d(0px, 0px, 0px);">
                    <div class="ps-hps-home-1405__bg home_setup_desktop_4040 bg-gray-50"></div>

                    <div class="ps-hps-home-1405__content">
                        <div class="bhrsection-padding">
                            <div class="bhrsection-container-large bhrcolor-white">
                                <div class="ps-hps-home-1405__container m-auto mt-0">
                                    {{ $section1 }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="ps-hps-home-1405__extra">
                    <img class="js-banner-blank" src="./public_files/blank-hero.png">
                </div>
                @endif
            </section>
            @endif

            @if(isset($section2))
            <section class="homeFeaturedLogos theme-section-2" arial-label="">
                <div class="homeFeaturedLogos__curveContainer">
                    <img class="homeFeaturedLogos__curve" src="./public_files/product-top-pink-nl.png"
                         alt="">
                </div>
 <!--                <div class="homeFeaturedLogos__bottom h-20">
                    <div class="bhrsection-padding">
                        <div class="bhrsection-container-large homeFeaturedLogos__wrapper">
                            <div class="homeFeaturedLogos__container">
                                <div class="homeFeaturedLogos__title typ-subhead1 bhrcolor-gray9 bhrtyp-italic"></div>
                                <div class="homeFeaturedLogos__content">

                                </div>
                            </div>
                        </div>
                    </div>
                </div> -->
            </section>
            @endif


            <div class="homeRelative bhrcolor-white-background theme-section-3">
                @if(isset($section2))
                <section class="homeOverview" aria-label="What can <?php appName() ?> do for you?">
                    <div class="homeOverview__curveContainer">
                        <img class="homeOverview__curve lazyloaded" data-src="/./public_files/home-curve2-pink-nl.png"
                             alt="overview curve shape" src="./public_files/home-curve2-pink-nl.png">
                    </div>
                    <div class="bhrsection-padding homeOverview__overflow">
                        <div class="bhrsection-container-large">
                            <div class="homeOverview__container js-in-viewport Animation--active">
                                @if(isset($header2)) {{$header2}} @endif

                                @if(isset($section2)) {{$section2}} @endif
                            </div>
                        </div>
                    </div>
                </section>
                @endif
            </div>

        <div class="homeRelative bhrcolor-white-background theme-section-3">
                @if(isset($header3))
                <section class="homeFeature homeFeature--people" aria-label="">
                    <div class="bhrsection-container-large bhrsection-padding homeFeature__container">
                        @if(isset($header3)) {{$header3}} @endif

                        <div class="homeFeatureContent relative z-10">
                            <!-- <div class="lg:w-1/2 w-full  text-center mr-10 p-0 m-0"> -->

                            @if(isset($section3)) {{$section3}} @endif
                        </div>
                    </div>
                </section>
                @endif
        </div>
         <div class="homeRelative bhrcolor-white-background theme-section-3">
                @if(isset($section4))
                <section class="bg-blue-50" aria-label="What can <?php appName() ?> do for you?">
                    <div class="WaveTop--onboarding bg-white">
                        <img class="WaveTop__image lazyloaded" data-src="/curves/curve5-blue-50.png" src="/curves/curve5-blue-50.png">
                    </div>

                    <div class="bhrsection-padding homeOverview__overflow">
                        <div class="bhrsection-container-large">
                            <div class="homeOverview__container js-in-viewport Animation--active">
                                @if(isset($header4)) {{$header4}} @endif

                                @if(isset($section4)) {{$section4}} @endif
                            </div>
                        </div>
                    </div>

                    <div class="Wave WaveBottom WaveBottom--onboarding">
                        <img class="WaveBottom__image ls-is-cached lazyloaded" data-src="/curves/curve6-white.png" alt="bottom leaf" src="/curves/curve6-white.png">
                    </div>
                </section>
                @endif

                @if(!isset($hide_bottom))
                    @include('home.trial-bottom')
                @endif
            </div>
        </div>
    </div>



    <!-- ///////////////////////// Nick Css -->

    @include('home.home-css')

    <style type="text/css">

        .theme-section-1 .ps-hps-home-1405__extra {
            @if(isset($largeSection))
            height: 800px !important; @else height: 600px !important;
            @endif
            min-height: 600px;
            overflow: hidden;
        }
         @media screen and (max-width: 1023px){
            .theme-section-1 .ps-hps-home-1405__extra {
                @if(isset($largeSection))
                    height: 0px !important;
                    min-height: 0px !important;
                @else
                    height: 400px !important;
                    min-height: 400px;
                @endif
            }
        }
         @media screen and (max-width: 800px){
             .theme-section-1 .ps-hps-home-1405__extra {
            height: 400px;
            min-height: 400px;
            }
        }

         @media screen and (max-width: 560px){
             .theme-section-1 .ps-hps-home-1405__extra {
            height: 100px;
            min-height: 100px;
            }
        }

        @media screen and (max-width: 480px){
            .theme-section-1 .ps-hps-home-1405__extra {
                height: 20px;
                min-height: 20px;
            }
        }

        .top-fade{
            background: -webkit-linear-gradient(270deg, #EFF6FF, white);
            background: -moz-linear-gradient(270deg, #EFF6FF 0, white 100%);
            background: -o-linear-gradient(270deg, #EFF6FF 0, white 100%);
            background: -ms-linear-gradient(270deg, #EFF6FF 0, white 100%);
            background: linear-gradient(180deg, #EFF6FF, white);

            @if(isset($bg_url))
            background: url("{{ $bg_url }}");
            @endif



            background-size: cover;
            background-attachment: fixed;
            background-repeat: no-repeat;

            @if(isset($bg_pos))
            {{$bg_pos}}
            @else
            background-position: top;
            @endif

            /*background: #c0d0e9;
            background: linear-gradient(180deg, #c0d0e9, #c0d0e9, #c0d0e9, rgba(192,208,233,.3));*/
            /*linear-gradient(0deg, #bccce6, #d8e5f8)*/
        }

        @if(isset($largeSection))
            .theme-section-1 .ps-home-1405__bgContainer {
                height: 920px !important;
            }

            @media screen and (max-width: 1200px) {
                .theme-section-1 .ps-home-1405__bgContainer {
                    height: 1080px !important;
                }
            }

            @media screen and (max-width: 1023px) {
                .theme-section-1 .ps-home-1405__bgContainer {
                    height: 800px !important;
                }
            }

            @media screen and (max-width: 560px) {
                .theme-section-1 {
                    padding-bottom: 0px;
                }
            }
        @endif
        /*section.ps-home-1405 .theme-section-1  > .large-section-container {*/
        /*    height: 920px !important;*/
        /*}*/

    </style>
</x-guest-layout>
