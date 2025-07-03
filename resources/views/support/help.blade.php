<x-app-layout>


    <div class="text-center py-10 md:flex">
        <div class="w-full p-0  md:w-1/3 text-left my-24">
            <div class="text-xl px-3 md:px-8 font-semibold">Still have questions?</div>
            <div class="mb-8 mt-3 px-3 md:px-8 w-full">Don't worry, {{ appName() }} support can help.</div>
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
        <div class="w-full p-0 md:w-2/3 my-5">
            <h2 class="font-handwriting text-2xl font-semibold">Resources & User Guides</h2>
            <div class="w-full p-2 md:p-2">


                @include('support.slider-small',['question'=>"Navigation Menu",
                'answer'=>" <img src='/other/guides/nav-desc.png'>
            "])

                @include('support.slider-small',['question'=>"Team Menu",
                'answer'=>" <img class='h-96' src='/other/guides/teams-menu.png'>
            "])

                @include('support.slider-small',['question'=>"Company Menu",
                'answer'=>" <img class='h-96' src='/other/guides/company-menu-desc.png'>
            "])
                <h2 class="font-handwriting text-2xl font-semibold">Group Cards </h2>

                @include('support.slider-small',['question'=>"How to send group cards to my company members?",
              'answer'=>"Head over to your Group Cards>>Create Group Card.<img class='h-96' src='/other/groupcards/image1.png'>
            "])
                @include('support.slider-small',['question'=>"How to get What should be headline for the card?",
              'answer'=>"You need to select the theme of your choice and text of theme will come automatically in the input  field ”What should be headline for the card”.<img class='h-110' src='/other/groupcards/image2.png'>
            "])
                @include('support.slider-small',['question'=>"Can I add the headline of my choice on my selected theme?",
              'answer'=>"Yes, add a headline in “What should be headline for the card?” Field and select the theme.<img class='h-96' src='/other/groupcards/image3.png'>
            "])
                @include('support.slider-small',['question'=>"Can I set the theme of my choice?",
              'answer'=>"Yes, you can set it by using the “Advanced” feature option while selecting the theme. Click on “Select Photo” and you can set theme of your choice..<img class='h-96' src='/other/groupcards/image4.png'>
            "])
                @include('support.slider-small',['question'=>"Is there an option to change the background color of the selected theme?",
              'answer'=>"Yes, by setting the ”Select banner background color” color you can change the background color of the selected theme.<img class='h-96' src='/other/groupcards/image5.png'>
            "])
                @include('support.slider-small',['question'=>"Can I add all team members of a particular team at once in a contributor list?",
              'answer'=>"Yes, Head over to Choose Recipient and select the team of which members you want to add.<img class='h-96' src='/other/groupcards/image6.png'>
            "])
                @include('support.slider-small',['question'=>"How can I add individual contributors in a list?",
              'answer'=>"On the Choose Recipient screen in the “Add Individual Contributors” field enter the initials of the member and you will get the name.<img class='h-96' src='/other/groupcards/image7.png'>
            "])
                @include('support.slider-small',['question'=>"Can I remove the member from the contributor list?",
              'answer'=>"On the Choose Recipient screen hover over the cursor on the contributor you want to remove,    you will see the member name coming as ”Remove member name”. Click on it and the member will be removed from the list.<img class='h-96' src='/other/groupcards/image8.png'>
            "])
                @include('support.slider-small',['question'=>"Can I edit the card from the Choose Recipient screen?",
              'answer'=>"Yes, click on the ”Edit Card” button, it will take you to the final page from there click on “Modify Settings” it will land you on the “Card Details” screen.<img class='h-96' src='/other/groupcards/image9.png'><img class='h-96' src='/other/groupcards/image9a.png'>
            "])
                @include('support.slider-small',['question'=>"Can I change the contributor names from the View Card  screen?",
              'answer'=>"Yes, click on the “Modify People” button and you will navigate to Choose Recipient screen.<img class='h-96' src='/other/groupcards/image10.png'>
            "])
                @include('support.slider-small',['question'=>"Can I attach a photo to the card?",
              'answer'=>"On the View Card screen, click on the “Select Photo” button and choose a photo of your choice.<img class='h-96' src='/other/groupcards/image11.png'>
            "])
                @include('support.slider-small',['question'=>"Can I attach GIFs on the card?",
              'answer'=>"Yes, enter the gif text in the “Search for the perfect Gif” field and you will get a list of Gifs related to the entered text.<img class='h-96' src='/other/groupcards/image12.png'>
            "])
                @include('support.slider-small',['question'=>"How to send a message on the Group Card screen?",
              'answer'=>" On the Group card screen in the textbox enter the message and click on Publish.<img class='h-96' src='/other/groupcards/image13.png'>
            "])
                @include('support.slider-small',['question'=>"How to send a card to the recipient?",
              'answer'=>"Click on the “View Preview & Send” button the card will be sent to the recipient.<img class='h-96' src='/other/groupcards/image14.png'>
            "])
                @include('support.slider-small',['question'=>"How does the Modify Settings button work?",
              'answer'=>"Once you click on “Modify Settings” it will take you to the “Card Details” screen where you can modify the theme, recipient and color.<img class='h-96' src='/other/groupcards/image15.png'>
            "])
                @include('support.slider-small',['question'=>"How does the “Modify People” button work?",
              'answer'=>"On click of “Modify People” it lands you on the Choose Recipient screen, where you can add more contributors in the list. You can select complete team members or can add individual contributor using “Add Individual Contributors” functionality.<img class='h-96' src='/other/groupcards/image16.png'>
            "])
                @include('support.slider-small',['question'=>"As a recipient, where can I check the card sent by other members ?",
              'answer'=>" In “Received Cards’ of the “Group Cards'' screen we can see the card sent by other members.<img class='h-96' src='/other/groupcards/image17.png'>
            "])
                @include('support.slider-small',['question'=>"Where can I check the sent card?",
              'answer'=>" In the “Received Cards” of the “Group Cards” screen.<img class='h-96' src='/other/groupcards/image18.png'>
            "])
                @include('support.slider-small',['question'=>"Can I draft my card?",
              'answer'=>" Yes, you can draft your card in the Active Group Cards section of the Group Cards screen.<img class='h-96' src='/other/groupcards/image19.png'>
            "])
                @include('support.slider-small',['question'=>"Can I delete the Sent Card  and Active Card from the Group Cards screen?",
              'answer'=>"Yes, you will get a delete button on Active and Sent Card.<img class='h-96' src='/other/groupcards/image20.png'>
            "])

                <h2 class="font-handwriting text-2xl font-semibold">Reward Redemption :</h2>
                <h3 class="font-handwriting font-semibold">Custom Rewards :</h3>
                @include('support.slider-small',['question'=>"Can I add customized rewards for my company?",
              'answer'=>" Yes, head over to Manage Company Settings>>Manage Rewards, click on “Create New Custom Reward” from here you can add customized rewards.<img class='h-76' src='/other/reward/custom/image1.png'>
            "])
                @include('support.slider-small',['question'=>"How to get an update whether the reward has been sent or not?",
              'answer'=>"You can do it in 2 ways, 1 add a unique number and then click on “Mark as Sent” or navigate to a list of rewards and click on “Mark as Sent” for which reward you wanted to send.<img class='h-76' src='/other/reward/custom/image2.png'>
            "])
                @include('support.slider-small',['question'=>"How to change the status of reward from Sent to Not Sent.",
              'answer'=>"Hover over the cursor on “Sent” rewards, it will show “Mark as Not Sent” text.<img class='h-76' src='/other/reward/custom/image3.png'>
            "])
                @include('support.slider-small',['question'=>"Can I change the status of reward to Not Sent by adding code in a unique code textbox?",
              'answer'=>"No.
            "])
                @include('support.slider-small',['question'=>"How can  I view the reward from the history list?",
              'answer'=>"Click on the reward title and you will navigate to the view page.<img class='h-76' src='/other/reward/custom/image4.png'>
            "])
                @include('support.slider-small',['question'=>"How to disable custom rewards?",
              'answer'=>"Edit the custom rewards and navigate to the “Disable Reward” checkbox. Check disable reward checkbox and click on Save button.<img class='h-76' src='/other/reward/custom/image5.png'>
            "])
                @include('support.slider-small',['question'=>"Can I edit the " . getReplacedWordOfKudos() . " message after it has been sent?",
              'answer'=>"Yes .<img class='h-76' src='/other/reward/custom/image6.png'>
            "])
                @include('support.slider-small',['question'=>"Can I delete the custom reward?",
              'answer'=>"Yes.<img class='h-76' src='/other/reward/custom/image7.png'>
            "])
                @include('support.slider-small',['question'=>"How to set the minimum and maximum cost of custom rewards?",
              'answer'=>"<img class='h-76' src='/other/reward/custom/image8.png'>
            "])
                @include('support.slider-small',['question'=>"Where can I see the Disabled Rewards?",
              'answer'=>"Head over to Manage Rewards>>Disabled Rewards.<img class='h-76' src='/other/reward/custom/image9.png'>
            "])
                @include('support.slider-small',['question'=>"How to enable Inventory Tracking?",
              'answer'=>"While adding custom cards we get a setting for “Enable Inventory Tracking”, if we enable it we get an Inventory Amount textbox and we can set reward units.<img class='h-76' src='/other/reward/custom/image10.png'>
            "])
                @include('support.slider-small',['question'=>"How can I redeem the custom reward?",
              'answer'=>" Hover over the cursor on custom reward and click on the Redeem button, it will take you to the Redeem screen.<img class='h-76' src='/other/reward/custom/image11.png'>
            "])

                <h3 class="font-handwriting font-semibold">Partner Rewards :</h3>

                @include('support.slider-small',['question'=>"Can I comment on " . getReplacedWordOfKudos() . " people send?",
              'answer'=>" No, but we recommend a slack integration which does allow for this interaction.<img class='h-76' src='/other/reward/partner/image1.png'>
            "])
                @include('support.slider-small',['question'=>"Can I edit Partner Rewards?",
              'answer'=>" No, our partner rewards are controlled by the merchants.
            "])
                @include('support.slider-small',['question'=>"Can I delete Partner Rewards?",
              'answer'=>" No, but you are able to disable all of them in the Manage Rewards page.
            "])
                @include('support.slider-small',['question'=>"Where can I see redeemed rewards?",
              'answer'=>"Head over to Wallet>>View Previously Redeemed Rewards.<img class='h-76' src='/other/reward/partner/image2.png'>
            "])
                @include('support.slider-small',['question'=>"Can I view the redeemed rewards?",
              'answer'=>" Yes, hover over the redeem cards in View Previously Redeemed Rewards and click on the View link.<img class='h-76' src='/other/reward/partner/image3.png'>
            "])
                @include('support.slider-small',['question'=>"Can I open the merchant link of redeemed rewards?",
              'answer'=>" Yes, hover over the redeem cards in View Previously Redeemed Rewards and click on Merchant Link.<img class='h-76' src='/other/reward/partner/image4.png'>
            "])
                <h2 class="font-handwriting text-2xl font-semibold">Team Structure :</h2>

                @include('support.slider-small',['question'=>"How to create a new team?",
              'answer'=>" Hover over to Manage Teams>>Create New Team, you can create a team from here.<img class='h-76' src='/other/team/image1.png'>
            "])
                @include('support.slider-small',['question'=>"How to invite members in a team?",
              'answer'=>"  Navigate to Manage Teams>>Modify Team Settings, Invite Team Member search for the user you want to add in the team.<img class='h-76' src='/other/team/image2.png'>
            "])
                @include('support.slider-small',['question'=>"Where can I see the team members?",
              'answer'=>"Navigate to Manage Teams>>Modify Team Settings, in Team Members you can see the members added in your selected team.<img class='h-76' src='/other/team/image3.png'>
            "])
                @include('support.slider-small',['question'=>"Can I delete the added team?",
              'answer'=>"Yes. Navigate to the team you want to delete and you will get a button Delete Team.<img class='h-76' src='/other/team/image4.png'>
            "])
                @include('support.slider-small',['question'=>"Can I remove members of the team?",
              'answer'=>"Yes, navigate to Manage Teams and select respective. Go to the Team Members section, you will get the Remove button to remove members.<img class='h-76' src='/other/team/image5.png'>
            "])
                @include('support.slider-small',['question'=>"Where can I see the team members count?",
              'answer'=>" Navigate up to Team Members and see the count on the left side.<img class='h-76' src='/other/team/image6.png'>
            "])
                @include('support.slider-small',['question'=>"Can I rename my team name?",
              'answer'=>" Yes, go to the Manage Team and select the respective team. The Team Owner renamed the team.<img class='h-76' src='/other/team/image7.png'>
            "])
                @include('support.slider-small',['question'=>"Can a member leave the team if he is an owner?",
              'answer'=>" Yes, when there are more than 1 admin team member then the owner of the team can leave the team.<img class='h-76' src='/other/team/image8.png'>
            "])



                <h2 class="font-handwriting text-2xl font-semibold">Team Settings :</h2>

                @include('support.slider-small',['question'=>"Where can I get the Team Setting?",
              'answer'=>" Hover over to Manage Teams>>Team Management.<img class='h-76' src='/other/teamSettings/image1.png'>
            "])
                @include('support.slider-small',['question'=>"Can I add members in specific teams from Team Management?",
              'answer'=>"Yes, you can search for a member in the search textbox and you will get a member in the display list.<img class='h-76' src='/other/teamSettings/image2.png'>
            "])
                @include('support.slider-small',['question'=>"Can I set a Role from Team Management for selected members?",
              'answer'=>"Yes, once the member is selected you can select the Role.<img class='h-76' src='/other/teamSettings/image3.png'>
            "])
                @include('support.slider-small',['question'=>"Can I check all teams and their members in Team Management?",
              'answer'=>"Yes, all teams and their members will come into Team Management.<img class='h-76' src='/other/teamSettings/image4.png'>
            "])
                @include('support.slider-small',['question'=>"Can I delete members from the team from Team Management?",
              'answer'=>"Yes.<img class='h-76' src='/other/teamSettings/image5.png'>
            "])
                @include('support.slider-small',['question'=>"Can we change admin members to non admin?",
              'answer'=>" Yes, click on Modify Permission and you will navigate to change member role.<img class='h-76' src='/other/teamSettings/image6.png'>
            "])
                @include('support.slider-small',['question'=>"Can I open a member profile from Team Management?",
              'answer'=>" Yes, click on the member name and you will navigate to the user profile.<img class='h-76' src='/other/teamSettings/image7.png'>
            "])
                <h2 class="font-handwriting text-2xl font-semibold">Company Setting :</h2>
                @include('support.slider-small',['question'=>"How can I add a company logo?",
              'answer'=>" Head over to Company Settings, click on the “Select Logo” button coming in the Manage Company section.<img class='h-76' src='/other/companySetting/image1.png'>
            "])
                @include('support.slider-small',['question'=>"Can I change " . getReplacedWordOfKudos() . " Monthly Allowance value?",
              'answer'=>"Yes, navigate to Company Settings>>Manage Company Settings, you can change the " . getReplacedWordOfKudos() . " allowance in Level 1, Level 2, Level 3, Level 4, Standard " . getReplacedWordOfKudos() . " Value, Super " . getReplacedWordOfKudos() . " Value, Birthday " . getReplacedWordOfKudos() . " Value and Anniversary " . getReplacedWordOfKudos() . " Value.<img class='h-76' src='/other/companySetting/image2.png'>
            "])
                @include('support.slider-small',['question'=>"How can I connect with a company in a zoom meeting?",
              'answer'=>" Head over to the Connect menu bar and add all the values and click on Save Preferences.<img class='h-76' src='/other/companySetting/image3.png'>
            "])

                <h2 class="font-handwriting text-2xl font-semibold">Manage Users :</h2>
                @include('support.slider-small',['question'=>"How can I add a new user?",
              'answer'=>"Head over to Manage Company Settings>>Manage Users, fill out all the fields and click on the Invite button.<img class='h-76' src='/other/manageUsers/image1.png'>
            "])
                @include('support.slider-small',['question'=>"How to sign up once the invitation has been sent to a new user?",
              'answer'=>"On added email the user gets an email, there we have a sign up button. Users can click on that and do the sign up process.<img class='h-76' src='/other/manageUsers/image2.png'>
            "])
                @include('support.slider-small',['question'=>"Can I change the role of the user?",
              'answer'=>"In Manage Users>>Company Members, click on the Modify Permission and change the Role and User Level of the user.<img class='h-76' src='/other/manageUsers/image3.png'>
            "])

                <h2 class="font-handwriting text-2xl font-semibold">Billing :</h2>
                @include('support.slider-small',['question'=>"Where can I check my balance?",
              'answer'=>"Head over to Manage Company>>Billing, and you can check your balance in the current balance section.<img class='h-76' src='/other/billing/image1.png'>
            "])
                @include('support.slider-small',['question'=>"How can I add balance?",
              'answer'=>"Navigate to Add to balance and the balance and click on Confirm and Proceed button.<img class='h-76' src='/other/billing/image2.png'>
            "])
                @include('support.slider-small',['question'=>"Can I check last month's redemption balance?",
              'answer'=>" Yes, you can check the last 3 months' redemption balance.<img class='h-76' src='/other/billing/image3.png'>
            "])
                @include('support.slider-small',['question'=>"How can I check payment transaction history?",
              'answer'=>"Navigate to the Billing section and check Funding History to check all the payment transactions.<img class='h-76' src='/other/billing/image4.png'>
            "])
                @include('support.slider-small',['question'=>"Can I check redemption activity?",
              'answer'=>"Yes,you can check the redemption history of all the rewards.<img class='h-76' src='/other/billing/image5.png'>
            "])
                @include('support.slider-small',['question'=>"How to add Payment Information?",
              'answer'=>"Head over to Billing and click on Manage Subscription and Payment Info. Fill out card details and add the payment details.<img class='h-76' src='/other/billing/image6.png'>
            "])

                <h2 class="font-handwriting text-2xl font-semibold">User Stats :</h2>
                @include('support.slider-small',['question'=>"Where can I find all company users " . getReplacedWordOfKudos() . " full information?",
              'answer'=>"Head over to Manage Company>>User Stats, you will get the " . getReplacedWordOfKudos() . " information of all your company users.<img class='h-76' src='/other/userStats/image1.png'>
            "])
                @include('support.slider-small',['question'=>"Can I search for the user in User Stats?",
              'answer'=>"Yes, add the user name in the search textbox and you will get the complete " . getReplacedWordOfKudos() . " information of that particular company user.<img class='h-76' src='/other/userStats/image2.png'>
            "])
                <h2 class="font-handwriting text-2xl font-semibold"> Activity Dashboard :</h2>
                @include('support.slider-small',['question'=>"Where can I check my company's " . getReplacedWordOfKudos() . " status?",
              'answer'=>"Head over to Manage Company>>Activity Dashboard. You can check out your company’s total " . getReplacedWordOfKudos() . " status.<img class='h-76' src='/other/activity/image1.png'>
            "])
                @include('support.slider-small',['question'=>"Can I check the " . getReplacedWordOfKudos() . " Activity History?",
              'answer'=>"Yes, in the Activity Dashboard you can check the history of " . getReplacedWordOfKudos() . " Activity.<img class='h-76' src='/other/activity/image2.png'>
            "])


            </div>

            <h2 class="font-handwriting text-2xl font-semibold text-left ml-2 mt-4 mb-4">Frequently Asked Questions</h2>
            <div class="w-full p-4 px-6 border-t border-solid border-gray-300">
                <h2 class="ml-2 text-xl text-left font-semibold">{{ getReplacedWordOfKudos() }} &amp; Rewards Process</h2>
                <div class="m-2 p-1 rounded border-dashed border-gray-400 border">

                    @include('support.slider-small',['question'=>"What are " . getReplacedWordOfKudos() . "?",
                    'answer'=> appName()." uses virtual rewards called “" . getReplacedWordOfKudos() . "” to facilitate public recognition for excellent behavior. Employees receive a monthly allowance of " . getReplacedWordOfKudos() . " to give out. (e.g. 1,000 " . getReplacedWordOfKudos() . " worth $10) Once you receive " . getReplacedWordOfKudos() . ", you can exchange them for real rewards!
                 "])

                    @include('support.slider-small',['question'=>"How do I send " . getReplacedWordOfKudos() . "?",
                      'answer'=>" You can send " . getReplacedWordOfKudos() . " via the <a href='/kudos-feed'  class='text-blue-500'>" . getReplacedWordOfKudos() . " Feed</a> or by searching the user you would like to send them to and selecting the \"Send " . getReplacedWordOfKudos() . "\" button.
                   "])

                    @include('support.slider-small',['question'=>"How can I find out how many " . getReplacedWordOfKudos() . " I have?",
                       'answer'=>"
                       Head over to your <a href='/wallet'  class='text-blue-500'>" . getReplacedWordOfKudos() . " Wallet</a>!
                    "])

                    @include('support.slider-small',['question'=>"What is the difference between " . getReplacedWordOfKudos() . " and " . getReplacedWordOfKudos() . " I can give away?",
                       'answer'=>"
                       In order to redeem " . getReplacedWordOfKudos() . " for reward, they must be received from another user. " . getReplacedWordOfKudos() . " cannot be sent to another user once received. Depending on your company's settings, you may receive " . getReplacedWordOfKudos() . " that you are able to give away every month.
                    "])

                    @include('support.slider-small',['question'=>"How long do I have to give away my " . getReplacedWordOfKudos() . "?",
                       'answer'=>"
                       You have 60 days to give away your " . getReplacedWordOfKudos() . " before they expire. ". appName() ." will remind you of remaining " . getReplacedWordOfKudos() . " when the expiration is approaching.
                    "])



                    @include('support.slider-small',['question'=>"How do I redeem " . getReplacedWordOfKudos() . " for rewards?",
                       'answer'=>"Head over to your <a href='/wallet'  class='text-blue-500'>" . getReplacedWordOfKudos() . " Wallet</a> to redeem " . getReplacedWordOfKudos() . " for rewards! From there, scroll down & select a reward option and choose \"Redeem\".
                    "])

                    @include('support.slider-small',['question'=>"I am not seeing any rewards in my wallet, why is this?",
                       'answer'=>"If your <a href='/wallet' class='text-blue-500'>" . getReplacedWordOfKudos() . " Wallet</a> is not displaying any rewards, this means your company has disabled ". appName() ." Partner rewards and does not currently have any custom rewards. Unfortunetly, this is out of our control and we recommend reaching out to an administrator at your company.
                       <br><br> If you are an administrator, you should enable ". appName() ." partner redemptions and confirm your company's balance is not low. If you would not like to use ". appName() ." partners, you can instead create a custom reward.
                    "])


                    @include('support.slider-small',['question'=>"How much are " . getReplacedWordOfKudos() . " worth?",
                       'answer'=>" Generally, 100 " . getReplacedWordOfKudos() . " will be worth $1.00 of value. However, your company may adjust this amount when using custom rewards.
                    "])

                    @include('support.slider-small',['question'=>"When will I get more " . getReplacedWordOfKudos() . " to give out?",
                       'answer'=>" If your company does give you a monthly allowance of " . getReplacedWordOfKudos() . ", you will receive them on the first of each month.
                    "])

                    @include('support.slider-small',['question'=>"How will I receive my reward after I redeem?",
                       'answer'=>"
                       After you exchange " . getReplacedWordOfKudos() . " for a reward, you will be able to view the merchant specific credentials directly from ". appName() ." in your previously redeemed rewards towards the bottom of your <a href='/wallet'  class='text-blue-500'>" . getReplacedWordOfKudos() . " Wallet</a>. You will also receive an email from both ". appName() ." and our merchant partner with the credentials for the reward with redemption instructions.
                    "])

                    @include('support.slider-small',['question'=>"How do I enable ". appName() ." partner rewards?",
                       'answer'=>"
                       If you are an administrator user, you can enable these rewards through your company menu (this will appear as your logo or company name on the navigation bar) then select Manage Rewards and enable \"Allow ". appName() ." Partner Redemptions\". <br><br>
                       Additionally, make sure you have sufficiently funded your ". appName() ." partner reward balance. You can do this on the \"Billing\" page.
                    "])


                </div>

            </div>
        </div>

    </div>

    <script type="text/javascript">

        $('.question_link').on('click', function () {
            $(this).parent().find(".question_answer").slideToggle(200);
            $(this).toggleClass('text-blue-900');
            $(this).toggleClass('text-blue-500');
            $(this).toggleClass('border-solid');
            $(this).toggleClass('border-b');
        })
    </script>


</x-app-layout>
