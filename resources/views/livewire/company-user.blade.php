<form wire:submit.prevent="createCompanyUser">

    <div class="grid grid-cols-2">
        <div class="grid-cols-1 mr-2">
            <x-jet-label for="first_name" value="{{ __('First Name') }}"/>
            <x-jet-input id="first_name" type="text" name="first_name" class="mt-1 block w-full" required
                         wire:model.defer="first_name" maxlength="26" autofocus/>
            <x-jet-input type="hidden" name="company_id" class="mt-1 block w-full" required
                         wire:model.defer="company_id"/>
            <x-jet-input-error for="first_name" class="mt-2"/>
        </div>

        <div class="grid-cols-1">
            <x-jet-label for="last_name" value="{{ __('Last Name') }}"/>
            <x-jet-input id="last_name" type="text" name="last_name" class="mt-1 block w-full" required
                         wire:model.defer="last_name" maxlength="26" autofocus/>
            <x-jet-input-error for="last_name" class="mt-2"/>
        </div>
    </div>

    <div class="col-span-6 sm:col-span-4 mt-2">
        <x-jet-label for="email" value="{{ __('Email') }}"/>
        <x-jet-input id="email" type="text" name="email" class="mt-1 block w-full" required wire:model.defer="email"
                     autofocus/>
        <x-jet-input-error for="email" class="mt-2"/>
    </div>

    @if($team_id != null)
        <x-jet-input type="hidden" name="team_id" class="mt-1 block w-full" required wire:model.defer="team_id"/>
        {{--    @else--}}
        {{--        <div class="col-span-6 sm:col-span-4 mt-2">--}}
        {{--            <label for="team_name" class='block font-medium text-sm text-gray-700'>--}}
        {{--                Team Name <span--}}
        {{--                    class="italic text-sm text-pink-600 font-handwriting">(You can always change this!)</span> <br>--}}
        {{--                <span class="text-xs"> Examples: HR Team, Integration Team, Sales Team, {{ appName() }} Team</span>--}}
        {{--            </label>--}}
        {{--            <x-jet-input id="team_name" type="text" name="team_name" required class="mt-1 block w-full"--}}
        {{--                         wire:model.defer="team_name" maxlength="25" autofocus/>--}}
        {{--            <x-jet-input-error for="team_name" class="mt-2"/>--}}
        {{--        </div>--}}
    @endif

    <div class="col-span-6 sm:col-span-4 mt-2">
        <x-jet-label for="password" value="{{ __('Password') }}"/>
        <x-jet-input id="password" type="password" name="password" class="mt-1 block w-full" required
                     wire:model.defer="password" autofocus/>
        <x-jet-input-error for="password" class="mt-2"/>
    </div>

    <div class="col-span-6 sm:col-span-4 mt-2">
        <x-jet-label for="confirm_password" value="{{ __('Confirm Password') }}"/>
        <x-jet-input id="confirm_password" required type="password" name="confirm_password" class="mt-1 block w-full"
                     wire:model.defer="confirm_password" autofocus/>
        <x-jet-input-error for="confirm_password" class="mt-2"/>
    </div>

    <div class="col-span-6 sm:col-span-4 mt-2">
        <x-jet-label for="position" value="{{ __('Job Title') }}"/>
        <x-jet-input id="position" class="block mt-1 w-full" type="text" name="position" :value="old('position')"
                     required autofocus autocomplete="position" wire:model.defer="position"/>
    </div>
    <div class="col-span-6 sm:col-span-4 flex sm:flex-row flex-col mt-2">
        <x-jet-label for="birthday_date" value="{{ __('Birthday (Optional)') }}"/>
    </div>

    <div class="grid grid-cols-2">
        <div class="grid-cols-1 mr-2">
            <x-jet-label for="birthday_date" value="{{ __('Day') }}"/>
            <select wire:model.defer="birthday_date" autofocus
                    class="border-gray-300 focus:border-indigo-300 focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mr-2 w-full">
                <option value="0">Day</option>
                @for($i=1; $i<=31; $i++)
                    <option value="{{ $i }}">{{ $i }}</option>
                @endfor
            </select>
            <x-jet-input-error for="birthday_date" class="mt-2"/>
        </div>

        <div class="grid-cols-1 mr-2">
            <x-jet-label for="birthday_month" value="{{ __('Month') }}"/>
            <select wire:model.defer="birthday_month" autofocus
                    class="border-gray-300 focus:border-indigo-300 focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm w-full">
                <option value="0">Month</option>
                <option value="01">January</option>
                <option value="02">February</option>
                <option value="03">March</option>
                <option value="04">April</option>
                <option value="05">May</option>
                <option value="06">June</option>
                <option value="07">July</option>
                <option value="08">August</option>
                <option value="09">September</option>
                <option value="10">October</option>
                <option value="11">November</option>
                <option value="12">December</option>

            </select>
            <x-jet-input-error for="birthday_month" class="mt-2"/>
        </div>
        <x-jet-input-error for="birthday" class="mt-2"/>
        {{--        <x-jet-input id="birthday" class="block mt-1 w-full" type="date" name="birthday" :value="old('birthday')" autofocus autocomplete="birthday" wire:model.defer="birthday"/>--}}
    </div>

    <div class="col-span-6 sm:col-span-4 mt-2">
        <x-jet-label for="anniversary" value="{{ __('Work Anniversary (Optional)') }}"/>
        <x-jet-input id="anniversary" class="block mt-1 w-full" type="date" name="anniversary"
                     :value="old('anniversary')" autofocus autocomplete="anniversary" wire:model.defer="anniversary"/>
        <x-jet-input-error for="anniversary" class="mt-2"/>
    </div>


    <div class="col-span-6 sm:col-span-4 mt-2">
        <x-jet-label for="currency" value="{{ __('Currency') }}"/>
        <select name="currency" wire:model.defer="currency"
                class="block mt-1 w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
            @foreach($currencies as $currency)
                <option value="{{ $currency }}">
                    {{ $currency }}
                </option>
            @endforeach
        </select>
        <x-jet-input-error for="currency" class="mt-2"/>
    </div>


    <div class="text-md font-bold my-2 w-full text-pink-600 font-handwriting"> That's all the information we need to get
        you on your way.
    </div>


    <div class="mt-4">
        <x-jet-label for="terms">
            <div class="flex items-center">
                <x-jet-checkbox name="terms" id="terms" required/>

                <div class="ml-2">
                    {!! __('I agree to the :terms_of_service and :privacy_policy', [
                            'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="underline text-sm text-gray-600 hover:text-gray-900">'.__('Terms of Service').'</a>',
                            'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="underline text-sm text-gray-600 hover:text-gray-900">'.__('Privacy Policy').'</a>',
                    ]) !!}
                </div>
            </div>
        </x-jet-label>
    </div>

    <div class="flex items-center justify-end pl-4 py-4 text-right sm:pl-6 sm:rounded-bl-md sm:rounded-br-md">
        <x-jet-action-message class="mr-3 text-green-500" on="saved">
            {{ __('Saved.') }}
        </x-jet-action-message>

        <x-jet-button wire:target="photo">
            {{ __('Get Started!') }}
        </x-jet-button>
    </div>
</form>
