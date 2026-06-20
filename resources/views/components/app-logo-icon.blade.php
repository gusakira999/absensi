@props(['class' => ''])

<svg {{ $attributes->merge(['class' => $class, 'viewBox' => '0 0 24 24', 'fill' => 'none', 'xmlns' => 'http://www.w3.org/2000/svg']) }}>
    <path d="M6 3h9a3 3 0 0 1 3 3v12a3 3 0 0 1-3 3H6a3 3 0 0 1-3-3V6a3 3 0 0 1 3-3Z" fill="currentColor" opacity="0.12"/>
    <path d="M8 7h8M8 11h8M8 15h5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
    <path d="M10 3.75v16.5" stroke="currentColor" stroke-width="1.2" stroke-linecap="round" opacity="0.45"/>
</svg>