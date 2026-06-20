@props(['title', 'description'])

<div {{ $attributes->merge(['class' => 'space-y-2 text-center']) }}>
    <h1 class="text-2xl font-semibold tracking-tight text-zinc-950 dark:text-white">
        {{ $title }}
    </h1>

    @if ($description)
        <p class="text-sm leading-6 text-zinc-600 dark:text-zinc-400">
            {{ $description }}
        </p>
    @endif
</div>