<form type="POST">
    {{--    <x-jet-validation-errors class="mb-4"/>--}}


    <x-jet-authentication-card-logo/>
    <div class="text-md font-bold my-1 mt-5 text-blue-800 w-full"> 30 Days Free with No Credit Card Required!</div>

    <ol class="list-disc leading-6 ml-5 text-sm mb-2">
        <li class="text-blue-500">
            <div class="text-gray-800">Truly risk-free trial with zero commitment</div>
        </li>
        <li class="text-blue-500">
            <div class="text-gray-800">No need to cancel your subscription</div>
        </li>
        <li class="text-blue-500">
            <div class="text-gray-800">Full {{ appName() }} experience without limitations</div>
        </li>
    </ol>


    <div class="text-md font-handwriting font-semibold mt-2 pt-2 text-pink-600  border-t border-gray-200"> First, tell
        us a little about your company.
    </div>
    <div class="mt-3 md:mt-2">
        <x-jet-label for="cname" value="{{ __('Company Name') }}"/>
        <x-jet-input id="cname" name="cname" type="text" class="mt-1 block w-full" wire:model.defer="cname"
                     maxlength="120"/>
        <x-jet-input-error for="cname" class="mt-2"/>
    </div>

    <div class="mt-4 md:mt-6">
        <x-jet-label for="birthday" value="{{ __('Country') }}"/>
        <select
            class="block mt-1 w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
            wire:model.defer="country">
            @foreach($countries as $country)
                <option value="{{ $country }}">{{ $country }}</option>
            @endforeach
        </select>
        <x-jet-input-error for="country" class="mt-2"/>
    </div>

    <div class="mt-4 md:mt-6">
        <x-jet-label for="default_currency" value="{{ __('Default Currency') }}"/>
        <select name="default_currency" wire:model.defer="default_currency"
                class="block mt-1 w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
            @foreach($currencies as $currency)
                <option value="{{ $currency }}">
                    {{ $currency }}
                </option>
            @endforeach
        </select>
        <x-jet-input-error for="default_currency" class="mt-2"/>
    </div>

    <div class="mt-4" x-data="{photoName: null, photoPreview: null}">
        <input type="file" class="hidden" wire:model.defer="photo" x-ref="photo" accept="image/*"
               x-on:change="
                    photoName = $refs.photo.files[0].name;
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        photoPreview = e.target.result;
                    };
                    reader.readAsDataURL($refs.photo.files[0]);"
        />

        <x-jet-label for="photo" value="{{ __('Logo') }}"/>

        <x-jet-secondary-button class="mt-2 mr-2" type="button" x-on:click.prevent="$refs.photo.click()">
            {{ __('Select Logo') }}
        </x-jet-secondary-button>

        <!-- <div class="mt-2" x-show="! photoPreview">
            <img src="" alt="" class="rounded-full h-20 w-20 object-cover">
        </div> -->

        <div class="hidden" wire:loading.flex wire:target="photo" wire:loading.class="mt-2 w-40 h-40">
            <div
                class="select-none text-sm text-indigo-500 flex flex-1 items-center justify-center text-center p-4 flex-1">
                <svg class="animate-spin h-6 w-6 text-indigo-500" xmlns="http://www.w3.org/2000/svg" fill="none"
                     viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor"
                          d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            </div>
        </div>

        <div class="mt-5" x-bind:class="{'w-40 h-40 relative' : photoPreview}" wire:loading.remove wire:target="photo">
            <div class="group absolute -right-1 -top-4 cursor-pointer" x-bind:class="{'-top-10': !photoPreview}"
                 x-on:click="$wire.set('photo', null); photoPreview=false;">
                <span class="fa-stack">
                    <i class="fas fa-circle fa-stack-2x text-gray-300 group-hover:text-gray-400 transition ease-in-out duration-350"></i>
                    <i class="fas fa-times fa-stack-1x fa-inverse"></i>
                </span>
            </div>

            <span class="block h-full"
                  x-bind:style="'background-size: contain; background-repeat: no-repeat; background-position: center center; background-image: url(\'' + photoPreview + '\');'">
            </span>
        </div>

        <div class="col-span-6 sm:col-span-4 mt-6" wire:ignore>
            <x-jet-label for="additional_information"/>
            {!! NoCaptcha::renderJs() !!}
            {!! NoCaptcha::display() !!}
        </div>
        <x-jet-input-error for="captcha" class="mt-2"/>
    </div>


    <div class="flex flex-wrap items-center justify-center sm:justify-between mt-4">
        @guest
            @if (Route::has('manage.company.create_form'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900 mt-5" href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>
            @endif
        @endguest

        <div class="w-full sm:w-auto text-center sm:text-right space-x-4 mt-4 sm:mt-0">
            <x-jet-button type="button" onclick="submitForm()">
                {{ __('Continue!') }}
            </x-jet-button>

            <x-jet-action-message class="text-green-500" on="saved">
                {{ __('Company name updated successfully.') }}
            </x-jet-action-message>
        </div>
    </div>
</form>

<script type="text/javascript">
    function submitForm() {
        let response = grecaptcha.getResponse();

        if (response.length) {
        @this.set('captcha', response);
        } else {
        @this.set('captcha', null);
        }

    @this.submitCompany();
    }
</script>
