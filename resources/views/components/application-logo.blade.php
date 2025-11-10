@props(['size' => 'default'])

@php
    $sizeClass = match($size) {
        'large' => 'w-20 h-20',
        'small' => 'w-8 h-8',
        default => 'w-12 h-12',
    };
@endphp

<div {{ $attributes->merge(['class' => 'flex flex-col items-center']) }}>
    <img src="{{ asset('images/catatan-keuanganku-logo.png') }}" 
         alt="Catatan Keuanganku Logo"
         {{ $attributes->merge(['class' => "$sizeClass rounded-full shadow-lg hover:scale-105 transition-transform duration-300"]) }}>
</div>
