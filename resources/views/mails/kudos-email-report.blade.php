@component('mail::message', ['appLogo' => $appLogo, 'appName' => $appName])
<h1>{{ $appName }} Weekly Activity Report - {{ now()->format('l, F jS, Y') }}</h1>

<span style='font-weight:bold; font-size:19.000px; color: #1D4ED8;'>
{{ $points->count() }} Kudos
</span> {{ __('have been shared since your last report!') }}

{{ __('Check out what your coworkers are saying.') }}

<hr/>

@component('mail::button', ['url' => $buttonUrl])
{{ $buttonText }}
@endcomponent

@forelse($points as $point)
{{--<hr style="margin: 0px;">--}}
<table width="100%" border="1" style="border-width: thin; border-radius: 10px; border-color: aliceblue; max-height: 500px; margin-bottom: 20px; height: auto; font-family: 'Nunito', sans-serif !important;">
<tr>
<td colspan="100%" style="border-radius: 8px 8px 0 0;">
<table width="100%" style="/*border-bottom: 1px solid black;*/ padding: 20px !important; font-size: 16px !important;">
<tr>
<td>
@if($point->giver && $point->giver->id)
<a style="text-decoration-line: none" href="{{ route('profile.user', ['user' => $point->giver->id])}}">
{{ giverName($point) }}
</a>
@else
<span>{{ giverName($point) }}</span>
@endif
sent
@if($point->is_super)
Super {{ $kudosText }}
@else
{{ $kudosText }}
@endif
to
<a style="text-decoration-line: none" href="{{ route('profile.user',['user' => $point->reciever->id])}}">
{{ $point->reciever->name }}
</a>
</td>
</tr>
</table>
</td>
</tr>

<tr class="container">
<td width="100%">
<table width="100%" {{--class="content-table-sm"--}}>
<tr>
<td class="left-content" style="width: 100% !important;">
{!! html_entity_decode(htmlspecialchars_decode($point->message)) !!}
</td>
</tr>
<tr>
<td class="right-content" colspan="100%">
<table style="height: 100%; width: 100%;">
<tr style="height: 60% !important;">
<td align="center" valign="bottom">
<hr>
<a style="text-decoration-line: none; font-size: 16px !important;" href="{{ route('profile.user',['user' => $point->reciever->id])}}">
{{ $point->reciever->name }}
</a>

<a style="margin-left: 2px; margin-top: 0.5px" href="mailto:{{$point->giver->email}}">
<img src="/icons/envelope-solid.png" style="height: 15px; width: 15px">
</a>

</td>
</tr>
<tr style="height: 40% !important;">
<td align="center" valign="top">
<div style="color: gray; font-style: italic; font-size: 14px; margin-top: 3px; margin-bottom: 5px;">
{{$point->reciever->position}}
</div>
</td>
</tr>
<tr style="height: 40% !important;">
<td align="center" valign="top">
<a href="{{ route('kudos-show', ['user' => $point->reciever->id]) }}"><img src="/icons/hands-wash-solid.png" style="height: 17px; width: 17px" /></a>
<a href="{{ route('card.create', ['user' => $point->reciever->id]) }}" style="margin-left: 17px"><img src="/icons/object-group-solid.png" style="height: 17px; width: 17px" /></a>
</td>
</tr>
</table>
</td>
</tr>
</table>
</td>
</tr>

<tr>
<td colspan="100%" style="border-radius: 0 0 8px 8px; text-align: right; padding: 7px 12px; font-size: 11px; color: gray; font-style: italic">
{{ $point->created_at->format('g:i A \o\n F jS, Y') }}
</td>
</tr>
</table>
{{--<hr style="margin: 0px; margin-bottom: 10px;">--}}
@empty
{{ __('No Kudos') }}

@endforelse

<div style="padding: 20px 0px;">
{{ __('Thank you for using '. appName() .'!') }}
</div>

<div>
Thanks,<br>
{{ config('app.name') }}
</div>

@section('head')
<link href="https://fonts.googleapis.com/css2?family=Handlee&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200;1,200&display=swap" rel="stylesheet">
@endsection

@section('styles')
@font-face {
font-family: 'Handlee';
font-style: normal;
font-weight: 400;
mso-font-alt: 'sans-serif';
src: url(https://fonts.googleapis.com/css2?family=Handlee&display=swap);
}

@font-face {
font-family: 'Nunito';
font-style: normal;
font-weight: 400;
mso-font-alt: 'sans-serif';
src: url(https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200;1,200&display=swap);
}

.content-table-sm{
display: none;
}

.content-table-lg{
display: table;
}

.container {
padding: 10px;
min-height: 180px;
height: 100%;
{{--display: flex;--}}
}

.left-content {
width: 70%;
padding: 13px 20px;
min-height: 150px;
font-family: 'Handlee', sans-serif !important;
{{--border-right: 1px solid black;--}}
vertical-align: top;
line-height:28px;
font-size: 17px;
letter-spacing: 0.4px;
}

@media only screen and (max-width: 550px) {
.left-content {
width: 100% !important;
border-right: 0px !important;
padding:13px 20px !important;
{{--border-bottom: 1px solid black !important;--}}
min-height: 60px !important;
}

.right-content {
width: 100% !important;
text-align: center !important;
padding: 13px 20px 10px !important;
}

.container {
display: contents !important;
min-height: 155px !important;
}

.content-table-sm{
display: table !important;
}

.content-table-lg{
display: none !important;
}
}

.right-content {
width: 30%;
padding: 15px;
{{--display: flex;--}}
{{--flex-direction: column;--}}
{{--justify-content: center;--}}
{{--align-items: center;--}}
text-align: center;
}

table {
border-spacing: 0px !important;
}
@endsection

@endcomponent
