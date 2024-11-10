<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Update Password') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <div>
            <x-input-label for="current_password" :value="__('Current Password')" />
            <x-text-input id="current_password" name="current_password" type="password" class="mt-1 block w-full" autocomplete="current-password" />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password" :value="__('New Password')" />
            <x-text-input id="password" name="password" type="password" class="mt-1 block w-full" autocomplete="new-password" oninput="validatePassword()" />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
            <!-- Password validation feedback -->
            <div id="password-requirements" class="mt-2 text-sm">
                <p id="length" class="text-gray-600">At least 12 characters</p>
                <p id="uppercase" class="text-gray-600">At least one uppercase letter</p>
                <p id="lowercase" class="text-gray-600">At least one lowercase letter</p>
                <p id="number" class="text-gray-600">At least one number</p>
                <p id="special" class="text-gray-600">At least one special character</p>
            </div>
        </div>

        <div>
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
            <x-text-input id="password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>

    <script>
        function validatePassword() {
            const password = document.getElementById('password').value;
            const requirements = {
                length: password.length >= 12,
                uppercase: /[A-Z]/.test(password),
                lowercase: /[a-z]/.test(password), 
                number: /[0-9]/.test(password),
                special: /[!@#$%^&*(),.?":{}|<>]/.test(password)
            };

            document.getElementById('length').style.color = requirements.length ? 'green' : 'gray';
            document.getElementById('uppercase').style.color = requirements.uppercase ? 'green' : 'gray';
            document.getElementById('lowercase').style.color = requirements.lowercase ? 'green' : 'gray';
            document.getElementById('number').style.color = requirements.number ? 'green' : 'gray';
            document.getElementById('special').style.color = requirements.special ? 'green' : 'gray';
        }
    </script>
</section>
