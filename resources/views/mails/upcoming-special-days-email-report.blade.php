@component('mail::message', [
    'appLogo' => $appLogo ?? null,
    'appName' => $appName ?? null,
])
<h1>{{ $appName }} Bi-Weekly Upcoming Birthday/Anniversary Report - {{ now()->format('l, F jS, Y') }}</h1>

<span style='font-weight:bold; font-size:19.000px; color: #1D4ED8;'>
{{ $specialDays->count() }} members have a birthday or work anniversary in the next 30 day.
</span>

<hr/>

<div style="display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 8px; margin-top: 5px">
@foreach($specialDays as $specialDay)
<table style="width: 100%">
<tr style="border-bottom: 1px solid gray">
<td width="23%" style="margin-top: 0px; display: table-row-group">
<table width="100%">
<tr>
<td valign="top">
<img style="height: 2.5rem; width: 2.5rem; border-radius: 9999px" src="{{ $specialDay->profile_photo_url }}" alt="">
</td>
</tr>
<tr>
<td valign="bottom">
<div style="text-align: center; margin-top: 8px">
<a href="{{ route('kudos-show', ['user' => $specialDay->id]) }}"><img src="{{url('/icons/hands-wash-solid.png')}}" style="height: 14px; width: 14px" /></a>
<a href="{{ route('card.create', ['user' => $specialDay->id]) }}" style="margin-left: 5px"><img src="{{url('/icons/object-group-solid.png')}}" style="height: 14px; width: 14px" /></a>
</div>
</td>
</tr>
</table>
</td>
<td width="78%" valign="top">
<table width="100%">
<tr>
<td>
<span style="font-weight: 700; color: black;">
{{ $specialDay->name }}
</span>
{{--<a style="margin-left: 2px; margin-top: 0.5px" href="mailto:{{$specialDay->email}}">--}}
{{--<img src="/icons/envelope-solid.png" style="height: 15px; width: 15px">--}}
{{--</a>--}}
</td>
</tr>
<tr>
<td>
<p style="font-size: 0.875rem; line-height: 1.25rem; font-style: italic; font-weight: 400; color: rgb(17 24 39); margin-bottom: 2px">
{{ $specialDay->position }}
</p>
</td>
</tr>

<tr>
<td>
<div style="display: flex">
@if($specialDay->special_day === 'birthday')
<img src="{{url('/icons/birthday-cake-solid.png')}}" style="height: 17px; width: 17px">

<p style="font-size: 0.875rem; line-height: 1.25rem; color: rgb(107 114 128); margin-left: 2px; margin-top: 0px">
{{ Carbon\Carbon::parse($specialDay->special_day_at)->format('F jS') }}
</p>
@endif

@if($specialDay->special_day === 'anniversary')
<img src="{{url('/icons/university-solid.png')}}" style="height: 17px; width: 17px">

<p style="font-size: 0.875rem; line-height: 1.25rem; color: rgb(107 114 128); margin-left: 2px; margin-top: 0px">
{{ Carbon\Carbon::parse($specialDay->special_day_at)->format('F jS') }}
({{ \Carbon\Carbon::parse($specialDay->special_day_at)->diffInYears() + 1 }} Years)
</p>
@endif
</div>
</td>
</tr>
</table>
</td>
</tr>
</table>
@endforeach
</div>

@component('mail::button', ['url' => $buttonUrl])
{{ $buttonText }}
@endcomponent

<div style="padding: 20px 0px;">
{{ __("Thank you for using $appName!") }}
</div>

<div>
Thanks,<br>
{{ config('app.name') }}
</div>
@endcomponent
