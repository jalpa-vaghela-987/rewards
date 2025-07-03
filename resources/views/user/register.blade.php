<x-guest-layout>
    <x-jet-authentication-card
        style="background-image: url({{asset('/other/stock/pink-rounded.png')}}); background-size: cover;">
        <x-slot name="logo">
            <img src="{{$ui->company->logo_path}}" style="margin:auto; max-width: 150px; padding-top: 20px;"/>
        </x-slot>

        <x-jet-validation-errors class="mb-4"/>

        <form method="POST" action="/register/save/{{$ui->id}}">
            @csrf

            <div class="grid grid-cols-2">
                <div class="grid-cols-1 mr-2">
                    <x-jet-label for="first_name" value="{{ __('First Name') }}"/>
                    <x-jet-input id="first_name" class="block mt-1 w-full" type="text" name="first_name"
                                 :value="old('first_name') ?? $user->first_name" required autofocus autocomplete="first_name"/>
                </div>

                <div class="grid-cols-1 mr-2">
                    <x-jet-label for="last_name" value="{{ __('Last Name') }}"/>
                    <x-jet-input id="last_name" class="block mt-1 w-full" type="text" name="last_name"
                                 :value="old('last_name') ?? $user->last_name" required autofocus autocomplete="last_name"/>
                </div>
            </div>

            <div class="mt-4">
                <x-jet-label for="email" value="{{ __('Email') }}"/>
                <div class="block mt-1 w-full italic">{{$ui->email}}</div>
            </div>

            <div class="mt-4">
                <x-jet-label for="password" value="{{ __('Password') }}"/>
                <x-jet-input id="password" class="block mt-1 w-full" type="password" name="password" required
                             autocomplete="new-password"/>
            </div>

            <div class="mt-4">
                <x-jet-label for="password_confirmation" value="{{ __('Confirm Password') }}"/>
                <x-jet-input id="password_confirmation" class="block mt-1 w-full" type="password"
                             name="password_confirmation" required autocomplete="new-password"/>
            </div>

            <div class="mt-4">
                <x-jet-label for="position" value="{{ __('Job Title') }}"/>
                <x-jet-input id="position" class="block mt-1 w-full" type="text" name="position"
                             :value="old('position') ?? $user->position" required autofocus autocomplete="position"/>
            </div>

            {{--            <div class="mt-4">--}}
            {{--                <x-jet-label for="birthday" value="{{ __('Birthday') }}" />--}}
            {{--                <x-jet-input id="birthday" class="block mt-1 w-full" type="date" name="birthday" :value="old('birthday')" autofocus autocomplete="birthday"/>--}}
            {{--            </div>--}}

            <div class="col-span-6 sm:col-span-4 flex sm:flex-row flex-col mt-4">
                <x-jet-label for="birthday_date" value="{{ __('Birthday (Optional)') }}"/>
            </div>

            <div class="grid grid-cols-2">
                <div class="grid-cols-1 mr-2">
                    <x-jet-label for="birthday_date" value="{{ __('Day') }}"/>
                    <select autofocus
                            name="birthday_date"
                            class="border-gray-300 focus:border-indigo-300 focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mr-2 w-full">
                        <option value="0">Day</option>
                        @for($i=1; $i<=31; $i++)
                            <option {{ old('birthday_date') ?? $user->birthday_date == $i ? 'selected' : '' }} value="{{ $i }}">{{ $i }}</option>
                        @endfor
                    </select>
                    <x-jet-input-error for="birthday_date" class="mt-2"/>
                </div>

                <div class="grid-cols-1 mr-2">
                    <x-jet-label for="birthday_month" value="{{ __('Month') }}"/>
                    <select autofocus
                            name="birthday_month"
                            class="border-gray-300 focus:border-indigo-300 focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm w-full">
                        <option {{ old('birthday_date') ?? $user->birthday_month == 0 ? 'selected' : '' }}  value="0">Month</option>
                        <option {{ old('birthday_date') ?? $user->birthday_month == '01' ? 'selected' : '' }} value="01">January</option>
                        <option {{ old('birthday_date') ?? $user->birthday_month == '02' ? 'selected' : '' }} value="02">February</option>
                        <option {{ old('birthday_date') ?? $user->birthday_month == '03' ? 'selected' : '' }} value="03">March</option>
                        <option {{ old('birthday_date') ?? $user->birthday_month == '04' ? 'selected' : '' }} value="04">April</option>
                        <option {{ old('birthday_date') ?? $user->birthday_month == '05' ? 'selected' : '' }} value="05">May</option>
                        <option {{ old('birthday_date') ?? $user->birthday_month == '06' ? 'selected' : '' }} value="06">June</option>
                        <option {{ old('birthday_date') ?? $user->birthday_month == '07' ? 'selected' : '' }} value="07">July</option>
                        <option {{ old('birthday_date') ?? $user->birthday_month == '08' ? 'selected' : '' }} value="08">August</option>
                        <option {{ old('birthday_date') ?? $user->birthday_month == '09' ? 'selected' : '' }} value="09">September</option>
                        <option {{ old('birthday_date') ?? $user->birthday_month == '10' ? 'selected' : '' }} value="10">October</option>
                        <option {{ old('birthday_date') ?? $user->birthday_month == '11' ? 'selected' : '' }} value="11">November</option>
                        <option {{ old('birthday_date') ?? $user->birthday_month == '12' ? 'selected' : '' }} value="12">December</option>
                    </select>
                    <x-jet-input-error for="birthday_month" class="mt-2"/>
                </div>
                <x-jet-input-error for="birthday" class="mt-2"/>
                {{--        <x-jet-input id="birthday" class="block mt-1 w-full" type="date" name="birthday" :value="old('birthday')" autofocus autocomplete="birthday" wire:model.defer="birthday"/>--}}
            </div>

            <div class="mt-4">
                <x-jet-label for="anniversary" value="{{ __('Work Anniversary (Optional)') }}"/>
                <x-jet-input id="anniversary" class="block mt-1 w-full" type="date" name="anniversary"
                             :value="old('anniversary') ?? $user->formatted_anniversary" autofocus autocomplete="anniversary"/>
            </div>


            @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
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
            @endif

            <x-jet-input class="block mt-1 w-full" type="hidden" name="hash" value="{{$ui->hash}}" required/>
            <x-jet-input class="block mt-1 w-full" type="hidden" name="company_id" value="{{$ui->company->id}}"
                         required/>
            <x-jet-input class="block mt-1 w-full" type="hidden" name="email" value="{{$ui->email}}" required/>


            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>

                <x-jet-button class="ml-4">
                    {{ __('Get Started!') }}
                </x-jet-button>
            </div>
        </form>
    </x-jet-authentication-card>
</x-guest-layout>
<script>
    $(function () {
        var dtToday = new Date();

        var month = dtToday.getMonth() + 1;
        var day = dtToday.getDate();
        var year = dtToday.getFullYear();

        if (month < 10)
            month = '0' + month.toString();
        if (day < 10)
            day = '0' + day.toString();

        var maxDate = year + '-' + month + '-' + day;
        $('#anniversary').attr('max', maxDate);
    });
</script>
