@props(['shadow'=>'shadow'])

<div {{ $attributes->merge(['class' => isset($title) && isset($description) ? 'md:grid md:grid-cols-3 md:gap-6' : 'md:gap-6']) }}>
    @if(isset($title) && isset($description))
    <x-jet-section-title>
        <x-slot name="title">{{ $title }}</x-slot>
        <x-slot name="description">{{ $description }}</x-slot>
    </x-jet-section-title>
    @endif

    <div class="mt-5 md:mt-0 md:col-span-2">
        <div>
            <div class="bg-white {{ $shadow }}
            @if($shadow != 'no-shadow')
            px-4 py-5
            {{ isset($actions) ? 'sm:rounded-tl-md sm:rounded-tr-md' : 'sm:rounded-md' }}
             @endif
            ">
                <div class="grid
                     @if($shadow != 'no-shadow')
                    grid-cols-6 gap-6
                    @endif
                ">
                    {{ $form }}
                </div>
            </div>

            @if (isset($actions))
                <div class="flex items-center justify-end px-4 py-3 text-right sm:px-6
                {{ $shadow.' bg-white' }}
                @if($shadow != 'no-shadow') bg-gray-50 @endif
                 sm:rounded-bl-md sm:rounded-br-md">
                    {{ $actions }}
                </div>
            @endif
        </div>
    </div>
</div>
