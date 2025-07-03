<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            You received {{ number_format($point->amount) }} {{ getReplacedWordOfKudos() }} from {{ giverName($point) }}
        </h2>
    </x-slot>

    <div class="container mx-auto px-5 lg:px-24 py-10 md:py-24">
         @include('components.social-card', ['point' => $point])
    </div>
</x-app-layout>
