<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </x-slot>

        <x-auth-session-status class="mb-4" :status="session('changed_password')" />


        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />
        

        <form method="POST" action="{{ route('admin.change.password') }}">
            @csrf

            <!-- New Password -->
            <div class="mt-4">
                <x-label for="password" :value="__('New Password')" />

                <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="password" />
            </div>

            <!-- Confirm New Password -->
            <div class="mt-4">
                <x-label for="password_confirmation" :value="__('Confirm Password')" />

                <x-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required />
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-button class="ml-4">
                    {{ __('Save') }}
                </x-button>
            </div>
            
        </form>
         <form action="{{ route('admin.dashboard')}}" method="get">
                {{-- <div class="flex items-center justify-end mt-4"> --}}
                <x-button>
                    {{ __('Dashboard') }}
                </x-button>
            {{-- </div> --}}
            </form>
    </x-auth-card>
</x-guest-layout>