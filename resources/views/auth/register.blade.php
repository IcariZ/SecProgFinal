<x-guest-layout>

    <form method="POST" action="{{ route('register') }}">

        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required
                autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                autocomplete="new-password" oninput="validatePassword()" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />

            <!-- Password validation feedback -->
            <div id="password-requirements" class="mt-2 text-sm">
                <p id="length" class="text-gray-600">At least 12 characters</p>
                <p id="uppercase" class="text-gray-600">At least one uppercase letter</p>
                <p id="lowercase" class="text-gray-600">At least one lowercase letter</p>
                <p id="number" class="text-gray-600">At least one number</p>
                <p id="special" class="text-gray-600">At least one special character</p>
            </div>
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password"
                name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ml-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>

    <x-social-links />

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
</x-guest-layout>
