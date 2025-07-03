  <section class="homeFeature homeFeature--culture"
  style="padding-top:200px;"
  aria-label="Culture">
<div class="homeFeature__image homeFeature__image--culture homeFeature__image--center bhrsection-padding">
    <!-- <img class="lazyloaded" data-src="./scenes/gift-1.png" src="./scenes/gift-1.png"> -->
</div>

<div class="homeLearn__container bhrsection-padding">
    <h4 class="typ-section-header text-gray-800">Interested in {{ appName(true) }}?</h4>
    <h5 class="typ-section-subhead text-gray-800">Enroll in our 30 day free trial; Immediate sign up with no credit card required.</h5>
    <a class="homeLearn__button Button" style="background: #F472B6;" href="https://meetings.salesmate.io/meetings/#/perksweet/scheduler/perksweet-with-craig"  target="_blank" >Book a Demo</a>
    <a class="homeLearn__button Button" href="{{url('register/company')}}">Try It Free!</a>


</div>

<div class="m-auto w-2/3 sm:w-1/2 text-center mt-16" style="min-width: 200px;">
   @livewire('try-it-for-free')
</div>
</section>
