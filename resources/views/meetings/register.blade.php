<x-app-layout>
    <div class="container mx-auto px-4 py-10 md:py-12">
        @php
            if(Auth::user()->meetingConfig){
                $saved_start = \Carbon\Carbon::parse(Auth::user()->meetingConfig->start_time)->format('H:i');
                $saved_end = \Carbon\Carbon::parse(Auth::user()->meetingConfig->end_time)->format('H:i');
            }
        @endphp

        <div class="max-w-3xl mx-auto bg-white shadow p-4 py-6 md:p-10 rounded">
            <div class="text-xl text-blue-800 font-semibold">
                Join {{ appName() }} Connect!
            </div>

            {{--            <x-jet-validation-errors class="mb-4 mt-2"/>--}}

            <form method="POST" action="{{ route('connect.create') }}">
                @csrf

                <div class="mt-2 py-2">
                    <x-jet-label for="interests"
                                 value="{{ __('Outside of work, what are some of your interests and favorite activities?') }}"/>
                    <x-jet-input id="interests" class="block mt-1 w-full" type="text" name="interests"
                                 :value="old('interests',(Auth::user()->meetingConfig->interests ?? ''))" required
                                 autofocus maxlength="350"
                                 autocomplete="interests"/>
                    <x-jet-input-error for="interests" class="mt-2"/>
                </div>

                <div class="mt-6 py-2">
                    <x-jet-label for="expertise"
                                 value="What are some areas of expertise and talents that you possess?"/>
                    <x-jet-input id="expertise" class="block mt-1 w-full" type="text" name="expertise"
                                 :value="old('expertise',(Auth::user()->meetingConfig->expertise ?? ''))" required
                                 autofocus maxlength="350"
                                 autocomplete="expertise"/>
                    <x-jet-input-error for="expertise" class="mt-2"/>
                </div>

                <div class="mt-6 py-2">
                    <x-jet-label for="develop" value="{{ __('What are some areas you would like to develop?') }}"/>
                    <x-jet-input id="develop" class="block mt-1 w-full" type="text" name="develop"
                                 :value="old('develop',(Auth::user()->meetingConfig->develop ?? ''))" required
                                 autofocus maxlength="350"
                                 autocomplete="develop"/>
                    <x-jet-input-error for="develop" class="mt-2"/>
                </div>

                <div class="text-lg text-blue-800 font-semibold mt-6">Availability Window</div>
                <div class="text-sm">One-on-ones can easily be rescheduled so try to leave a large window to accommodate
                    others and meet with more people. One-on-ones will only take place Monday through Friday, though
                    hours
                    may vary depending on schedules.
                </div>

                <div class="mt-1 py-2">
                    <x-jet-label for="start_time"
                                 value="{{ __('Generally, what time would you first be available to connect? ') }}"/>
                    <x-jet-input id="start_time" class="block mt-1" type="time" name="start_time"
                                 value="{{ $saved_start ?? old('start_time','08:00') }}"
                                 required autofocus autocomplete="start_time"/>
                    <x-jet-input-error for="start_time" class="mt-2"/>
                </div>

                <div class="mt-6 py-2">
                    <x-jet-label for="end_time"
                                 value="{{ __('What time would be the latest you would be available?') }}"/>
                    <x-jet-input id="end_time" class="block mt-1 " type="time" name="end_time"
                                 value="{{ $saved_end ?? old('end_time','18:30') }}"
                                 required autofocus autocomplete="end_time"/>
                    <x-jet-input-error for="end_time" class="mt-2"/>
                </div>

                <div class="mt-2 py-2">
                    @if(!Auth::user()->meetingConfig)
                        I would like to opt-in to {{ appName() }} Connect.
                    @else
                        @if(Auth::user()->meetingConfig->active)
                            <span class="text-sm">Remain opted-in to {{ appName() }} Connect (uncheck to opt-out). Opting-out will not cancel any scheduled one-on-ones.</span>
                        @else
                            You are currently opted-out. Opt-in?
                        @endif
                    @endif

                    <input id="active" name="active" type="checkbox"
                           class='rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 h-6 w-6 ml-4 m-1'
                           value="1"
                           @if(!Auth::user()->meetingConfig || Auth::user()->meetingConfig->active)
                           checked
                           @elseif(Auth::user()->meetingConfig && Auth::user()->meetingConfig->active == 0)

                           @else
                           checked
                        @endif
                    >
                </div>


                <div class="flex items-center justify-end mt-4">
                    <x-jet-button class="ml-4">
                        @if(Auth::user()->meetingConfig)
                            {{ __('Update Preferences') }}
                        @else
                            {{ __('Save Preferences!') }}
                        @endif
                    </x-jet-button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
