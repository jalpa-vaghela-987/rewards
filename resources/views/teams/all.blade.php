<x-app-layout>

    <div class="container mx-auto px-4 py-10">
        <div class="w-full px-4 sm:px-0 mt-4 mb-4">
            <h2 class="text-2xl lg:text-3xl font-semibold text-gray-900">{{$team->name}}</h2>
        </div>

        <div class="grid grid-cols-1 xl:grid-cols-4 lg:grid-cols-3 md:grid-cols-2 sm:grid-cols-2 gap-6">
        @foreach($team->users->unique()->where('active', 1)->sortBy('name')  as $u)
            @include('components.profile-card', ['user' => $u])
        @endforeach

        </div>
    </div>

</x-app-layout>
