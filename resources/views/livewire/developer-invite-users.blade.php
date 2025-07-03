<div class="p-5 md:p-8 bg-white my-0 md:my-10 border border-gray-300 rounded rounded-t-lg ">
    <div class="w-full text-left mt-5">
        <div class="md:flex">
            <div class="w-full md:w-1/3">
                <p class="text-xl mb-2 font-bold">Invite Users!</p>
                <p>You can import users sheet to send bulk invitation.</p>
                <p>Download sample sheet, so invitation process work perfectly.</p>
            </div>

            <div class="w-full md:w-2/3 mt-3 md:mt-0">
                <div class="border shadow rounded-md md:ml-5 md:p-5">
                    <x-jet-section-title>
                        <x-slot name="title">{{ __('Send Bulk Invitation') }}</x-slot>
                        <x-slot name="description">{{ __('Select Company and upload users sheet to send bulk invitation!') }}</x-slot>
                    </x-jet-section-title>

                    <form wire:submit.prevent="sendInvitation" enctype="multipart/form-data" class="p-5 md:p-0">
                        <div class="">
                            <div class="my-3">
                                <x-jet-label for="title" value="{{ __('Select Company') }}"/>

                                <input wire:model.debounce.500ms="company_search" type="search" id="searchbar"
                                       autocomplete="off" placeholder="Company..."
                                       class="focus:outline-none border-gray-200 p-1 mt-3" autofocus
                                       style="border-top:none; border-left: none; border-right: none;">

                                <x-jet-input-error for="company" class="mt-2"/>

                                <ul class="absolute z-50 bg-white shadow-md rounded-md text-gray-700 text-sm divide-y divide-gray-300  mt-3" id="search_ul2" style="width: 300px;;">
                                    @foreach($companies as $result)
                                        <li class="border border-gray-300">
                                            <div wire:click.prevent="selectCompany({{$result->id}})" class="flex items-center px-4 py-4 hover:bg-gray-200 transition ease-in-out duration-150 cursor-pointer">
                                                <img src="{{$result->logo_path}}" class="w-10 rounded-full">

                                                <div class="ml-4 leading-tight overflow-hidden">
                                                    <div class="font-semibold">{{$result->name}}</div>
                                                    <div class="text-gray-600 truncate">
                                                        {{$result->description}}
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>

                            <div class="my-5">
                                <div class="flex justify-between">
                                    <div>
                                        <x-jet-label for="title" value="{{ __('Upload Sheet') }}"/>
                                    </div>

                                    <div class="md:mr-2 mr-0">
                                        <a href="/sample/user_invites.xlsx" class="text-gray-500 text-sm cursor-pointer" download>
                                            <i class="fa fa-download"></i> Download sample sheet
                                        </a>
                                    </div>
                                </div>

                                <div class="flex w-full @if($invite_sheet) p-2 mt-1 flex-1 justify-between border-2 border-gray-300 bg-green-100 items-center border-dashed rounded-md @endif"
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
                                        <p class="truncate text-green-600 ml-2.5">{{ $invite_sheet->getClientOriginalName() }}</p>
                                    </div>

                                    <div class="h-5 w-5 rounded-xl flex items-center border bg-red-400 border-red-800 justify-center opacity-75 hover:opacity-100 cursor-pointer text-gray-700" x-on:click="isUploading=false; $wire.removeUpload('invite_sheet', '{{$invite_sheet->getFilename()}}');">
                                        <span><i class="fa fa-times text-xs mb-1.5"></i></span>
                                    </div>
                                    @endif
                                </div>

                                @error('*')
                                    <p class="mt-2">Fix below errors to initiate user invitation.</p>
                                @enderror

                                <x-jet-input-error for="invite_sheet" class="mt-2"/>

                                @error("*.name")
                                    <p class="text-sm text-red-600 mt-2">{{ $this->getErrorMessage($message) }}</p>
                                @enderror
                                @error("*.level")
                                    <p class="text-sm text-red-600 mt-2">{{ $this->getErrorMessage($message) }}</p>
                                @enderror
                                @error("*.email")
                                    <p class="text-sm text-red-600 mt-2">{{ $this->getErrorMessage($message) }}</p>
                                @enderror
                                @error("*.role")
                                    <p class="text-sm text-red-600 mt-2">{{ $this->getErrorMessage($message) }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="flex items-center justify-end py-3 text-right no-shadow bg-white sm:rounded-bl-md sm:rounded-br-md">
                            <x-jet-action-message class="mr-3 text-green-500" on="saved">
                                {{ __('Invitation sent to users.') }}
                            </x-jet-action-message>

                            <x-jet-button>
                                {{ __('Send Invitation') }}
                            </x-jet-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
