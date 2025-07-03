@component('mail::message')
# Reward Redemption Error

<pre>
    {{ print_r($data) }}
</pre>

{{--@component('mail::button', ['url' => ''])--}}
{{--Button Text--}}
{{--@endcomponent--}}

Thanks,<br>
{{ config('app.name') }}
@endcomponent
