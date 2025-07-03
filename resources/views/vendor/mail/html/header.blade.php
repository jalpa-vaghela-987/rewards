<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (true || trim($slot) === 'Laravel')
<img src="{{ $appLogo ?? appLogo() }}" class="logo"
     alt="{{ $appName ?? appName() }} Logo">
@else
{{-- $slot --}}
@endif
</a>
</td>
</tr>
