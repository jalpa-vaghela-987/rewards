<x-jet-form-section submit="submitCompany">
    <x-jet-validation-errors class="mb-4"/>

    <x-slot name="title">
    {{ __('Manage Company') }}
    <!-- updateProfileInformation -->
    </x-slot>

    <x-slot name="description">
        {{ __('Update company information.') }}
    </x-slot>

    <x-slot name="form">
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="cname" value="{{ __('Company Name') }}"/>
            <x-jet-input id="cname" name="cname" type="text" class="mt-1 block w-full" wire:model.defer="cname"
                         maxlength="120"/>
        </div>

        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="birthday" value="{{ __('Country') }}"/>
            <select class="block mt-1 w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" wire:model.defer="country">
                <option value="">-- Choose Country --</option>
                @foreach($countries as $country)
                    <option value="{{ $country }}">{{ $country }}</option>
                @endforeach
            </select>
            <x-jet-input-error for="country" class="mt-2"/>
        </div>

        <div class="col-span-6 sm:col-span-4" x-data="{photoName: null, photoPreview: null}">
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

            @if(Auth::user()->company->getRawOriginal('logo_path'))
                <div class="mt-5 w-40 h-40 relative" x-show="!photoPreview">
                <span class="block h-full"
                      x-bind:style="'background-size: contain; background-repeat: no-repeat; background-position: center center; background-image: url(\' {{ auth()->user()->company->getRawOriginal('logo_path') }} \');'">
                </span>
                </div>
            @endif

            <div wire:loading.flex wire:target="photo" wire:loading.class="mt-2 w-40 h-40">
                <div class="select-none text-sm text-indigo-500 flex flex-1 items-center justify-center text-center p-4 flex-1">
                    <svg class="animate-spin h-6 w-6 text-indigo-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </div>
            </div>

            <div class="mt-5" x-bind:class="{'w-40 h-40 relative' : photoPreview}" wire:loading.remove wire:target="photo">
                <div class="group absolute -right-1 -top-4 cursor-pointer" x-bind:class="{'-top-10': !photoPreview}" x-on:click="$wire.set('photo', null); photoPreview=false;">
                    <span class="fa-stack">
                        <i class="fas fa-circle fa-stack-2x text-gray-300 group-hover:text-gray-400 transition ease-in-out duration-350"></i>
                        <i class="fas fa-times fa-stack-1x fa-inverse"></i>
                    </span>
                </div>

                <span class="block h-full"
                      x-bind:style="'background-size: contain; background-repeat: no-repeat; background-position: center center; background-image: url(\'' + photoPreview + '\');'">
                </span>
            </div>

            <x-jet-secondary-button class="mt-2 mr-2" type="button" x-on:click.prevent="$refs.photo.click()">
                {{ __('Select Logo') }}
            </x-jet-secondary-button>
        </div>
    </x-slot>

    <x-slot name="actions">
        <x-jet-action-message class="mr-3 text-green-500" on="saved">
            {{ __('Company settings updated successfully.') }}
        </x-jet-action-message>

        <x-jet-button wire:target="photo">
            {{ __('Save') }}
        </x-jet-button>
    </x-slot>
</x-jet-form-section>
