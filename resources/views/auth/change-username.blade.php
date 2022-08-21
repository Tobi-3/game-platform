<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <img src="{{ asset('/storage/logos') }}/logo_small.png" class="w-20 h-20 fill-current text-gray-500">
            </a>
        </x-slot>

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('change.username') }}">
            @csrf

            <!-- New Username -->
            <div class="mt-4">
                <x-label for="new_username" :value="__('New Username')" />

                <x-input id="new_username" class="block mt-1 w-full" type="text" name="new_username" required autocomplete="new_username" />
            </div>

            <!-- Confirm New Username -->
            <div class="mt-4">
                <x-label for="username_confirmation" :value="__('Confirm Username')" />

                <x-input id="new_username_confirmation" class="block mt-1 w-full" type="text" name="new_username_confirmation" required />
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-button class="ml-4">
                    {{ __('Save') }}
                </x-button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>