<x-guest-layout>

    @include('home.home-top')

 <div class="homeFeaturedLogos__curveContainer">
    <img class="homeFeaturedLogos__curve" src="/curves/curve3-flipped-pink-v.png"
                         alt="">
</div>
<div class="text-center py-10 md:flex">
<div class="w-full md:w-1/3 text-left my-24">
    <div class="text-xl px-3 md:px-8 font-semibold">Still have questions?</div>
    <div class="mb-8 mt-3 px-3 md:px-8 w-full">Don't worry, {{ appName(true) }} support can help.</div>
    <div class="my-3 px-3 md:px-8">
        <a class="text-md p-1 py-3 sm:p-3 sm:px-6 rounded-xl border-2 border-pink-500 border-solid bg-white-200 text-pink-500 hover:bg-pink-500 hover:text-white hover:border-pink-500"
        style="font-family: Montserrat, Lato, Arial, Helvetica, sans-serif;
                        font-size: 15px;
                        font-weight: 600;
                        "
                         href="mailto:support@perksweet.com">
                         Contact Support
        </a>
    </div>
</div>
    <div class="w-full md:w-2/3 my-20">
    <h2 class="typ-hero-header" style="font-size: 60px; line-height: 55px; text-align: center;">Frequently Asked Questions</h2>
<div class="w-full p-2 md:p-4 mt-2">


   @include('support.slider',['question'=>"What is ". appName(true) ."?",
   'answer'=>appName(true)." is an employee engagement & rewards platform that lets you easily say thank you, congrats, farewell, great job, and much more to your team."])


   @include('support.slider',['question'=>"Who is ". appName(true) ." for?",
   'answer'=>appName(true)." is built for all businesses big & small who want access to a robust employee engagement & rewards platform at an affordable price. ". appName(true) ." serves businesses in all industries."])


   @include('support.slider',['question'=>"Is ". appName(true) ." hard to use?",
   'answer'=>appName(true)." was designed with simplicity in mind. The rewards process is intuitive and the entire platform works the same on any device."])

    @include('support.slider',['question'=>"What are " . getReplacedWordOfKudos(true) . "?",
   'answer'=>appName(true)." uses virtual rewards called “" . getReplacedWordOfKudos(true) . "” to facilitate public recognition for excellent behavior. Employees receive a monthly allowance of Kudos to give out. (e.g. 1,000 Kudos worth $10) Once you receive Kudos, you can exchange them for real rewards!
"])


   @include('support.slider',['question'=>"Does it cost me more to add more users?",
   'answer'=>"Yes, a subscription to ". appName(true) ." charges on a per user basis. Adding a new user will add the additional cost of that user to the following month's subscription charge."])

 @include('support.slider',['question'=>"Can I cancel anytime?",
   'answer'=>"Yes, you have the option to cancel your subscription at any time. Cancelling your plan comes into effect the following month."])

    @include('support.slider',['question'=>"By signing up, what am I committing to?",
   'answer'=>"There is zero commitment on ". appName(true) .", cancel anytime with no questions asked and no need to contact ". appName(true) ."."])


   @include('support.slider',['question'=>"Is ". appName(true) ." secure?",
   'answer'=>"Yes, ". appName(true) ." partners with Stripe, a highly reputable payment solution provider, for all subscription and reward funding. ". appName(true) ." does not store nor have access to the financial data of any customers."])

   @include('support.slider',['question'=>"What payments forms does ". appName(true) ." accept?",
   'answer'=>appName(true)." accepts all major credit cards and Google Pay."])


   @include('support.slider',['question'=>"Does it take a long time to get set up with ". appName(true) ."?",
   'answer'=>"". appName(true) ." can be set up and implemented in one sitting. Simply set up your company, invite user, and go!"])

    @include('support.slider',['question'=>"Does ". appName(true) ." include the gift cards with the base subscription price?",
   'answer'=>"No, the ". appName(true) ." subscription cost does not cover gift cards or other rewards offered by ". appName(true) ." Reward Partners."])

   @include('support.slider',['question'=>"Do I need to use ". appName(true) ." partner brands?",
   'answer'=>"No, our platform allows you to create your own custom rewards and disable partner brands. All for no extra cost."])


    @include('support.slider',['question'=>"What do I need to do to allow partner rewards?",
   'answer'=>"First, you must fund your company's partner reward balance. Second, due to strict security guidelines, you must wait 4 business days or contact a member of the ". appName(true) ." team to verify your company."])

 @include('support.slider',['question'=>"Will ". appName(true) ." charge me without permission",
   'answer'=>"Absolutely not, ". appName(true) ." charges only a subscription fee. Reward funding is entirely set up and managed by your company. No unprompted charges ever."])

   @include('support.slider',['question'=>"How does ". appName(true) ." work with Slack?",
   'answer'=>appName(true)." easily integrates with Slack. " . getReplacedWordOfKudos(true) . ", birthdays, and work anniversaries will automatically be published on a channel of your choice. Check out <a href='/slack' class='text-blue-500'>". appName(true) ." &amp; Slack</a> to learn more. "])

 <!--   @include('support.slider',['question'=>"What is an administrator user?",
   'answer'=>"Administrator users have access to the entire ". appName(true) ." solution; including billing & analytics. Administrators are allowed to add new users and modify company settings as well."])

   @include('support.slider',['question'=>"Can I make other users adminstrators for my company?",
   'answer'=>"Yes, make as many users as you want adminstrators of your company, but be aware they have access to billing and all company settings."]) -->





</div>
</div>

</div>

<script type="text/javascript">

    $('.question_link').on('click',function(){
        $(this).parent().find(".question_answer").slideToggle(300);
        $(this).toggleClass('text-blue-900');
        $(this).toggleClass('text-blue-500');
        $(this).toggleClass('border-solid');
    })
</script>

  @include('home.home-css')
</x-guest-layout>
