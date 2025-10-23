@props(['value'])

<textarea {{ $attributes->merge(['class' => 'textarea resize-none field-sizing-content']) }}>{{ $value }}</textarea>
