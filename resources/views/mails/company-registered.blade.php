@component('mail::message', [
    'appLogo' => $appLogo ?? null,
    'appName' => $appName ?? null,
])
# New Company Registered

<b>Date & Time of Registration : </b> {{ now()->toDateTimeString() }}

<b>User Name & Email : </b> {{ $user->name }} - {{ $user->email }}

<b>Company Name : </b> {{ $company->name }}

Thanks,<br>
{{ config('app.name') }}
@endcomponent
