<x-guest-layout>

    <div class="my-5">
        {{ $checkout->button('Checkout with Stripe!', ['class' => 'inline-flex items-center px-4 py-2 bg-blue-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-600 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150 stripe_checkout_button']) }}
    </div>

    <script type="text/javascript">
        $('.stripe_checkout_button').trigger('click');
    </script>

</x-guest-layout>
