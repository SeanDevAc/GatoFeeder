<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </x-slot>

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <h2 class = "welcometext"> Welcome </h2><br><br><br>

            <!-- Name -->
            <div class="mt-4">
                <x-input id="name" class="inputtext" placeholder="Name" type="text" name="name" :value="old('name')" required autofocus />
            </div><br><br>

            <!-- Email Address -->
            <div class="mt-4">
                <x-input id="email" class="inputtext" placeholder="Email address" type="email" name="email" :value="old('email')" required />
            </div><br><br>

            <!-- Password -->
            <div class="mt-4">
                <x-input id="password" class="inputtext" placeholder="Password"
                                type="password"
                                name="password"
                                required autocomplete="new-password" />
            </div><br><br>

            <!-- Confirm Password -->
            <div class="mt-4">
                <x-input id="password_confirmation" class="inputtext" placeholder="Password Confirmation"
                                type="password"
                                name="password_confirmation" required />
            </div><br><br>

            <div class="flex items-center justify-end mt-4">
                <x-button class="ml-4">
                    {{ __('Register') }}
                </x-button><br>

                <a class="secondoption" href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>
