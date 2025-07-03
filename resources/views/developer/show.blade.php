<x-app-layout>


    <div class="container mx-auto px-4 py-10 md:py-12">
        <div class="p-8 bg-white my-10 border border-gray-300 rounded rounded-t-lg ">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ appName() }} Reference
            </h2>

            <div name="description">
               <div>
                   <a class="text-blue-500 underline mt-1" href="/developer/customize-teams">Customize Teams</a><br>
                   <a class="text-blue-500 underline mt-1" href="/developer/kudos">Give {{ getReplacedWordOfKudos() }}</a><br>
                   <a class="text-blue-500 underline mt-1" href="{{ route('developer.send-kudos-to-give-away') }}">Send {{ getReplacedWordOfKudos() }} to Give Away</a><br>
                   <a class="text-blue-500 underline mt-1" href="/developer/send-invites">Invite Users for Company</a><br>
                   <a class="text-blue-500 underline mt-1" href="/developer/manage-company-settings">Manage Company Settings</a><br>
                   <a class="text-blue-500 underline mt-1" href="/developer/transactions">View All User Transactions</a><br>
                   <a class="text-blue-500 underline mt-1" href="/developer/transactions-kudos-to-give">View All {{ getReplacedWordOfKudos() }} to Give Transactions</a><br>
                   <a class="text-blue-500 underline mt-1" href="/developer/redemptions">View All Redemptions</a><br>
                   <a class="text-blue-500 underline mt-1" href="/developer/companies">View All Companies</a><br>
                   <a class="text-blue-500 underline mt-1" href="/developer/rewards">View All Rewards</a><br>
                   <a class="text-blue-500 underline mt-1" href="/developer/active-companies">View All Active Companies</a><br>
                   <a class="text-blue-500 underline mt-1" href="/developer/conversion-rate">Set Conversion Rate</a><br>
                   <a class="text-blue-500 underline mt-1" href="/developer/company-setting">company settings</a><br>
               </div>

            </div>
        </div>
    </div>

</x-app-layout>
