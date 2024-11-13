<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        {{ __('Please enter the verification code we sent to your email.') }}
    </div>

    <form method="POST" action="{{ route('verify.2fa') }}">
        @csrf
        <input type="hidden" name="email" value="{{ session('email') }}">

        <div>
            <x-input-label for="two_factor_token" value="Verification Code" />
            <x-text-input id="two_factor_token" 
                         type="text" 
                         name="two_factor_token" 
                         required 
                         autofocus />
            <x-input-error :messages="$errors->get('two_factor_token')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button>
                {{ __('Verify') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>