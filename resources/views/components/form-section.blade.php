@props(['submit', 'shadow'=>'shadow', 'formClass' => ''])

<div {{ $attributes->merge(['class' => 'md:grid xl:grid-cols-3 gap-4 md:gap-6']) }}>
    <x-jet-section-title>
        <x-slot name="title">{{ $title }}</x-slot>
        <x-slot name="description">{{ $description }}</x-slot>
    </x-jet-section-title>

    <div class="mt-5 md:mt-0 md:col-span-2">
        <form method="POST" action="{{$submit}}">
            @CSRF
            <div class="bg-white {{ $shadow }}
            @if($shadow != 'no-shadow')
            px-4 py-5
            {{ isset($actions) ? 'sm:rounded-tl-md sm:rounded-tr-md' : 'sm:rounded-md' }}
             @endif
            ">
                <div class="grid gap-4
                     @if($shadow != 'no-shadow')
                    grid-cols-6 gap-6
                    @endif
                    {{ $formClass }}
                ">
                    {{ $form }}
                </div>
            </div>

            @if (isset($actions))
                <div class="flex items-center justify-end py-3 text-right
                {{ $shadow.' bg-white' }}
                @if($shadow != 'no-shadow') bg-gray-50 @endif
                 sm:rounded-bl-md sm:rounded-br-md">
                    {{ $actions }}
                </div>
            @endif
        </form>
    </div>
</div>
