<x-guest-layout>
    <x-auth-card>
        <!-- Intro text -->
        <h2 class = "welcometext"> Welcome </h2><br>
        <h3 class = "welcometext"> Before you can use the Gatofeeder you need to login or sign up </h3><br>
        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email Address -->
            <div class="mt-4">
                <x-label for="email"/>

                <x-input id="email" class="inputtext" placeholder="Email address" type="email" name="email" :value="old('email')"  required autofocus />
            </div><br>

            <!-- Password -->
            <div class="mt-4">
                <x-label for="password"/>

                <x-input id="password" class="inputtext" placeholder="Password"
                                type="password"
                                name="password"
                                required autocomplete="current-password" />
            </div>

            <!-- Remember Me -->
            <div class="block mt-4">
                <label for="remember_me" class="rememberme">
                    <br>
                    <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" name="remember">
                    <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                </label>
            </div>
            <br>
                <x-button class="ml-3">
                    {{ __('Log in') }}
                </x-button><br>

                <br><br><h3> to finish the setup of the Gatofeeder: <h3> <br>
                <a class="signuplink" href="{{ route('register') }}">
                    {{ __('Sign up') }}
                </a>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>
