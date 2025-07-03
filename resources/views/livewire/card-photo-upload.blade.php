//not used!!!!!!!!!
<form wire:submit.prevent="uploadCardPhoto">
    <div x-data="{photoName: null, photoPreview: null}" class="col-span-6 sm:col-span-4">
        <input type="file"
               class="hidden"
               accept="image/*"
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
            <img src="{{ $cardElement->media_path ?? '/card_themes/gift3.png' }}"
                 class="rounded-full h-20 w-20 object-cover">
        </div>

        <!-- New Profile Photo Preview -->
        <div class="mt-2" x-show="photoPreview">
                    <span class="block rounded-full w-20 h-20"
                          x-bind:style="'background-size: cover; background-repeat: no-repeat; background-position: center center; background-image: url(\'' + photoPreview + '\');'">
                    </span>
        </div>

        <x-jet-secondary-button class="mt-2 mr-2" type="button" x-on:click.prevent="$refs.photo.click()">
            {{ __('Select A Photo') }}
        </x-jet-secondary-button>

        <x-jet-button>
            {{ __('Save Photo') }}
        </x-jet-button>


        @if (false)
            <x-jet-secondary-button type="button" class="mt-2" wire:click="deleteProfilePhoto">
                {{ __('Remove Photo') }}
            </x-jet-secondary-button>
        @endif

        <x-jet-input-error for="photo" class="mt-2"/>
    </div>
</form>
