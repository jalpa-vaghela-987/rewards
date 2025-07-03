@component('mail::message', [
    'appLogo' => $appLogo ?? null,
    'appName' => $appName ?? null,
])
{{$email}} submitted on PerkSweet.com at {{now()->toDateTimeString()}} time.

Thanks,<br>
{{ config('app.name') }}
@endcomponent
