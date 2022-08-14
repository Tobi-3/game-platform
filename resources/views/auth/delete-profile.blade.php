<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </x-slot>

        <div class="mb-4 text-sm text-gray-600">
            {{ __('By pressing on DELETE your profile and all related data will be deleted forever.') }}
        </div>

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <div class="flex justify-around mt-4">
            <form method="POST" action="{{ route('delete.profile') }}">
                @csrf

                <x-button>
                    {{ __('Delete') }}
                </x-button>
            </form>
            <form method="GET" action="{{ route('user.profile') }}">
                @csrf

                <x-button oncl>
                    {{ __('Go back') }}
                </x-button>
            </form>
        </div>
    </x-auth-card>
</x-guest-layout>
