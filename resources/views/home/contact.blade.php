<x-home-layout>
    <x-slot name="hide_bottom">
        true
    </x-slot>

    <x-slot name="largeSection">
        <div class="py-20 xl:py-48">
            <h1 class="ps-home-1405__title typ-hero-header bhrtyp-italic text-gray-900"
                style="font-size: 60px; line-height: 55px; text-align: center;">Contact</h1>

            <div class="typ-subhead1 bhrtyp-center bhrcolor-gray9">
                Get in touch with a member of the {{ appName(true) }} team!
            </div>

            <div style="color: black;">
                <form action="{{route('connect-us.store')}}" method="POST">
                    @csrf
                    <div class="col-span-6 sm:col-span-4 mt-2">
                        <x-jet-label for="email" value="{{ __('Email') }}"/>
                        <x-jet-input id="email" type="email" name="email" class="mt-1 block w-full" required />
                        <x-jet-input-error for="email" class="mt-2"/>
                    </div>

                    <div class="col-span-6 sm:col-span-4 mt-2">
                        <x-jet-label for="company_name" value="{{ __('Company Name') }}"/>
                        <x-jet-input id="company_name" type="text" name="company_name" class="mt-1 block w-full" maxlength="120" required />
                        <x-jet-input-error for="company_name" class="mt-2"/>
                    </div>

                    <div class="col-span-6 sm:col-span-4 mt-2">
                        <x-jet-label for="additional_information" value="{{ __('Additional Information') }}" required />
                        <textarea rows="5"
                                  name="additional_information"
                                  class="mt-1 block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                        </textarea>
                        <x-jet-input-error for="additional_information" class="mt-2"/>
                    </div>

                    <div class="col-span-6 sm:col-span-4 mt-2">
                        <x-jet-label for="additional_information" value="{{ __('') }}"/>
                        {!! NoCaptcha::renderJs() !!}
                        {!! NoCaptcha::display() !!}

                        <x-jet-input-error for="g-recaptcha-response" class="mt-2"/>
                    </div>

                    <div
                        class="flex items-center justify-end px-4 py-3 text-right sm:px-6 sm:rounded-bl-md sm:rounded-br-md">
                        <x-jet-button type="submit">
                            {{ __('Send') }}
                        </x-jet-button>
                    </div>

                    <div class="text-center text-black mt-5">
                        <div>
                            @if (session()->has('message'))
                                <div class="text-red-500 text-md hover:text-red-500">
                                    {{ session('message') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </form>
            </div>

            <div class="text-center text-black mt-5">
                <a href="mailto:nick@perksweet.com" class="text-blue-700  text-md hover:text-blue-500">
                    Contact Sales
                </a> - sales@perksweet.com
            </div>

<div class="my-10 w-full text-center">
<a class="text-md my-5 p-1 py-3 sm:p-3 sm:px-6 rounded-xl border-2 border-pink-500 border-solid bg-white-200 text-pink-500 hover:bg-pink-500 hover:text-white hover:border-pink-500"
        style="font-family: Montserrat, Lato, Arial, Helvetica, sans-serif;
                        font-size: 15px;
                        font-weight: 600;
                        "
                         href="/faq">
                         View Frequently Asked Questions
        </a>
</div>
        </div>
    </x-slot>

</x-home-layout>
