<x-guest-layout>
    <x-jet-authentication-card
        style="background-image: url({{asset('/other/stock/blue-rounded.png')}}); background-size: cover;">
        <x-slot name="logo"></x-slot>

        {{--        <x-jet-validation-errors class="mb-4" />--}}

        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <x-jet-authentication-card-logo/>

            <div class="mt-4 md:mt-6">
                <x-jet-label for="email" value="{{ __('Email') }}"/>
                <x-jet-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                             required autofocus/>
                <x-jet-input-error for="email" class="mt-2"/>
            </div>

            <div class="mt-4">
                <x-jet-label for="password" value="{{ __('Password') }}"/>
                <x-jet-input id="password" class="block mt-1 w-full" type="password" name="password" required
                             autocomplete="current-password"/>
                <x-jet-input-error for="password" class="mt-2"/>
            </div>

            <div class="block mt-4">
                <label for="remember_me" class="flex items-center">
                    <x-jet-checkbox id="remember_me" name="remember"/>
                    <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                </label>
            </div>

            <div class="flex flex-wrap items-center justify-end sm:justify-end mt-4">
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 hover:text-gray-900 mb-5"
                       href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif

                <div class="w-full sm:w-auto text-center sm:text-right space-x-4 mt-4 sm:mt-0">
                    <x-secondary-link-button href="/register/company">
                        {{ __('Register Company') }}
                    </x-secondary-link-button>

                    <x-jet-button>
                        {{ __('Login') }}
                    </x-jet-button>
                </div>
            </div>
        <!--  <div class="text-xs mt-5 pt-2 mb-1 italic border-t border-gray-200">{{Illuminate\Foundation\Inspiring::quote()}}</div> -->
        </form>
    </x-jet-authentication-card>
</x-guest-layout>
