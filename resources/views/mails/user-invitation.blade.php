@component('mail::message', [
    'appLogo' => $appLogo ?? null,
    'appName' => $appName ?? null,
])
# Hello!

{{$sender}} has invited you to join {{ $appName }}.

{{ $appName }} is an employee engagement & rewards platform that lets you easily recognize and say thank you to your team.

@component('mail::button', ['url' => $url])
Sign up!
@endcomponent

Thank you for using {{ $appName }}.

Regards,<br>
{{ $appName }} Team

<div style="border-top: 1px solid #dadcda; margin-top: 20px; margin-bottom: 25px;"></div>

<small>
If you’re having trouble clicking the "Sign up!" button, copy and paste the URL below into your web browser: <a style="word-break: break-all" href="{{$url}}">{{$url}}</a>
</small>
@endcomponent
