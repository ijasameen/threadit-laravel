@props(['value'])

<textarea {{ $attributes->merge(['class' => 'textarea']) }}>{{ $value }}</textarea>
