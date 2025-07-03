<x-jet-form-section submit="updateProfileInformation">
    <x-slot name="title">
        {{ __('Profile Information') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Update your account\'s profile information.') }}
    </x-slot>

    <x-slot name="form">
        <!-- Profile Photo -->
        @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
            <div x-data="{photoName: null, photoPreview: null}" class="col-span-6 sm:col-span-4">
                <!-- Profile Photo File Input -->
                <input type="file" class="hidden" accept="image/*"
                       wire:model="photo"
                       x-ref="photo"
                       x-on:change="
                                photoName = $refs.photo.files[0].name;
                                const reader = new FileReader();
                                reader.onload = (e) => {
                                    photoPreview = e.target.result;
                                };
                                reader.readAsDataURL($refs.photo.files[0]);
                        "/>

                <x-jet-label for="photo" value="{{ __('Photo') }}"/>

                <!-- Current Profile Photo -->
                <div class="mt-2" x-show="! photoPreview">
                    <img loading="lazy" src="{{ $this->state['profile_photo_url'] }}" alt="{{ $this->state['name'] }}"
                         class="rounded-full h-20 w-20 object-cover">
                </div>

                <!-- New Profile Photo Preview -->
                <div class="mt-2" x-show="photoPreview">
                    <span class="block rounded-full w-20 h-20"
                          x-bind:style="'background-size: cover; background-repeat: no-repeat; background-position: center center; background-image: url(\'' + photoPreview + '\');'">
                    </span>
                </div>

                <x-jet-secondary-button class="mt-2 mr-2" type="button" x-on:click.prevent="$refs.photo.click()">
                    {{ __('Select A New Photo') }}
                </x-jet-secondary-button>


                @if ($this->photo && $this->user->profile_photo_path)
                    <x-jet-secondary-button type="button" class="mt-2" wire:click="deletePhoto({{ $this->state['id'] }},0)">
                        {{ __('Remove Photo') }}
                    </x-jet-secondary-button>
                @elseif($this->photo)
                    <x-jet-secondary-button type="button" class="mt-2" wire:click="deletePhoto({{ $this->state['id'] }},0)">
                        {{ __('Remove Photo') }}
                    </x-jet-secondary-button>
                    @endif
                @if(!str_starts_with($this->state['profile_photo_url'], 'https://ui-avatars.com/api')|| $this->user->profile_photo_path)
                    @if($this->photo)

                        @else
                    <x-jet-secondary-button type="button" class="mt-2" wire:click="deletePhoto({{ $this->state['id'] }},1)">
                        {{ __('Remove Photo') }}
                    </x-jet-secondary-button>
                        @endif
                @endif

                <x-jet-input-error for="photo" class="mt-2"/>
            </div>
        @endif
        {{--        <div class="col-span-6 sm:col-span-4 sm:flex">--}}
    <!-- Initials -->
        {{--            <div class="w-full sm:w-1/4">--}}
        {{--                <x-jet-label for="initials" value="{{ __('Initials') }}"/>--}}
        {{--                <x-jet-input id="initials" type="text" class="mt-1 block w-full" wire:model.defer="state.initials"--}}
        {{--                             autocomplete="initials" maxlength="2"/>--}}
        {{--                <x-jet-input-error for="initials" class="mt-2"/>--}}
        {{--            </div>--}}

    <!-- Name -->
        {{--            <div class="w-full ml-0 mt-6 sm:ml-2 sm:w-3/4 sm:mt-0">--}}
        {{--                <x-jet-label for="name" value="{{ __('Name') }}"/>--}}
        {{--                <x-jet-input id="name" type="text" class="mt-1 block w-full" wire:model.defer="state.name"--}}
        {{--                             autocomplete="name" maxlength="40" disabled="disabled"/>--}}
        {{--                <x-jet-input-error for="name" class="mt-2"/>--}}
        {{--            </div>--}}
        {{--        </div>--}}

        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="initials" value="{{ __('Initials') }}"/>
            <x-jet-input id="initials" type="text" class="mt-1 block w-full" wire:model.defer="state.initials"
                         autocomplete="initials" maxlength="2"/>
            <x-jet-input-error for="initials" class="mt-2"/>
        </div>

        <div class="col-span-6 sm:col-span-4 sm:flex">
            <!-- First Name -->
            <div class="w-full sm:w-2/4">
                <x-jet-label for="first_name" value="{{ __('First Name') }}"/>
                <x-jet-input id="first_name" type="text" class="mt-1 block w-full" wire:model.defer="state.first_name"
                             autocomplete="first_name" maxlength="40"/>
                <x-jet-input-error for="first_name" class="mt-2"/>
            </div>

            <!-- Last Name -->
            <div class="w-full ml-0 mt-6 sm:ml-2 sm:w-2/4 sm:mt-0">
                <x-jet-label for="last_name" value="{{ __('Last Name') }}"/>
                <x-jet-input id="last_name" type="text" class="mt-1 block w-full" wire:model.defer="state.last_name"
                             autocomplete="last_name" maxlength="40"/>
                <x-jet-input-error for="last_name" class="mt-2"/>
            </div>
        </div>

        <!-- Email -->
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="email" value="{{ __('Email') }}"/>
            <x-jet-input id="email" type="text" class="mt-1 block w-full" wire:model.defer="state.email" readonly=""/>
            <x-jet-input-error for="email" class="mt-2"/>
        </div>
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="position" value="{{ __('Job Title') }}"/>
            <x-jet-input id="position" type="text" class="mt-1 block w-full" wire:model.defer="state.position"/>
            <x-jet-input-error for="position" class="mt-2"/>
        </div>

        <!-- Birthday -->
        <div class="col-span-6 sm:col-span-4 flex sm:flex-row flex-col -mb-10">
            <x-jet-label for="birthday_date" value="{{ __('Birthday') }}"/>
        </div>

        <div class="col-span-6 sm:col-span-4 flex sm:flex-row flex-col">
            <div class="w-2/4">
                <x-jet-label for="birthday_date" value="{{ __('Day') }}"/>
                <select wire:model.defer="state.birthday_date"
                        class="border-gray-300 focus:border-indigo-300 focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mr-5 my-1 w-40 sm:w-38 md:w-28 lg:w-44">
                    <option value="0">Day</option>
                    @for($i=1; $i<=31; $i++)
                        <option
                            value="{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}">{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}</option>
                    @endfor
                </select>

                <x-jet-input-error for="birthday_date" class="mt-2"/>
            </div>

            <!-- Name -->
            <div class="ml-0 sm:ml-2 w-2/4 sm:mt-0 mt-2">
                <x-jet-label for="birthday_month" value="{{ __('Month') }}"/>
                <select wire:model.defer="state.birthday_month"
                        class="border-gray-300 focus:border-indigo-300 focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mr-5 my-1 w-40 sm:38 md:w-28 lg:w-44">
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
{{--                    @for($i=1; $i<=12; $i++)--}}
{{--                        <option--}}
{{--                            value="{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}">{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}</option>--}}
{{--                    @endfor--}}
                </select>

                <x-jet-input-error for="birthday_month" class="mt-2"/>
            </div>
        </div>

        <!-- Work Anniversary -->
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="anniversary" value="{{ __('Start Date') }}"/>
            <x-jet-input id="anniversary" type="date" class="mt-1 block w-full" wire:model.defer="state.anniversary"/>
            <x-jet-input-error for="anniversary" class="mt-2"/>
        </div>

        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="currency" value="{{ __('Select Default Currency') }}"/>
            <select name="currency"
                    class="border-gray-300 focus:border-indigo-300 focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mr-5 my-1 mt-1 block w-full"
                    wire:model="state.currency">
                @foreach(\App\Models\Tango::all()->where('disable',0)->where('active',1)->pluck("currency")->flatten()->unique()->sort()->values()->all() as $currency)
                    <option value="{{ $currency }}">
                        {{ $currency }}
                    </option>
                @endforeach
            </select>
        </div>
    </x-slot>

    <x-slot name="actions">
        <x-jet-action-message class="mr-3 text-green-500" on="saved">
            {{ __('Profile Information Updated Successfully.') }}
        </x-jet-action-message>

        <x-jet-button wire:loading.attr="disabled" wire:target="photo">
            {{ __('Save') }}
        </x-jet-button>
    </x-slot>
</x-jet-form-section>
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
