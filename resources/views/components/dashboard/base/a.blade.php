@props(['heading','footer'])
<a {{ $attributes->class([])->merge(['href' => '#']) }}>
    {{ $slot }}
</a>