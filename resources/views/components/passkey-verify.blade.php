@once
    @vite('resources/js/passkeys.js')
@endonce

<div
    x-data
    x-init="window.Passkeys?.autofill().catch(() => {})"
    class="sr-only"
    aria-hidden="true"
>
    <input type="text" autocomplete="username webauthn" tabindex="-1" aria-hidden="true">
</div>