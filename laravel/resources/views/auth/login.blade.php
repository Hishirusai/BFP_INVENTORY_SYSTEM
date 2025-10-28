<x-guest-layout>

    <!-- Combined panel with logos, title, and form -->
    <div class="w-full sm:max-w-sm bg-black/60 rounded shadow-2xl p-6">
        <div class="flex flex-col items-center">
            <div class="flex items-center gap-8 mb-4">
                <img src="/Img/LOGO.png" alt="Logo 1" class="h-32 w-32 object-contain">
                <img src="/Img/LOGO2.png" alt="Logo 2" class="h-32 w-32 object-contain">
            </div>
            <h1 class="text-3xl font-bold text-white mb-5">ADMIN LOGIN</h1>
        </div>

        <p class="text-sm text-gray-200 text-center mb-6">Enter your email and password to access the dashboard.</p>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email -->
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-200 mb-1">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email', 'admin@example.com') }}"
                    required autofocus autocomplete="username"
                    class="block w-full rounded-md bg-white border border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 py-2 px-3 text-sm" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="mb-5">
                <label for="password" class="block text-sm font-medium text-gray-200 mb-1">Password</label>
                <input id="password" type="password" name="password" value="password" required autocomplete="current-password"
                    class="block w-full rounded-md bg-white border border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 py-2 px-3 text-sm" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Login Button -->
            <button type="submit"
                class="w-full bg-gray-700 hover:bg-gray-800 text-white font-medium py-2 rounded transition-colors">
                Login
            </button>
        </form>
    </div>
</x-guest-layout>