<div>
{{--    <x-jet-section-border/>--}}

<!-- Add Team Member -->
    <div class="mt-10 sm:mt-0">
        <x-jet-form-section submit="sendInvitation">
            <x-slot name="title">
                {{ __('Invite Bulk Users') }}
            </x-slot>

            <x-slot name="description">
                {{ __('Invite a new users to join '. appName() .' using sheets, allowing them access to the full platform.') }}
            </x-slot>

            <x-slot name="form">
                <div class="col-span-12">
                    <div class="max-w-xl text-sm text-gray-600">
                        {{ __('Please provide the sheet of the person you would like to invite to the company.') }}
                    </div>
                </div>

                <div class="col-span-12 my-5">
                    <div class="flex justify-between">
                        <div>
                            <x-jet-label for="title" value="{{ __('Upload Sheet') }}"/>
                        </div>

                        <div class="md:mr-2 mr-0">
                            <a href="/sample/user_invites.xlsx" class="hover:text-indigo-500 text-gray-500 text-sm cursor-pointer" download>
                                <i class="fa fa-download"></i> Download sample sheet
                            </a>
                        </div>
                    </div>

                    <div class="flex w-full @if($invite_sheet) p-2 mt-1 flex-1 justify-between border-2 border-gray-300 bg-green-50 items-center border-dashed rounded-md @endif"
                         x-data="{ isUploading: false, progress: 0 }"
                         x-on:livewire-upload-start="isUploading = true"
                         x-on:livewire-upload-finish="isUploading = false"
                         x-on:livewire-upload-error="isUploading = false"
                         x-on:livewire-upload-progress="progress = $event.detail.progress"
                    >
                        @if(!$invite_sheet)
                            <div class="mt-1 flex flex-1 justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                                <div class="space-y-1 text-center" wire:loading.remove wire:target="invite_sheet">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>

                                    <div class="flex text-sm text-gray-600">
                                        <label for="file-upload" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                            <span>Upload a file</span>
                                            <input id="file-upload" wire:model="invite_sheet" name="invite_sheet" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" type="file" class="sr-only">
                                        </label>

                                        <p class="pl-1">CSV, XLS, XLSX up to 10MB</p>
                                    </div>
                                </div>

                                <div class="w-full h-12 items-center" wire:loading.flex wire:target="invite_sheet">
                                    <div class="select-none text-sm text-indigo-500 flex flex-1 items-center justify-center text-center p-4 flex-1">
                                        <svg class="animate-spin h-6 w-6 text-indigo-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="w-3/4">
                                <p class="truncate text-green-600 ml-1.5">{{ $invite_sheet->getClientOriginalName() }}</p>
                            </div>

                            <div class="ml-1 h-5 w-5 rounded-xl flex items-center border bg-red-400 border-red-800 justify-center opacity-75 hover:opacity-100 cursor-pointer text-gray-700" x-on:click="isUploading=false; $wire.removeUpload('invite_sheet', '{{$invite_sheet->getFilename()}}');">
                                <span><i class="fa fa-times text-xs mb-1.5"></i></span>
                            </div>
                        @endif
                    </div>

                    @error('*')
                        <p class="mt-2">Fix below errors to initiate user invitation.</p>
                    @enderror

                    <x-jet-input-error for="invite_sheet" class="mt-2"/>

                    @foreach($errorKeys as $errorKey)
                        @error("*$errorKey")
                            <p class="text-sm text-red-600 mt-2">{{ $this->getErrorMessage($message) }}</p>
                        @enderror
                    @endforeach
                </div>

                <div class="col-span-12">
                    <x-jet-label class="font-bold text-indigo-600">Important Notes:</x-jet-label>
                    <ul class="list-disc ml-5 text-sm text-gray-600">
                        <li>
                            Allowed role:
                            <span class="font-bold">
                                editor, admin
                            </span>
                        </li>
                        <li>
                            Allowed level:
                            <span class="font-bold">
                                level 1, level 2, level 3, level 4, level 5
                            </span>
                        </li>
                        <li>Optional Fields: <span class="font-bold">birthday, anniversary, team</span></li>
                        <li>If any detail is filled wrong then invitation won't be sent to any user.</li>
                        <li>If sheet contains wrong details, then error will be displayed above notes. and need to fix shown error for successful invites.</li>
                    </ul>
                </div>
            </x-slot>

            <x-slot name="actions">
                <x-jet-action-message class="mr-3 text-green-500" on="saved">
                    {{ __('New Users has been invited successfully.') }}
                </x-jet-action-message>

                <x-jet-button>
                    {{ __('Invite') }}
                </x-jet-button>
            </x-slot>
        </x-jet-form-section>
    </div>
</div>
