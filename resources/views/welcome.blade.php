
<x-guest-layout>
    <x-jet-authentication-card style="background-image: url({{asset('/other/stock/blue-rounded.png')}}); background-size: cover;">
        <x-slot name="logo">

        </x-slot>

        <x-jet-validation-errors class="mb-4" />
        <div class="lg:text-center w-70 pb-4">
          <div class="text-center">
            <x-jet-authentication-card-logo />
          </div>


              <p class="mt-1 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                Learning Focused Employee Engagement Platform
              </p>
              <p class="mt-4 max-w-2xl text-xl text-gray-500 lg:mx-auto">
                  {{ appName() }} allows users to provide virtual rewards for helping others through teach-ins, incentivizing exemplary behavior, and further enhancing working relationships. <br>
                <span class="font-bold text-blue-600"> The best part?</span> The rewards can be redeemed for real value in the form of gift cards and other prizes!
              </p>
            </div>
            <div class="flex items-center justify-end mt-3">
                <x-secondary-link-button class="ml-4" href="/login">
                    {{ __('Login') }}
                </x-secondary-link-button>
                <x-link-button class="ml-4" href="/register">
                    {{ __('Register') }}
                </x-link-button>

            </div>
    </x-jet-authentication-card>
</x-guest-layout>



