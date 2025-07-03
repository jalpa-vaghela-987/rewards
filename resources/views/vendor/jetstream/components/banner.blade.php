@props(['style' => session('flash.bannerStyle', 'success'), 'message' => session('flash.banner')])

<div x-data="{{ json_encode(['show' => true, 'style' => $style, 'message' => $message, 'timeout' => 3000]) }}"
     x-show="show && message" class="relative z-50 flash-alert"

     x-on:notify.window="
        message = $event.detail.message;
        if($event.detail.style) {
            style = $event.detail.style;
        } else {
            style = 'success';
        }
        if($event.detail.timeout) {
            timeout = $event.detail.timeout;
        } else {
            timeout = 3000;
        }
        setTimeout(() => { message=''; }, timeout);
     "
>
    <div class="max-w-screen-xl mx-auto fixed bottom-5 right-5 rounded-lg p-2 pr-4"
        :class="{ 'bg-indigo-500': style == 'success', 'bg-red-700': style == 'danger' }"
    >
        <div class="flex items-center justify-between flex-wrap">
            <div class="flex-1 flex items-center min-w-0">
                <span class="flex p-2 rounded-lg" :class="{ 'bg-indigo-600': style == 'success', 'bg-red-600': style == 'danger' }">
                    <svg class="h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </span>

                <p class="m-0 ml-3 font-medium text-sm text-white truncate" x-text="message"></p>
            </div>

            <div class="flex-shrink-0 sm:ml-3">
                <button type="button" class="-mr-1 flex p-2 rounded-md focus:outline-none sm:-mr-2 transition ease-in-out duration-150"
                    :class="{ 'hover:bg-indigo-600 focus:bg-indigo-600': style == 'success', 'hover:bg-red-600 focus:bg-red-600': style == 'danger' }"
                    x-on:click="message = ''; show = false" aria-label="Dismiss">
                    <svg class="h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
    document.addEventListener("livewire:load", function(event) {
        $(".flash-alert").slideDown(300).delay(3000).slideUp(300);
    });
</script>
