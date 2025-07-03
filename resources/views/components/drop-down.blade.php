@props(['disabled' => false])
<select {{ $attributes }} >
    <option value="{{ __('Company Admin') }}">{{ __('Company Admin') }}</option>
    <option value="{{ __('Super User') }}">{{ __('Super User') }}</option>
</select>