

@php
$classes = 'text-sm text-blue-500 hover:underline';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>