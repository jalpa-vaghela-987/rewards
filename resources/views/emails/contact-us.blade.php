@component('mail::message', [
    'appLogo' => $appLogo ?? null,
    'appName' => $appName ?? null,
])
# Inquiry Received

# Email
{{ $data['email'] }}

# Company Name
{{ $data['company_name'] }}

# Additional Information
{{ $data['additional_information'] }}

Thanks,<br>
{{ config('app.name') }}
@endcomponent
