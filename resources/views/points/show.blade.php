<x-app-layout>
    <link rel="stylesheet" type="text/css" href="/quill/quill-emoji.css">

    <script src="/quill/quill-emoji.js"></script>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Send '.getReplacedWordOfKudos()) }}
        </h2>
    </x-slot>

    <div class="container mx-auto px-4 py-10 md:py-12">
        <div class="flex flex-wrap space-y-10 md:space-y-0">
            <div class="w-full md:w-1/3 lg:w-2/6 xl:w-1/4">
                <div class="w-full">
                    @include('components.profile-card', ['user' => $user])
                </div>
            </div>

            <div class="w-full md:w-2/3 lg:w-4/6 xl:w-3/4 md:pl-6 lg:pl-10">
                <div class="p-8 bg-white shadow-md rounded rounded-t-lg mb-20 ">
                    <x-form-section submit="{{route('kudos.store')}}" shadow="no-shadow">
                        <x-slot name="title">
                            Send {{ getReplacedWordOfKudos() }} to {{$user->name}}
                        </x-slot>

                        <x-slot name="description">

                            Sending {{ getReplacedWordOfKudos() }} will help make {{$user->name}} feel like a valued
                            member of the {{$user->company->name}} team.
                        </x-slot>

                        <x-slot name="form">
                            {{--                            @if ($errors->any())--}}
                            {{--                                <div class="alert alert-danger">--}}
                            {{--                                    <ul>--}}
                            {{--                                        @foreach ($errors->all() as $error)--}}
                            {{--                                            <li>{{ $error }}</li>--}}
                            {{--                                        @endforeach--}}
                            {{--                                    </ul>--}}
                            {{--                                </div>--}}
                            {{--                            @endif--}}

                            {{--                            <div class="col-span-6 sm:col-span-4 ">--}}
                            {{--                                <x-jet-label for="amount" value="{{ __('Amount') }}"/>--}}

                            {{--                                <x-input id="amount" name="amount" value="{{old('amount')}}"--}}
                            {{--                                         type="number" min="10" max="1000"--}}
                            {{--                                         class="mt-1 block w-full" autofocus required/>--}}

                            {{--                                <x-jet-input-error for="amount" class="mt-2"/>--}}
                            {{--                            </div>--}}
                            <div class="col-span-6 sm:col-span-4">
                                <label
                                    class="border-gray-200 rounded relative border p-4 flex cursor-pointer">
                                    <input type="radio" name="kudos_type" value="standard"
                                           class="h-4 w-4 mt-0.5 cursor-pointer text-indigo-600 border-gray-300 focus:ring-indigo-500"
                                           aria-labelledby="privacy-setting-0-label"
                                           aria-describedby="privacy-setting-0-description">
                                    <div class="ml-3 flex flex-col">
                                        <!-- Checked: "text-indigo-900", Not Checked: "text-gray-900" -->
                                        <span id="privacy-setting-0-label"
                                              class="text-gray-900 block text-sm font-medium">
                                        Standard {{ getReplacedWordOfKudos() }} <span class="italic"> (standard thank you, well done, or great job)</span>
                                    </span>
                                        <!-- Checked: "text-indigo-700", Not Checked: "text-gray-500" -->
                                        <span id="privacy-setting-0-description" class="text-gray-500 block text-sm">
                                        {{ number_format(Auth::user()->company->standard_value) }}
                                    </span>
                                    </div>
                                </label>

                                <!-- Checked: "bg-indigo-50 border-indigo-200 z-10", Not Checked: "border-gray-200" -->
                                <label class="border-gray-200 rounded relative border p-4 flex cursor-pointer">
                                    <input type="radio" name="kudos_type" value="super"
                                           class="h-4 w-4 mt-0.5 cursor-pointer text-indigo-600 border-gray-300 focus:ring-indigo-500"
                                           aria-labelledby="privacy-setting-1-label"
                                           aria-describedby="privacy-setting-1-description">
                                    <div class="ml-3 flex flex-col">
                                        <!-- Checked: "text-indigo-900", Not Checked: "text-gray-900" -->
                                        <span id="privacy-setting-1-label"
                                              class="text-gray-900 block text-sm font-medium">
                                        Super {{ getReplacedWordOfKudos() }} <span class="italic">(for anything spectacular!)</span>
                                    </span>
                                        <!-- Checked: "text-indigo-700", Not Checked: "text-gray-500" -->
                                        <span id="privacy-setting-1-description" class="text-gray-500 block text-sm">
                                        {{ number_format(Auth::user()->company->super_value) }}
                                    </span>
                                    </div>
                                </label>

                                <x-jet-input-error for="kudos_type" class="mt-2"/>
                            </div>


                            <div class="col-span-6 sm:col-span-4">
                                <div class="italic text-sm w-full">
                                    You currently
                                    have {{number_format(Auth::user()->points_to_give)}} {{ getReplacedWordOfKudos() }}
                                    available to give.
                                </div>
                            </div>

                            <br>

                            <div class="col-span-6 sm:col-span-4 -mt-2">
                                <x-jet-label for="message" value="{{ __('Add a Short Message!') }}"/>

                                <x-text-area id="message" name="message" type="text" class="mt-1 block w-full hidden"
                                             autofocus/>
                                <div class="card-element-text min-h-40">
                                    <div class="mt-2 bg-white min-h-40">
                                        <div id="quill-editor2"
                                             class="rounded min-h-40 free_form font-handwriting tracking-wide text-lg"
                                             style="min-height: 150px;">
                                            {!!old('message')!!}
                                        </div>
                                    </div>
                                </div>

                                <x-jet-input-error for="message" class="mt-2"/>
                            </div>

                            <input type="hidden" name="user_id" value="{{$user->id}}">
                        </x-slot>

                        <x-slot name="actions">
                            <x-jet-button>
                                {{ __('Send '.getReplacedWordOfKudos()) }}
                            </x-jet-button>
                        </x-slot>

                        <br>
                    </x-form-section>
                </div>
            </div>

        </div>

        <script type="text/javascript">

            //var quill = new Quill('#quill-editor2', {theme: 'snow'});


            var toolbarOptions = {
                container: [
                    ['bold', 'italic', 'underline', 'strike'],
                    //['blockquote'],
                    [{'list': 'bullet'}],
                    //[{'indent': '-1'}, {'indent': '+1'}],
                    [{'color': []}, {'background': []}],
                    //[{'font': []}],
                    // [{'align': []}],
                    ['clean'],
                    ['emoji'],
                    ['link']
                    //['link', 'image', 'video']
                ],
                handlers: {
                    'emoji': function () {
                    }
                }
            }

            var quill = new Quill('#quill-editor2', {
                modules: {
                    "toolbar": toolbarOptions,
                    "emoji-toolbar": true,
                    "emoji-shortname": true,
                    "emoji-textarea": true
                },
                placeholder: 'Write something amazing...',
                theme: 'snow',
            });


            quill.on('text-change', function () {
                $('#message').val(quill.root.innerHTML);
            });

        </script>
    </div>
    <livewire:give-kudos-welcome/>
</x-app-layout>






