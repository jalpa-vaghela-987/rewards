<div class="min-h-screen flex flex-col justify-center items-center py-6 sm:pt-0 bg-gray-100" {{$attributes}}>
    <div>
        {{ $logo }}
    </div>

    <div class="w-11/12 sm:max-w-md px-6 py-4 bg-white shadow-md overflow-hidden rounded-lg mt-3">
        {{ $slot }}
    </div>
</div>
