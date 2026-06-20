@once
    @vite('resources/js/passkeys.js')
@endonce

<div class="mt-4">
    <flux:button
        type="button"
        variant="outline"
        class="w-full"
        x-data
        x-on:click="
            const passkeyName = window.prompt(@js(__('Name this passkey')),
                navigator.userAgentData?.platform ? `${navigator.userAgentData.platform} passkey` : 'This device passkey'
            );

            if (!passkeyName) {
                return;
            }

            window.Passkeys?.register({ name: passkeyName }).catch((error) => {
                window.alert(error?.message ?? @js(__('Unable to register passkey')));
            });
        "
    >
        {{ __('Add passkey') }}
    </flux:button>
</div>