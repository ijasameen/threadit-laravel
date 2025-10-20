@props(['messages', 'icon_class'])

@php
    $default_class = 'helper-text text-sm text-error flex align-middle gap-1';
    $icon_class = $icon_class ?? 'icon-[tabler--circle-x] size-5';
@endphp

@if ($messages)
    @if (count($messages) > 1)
        <ul>
            @foreach ($messages as $message)
                <li {{ $attributes->merge(['class' => $default_class]) }}>
                    <span class="{{ $icon_class }}"></span>
                    <span>{{ $message }}</span>
                </li>
            @endforeach
        </ul>
    @else
        <span {{ $attributes->merge(['class' => $default_class]) }}>
            <span class="{{ $icon_class }}"></span>
            <span>{{ $messages[0] }}</span>
        </span>
    @endif
@endif
