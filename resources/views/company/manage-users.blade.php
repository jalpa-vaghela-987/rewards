<x-app-layout>
    <div class="container mx-auto px-4 py-10 md:py-12">
        <livewire:add-user-by-email/>

        <div>
            <div class="container mx-auto px-4 py-10 md:py-12">
{{--                @livewire('modify-company-users')--}}
                <livewire:modify-company-users/>
{{--                <x-jet-section-border/>--}}
            </div>

{{--            <div class="container mx-auto px-4 py-10 md:py-12">--}}
{{--                @livewire('invitation-tracker')--}}
{{--                <x-jet-section-border />--}}
{{--            </div>--}}
        </div>
    </div>

    <livewire:welcome-manage-users/>
</x-app-layout>
