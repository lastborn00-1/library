<x-guest-layout>
    <!-- Back to Home -->
    <div class="mb-6 flex justify-start">
        <a href="{{ url('/') }}" class="inline-flex items-center gap-2 px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold rounded-lg transition">
            <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Back to Home
        </a>
    </div>

    <!-- Header -->
    <div class="text-center mb-8">
        <h2 class="text-2xl font-bold text-slate-900">Welcome to KWCHT E-Library</h2>
        <p class="text-sm text-slate-500 mt-1">Login to access OPAC, resources, and explore the repository.</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <!-- Email / Matric Number -->
        <div>
            <label for="login" class="block text-sm font-semibold text-slate-700 mb-1">{{ __('Email or Matric Number') }}</label>
            <input id="login" type="text" name="login" value="{{ old('login') }}" required autofocus autocomplete="username"
                   class="block w-full px-4 py-2.5 rounded-lg border border-slate-300 bg-white text-slate-900 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition shadow-sm sm:text-sm"
                   placeholder="e.g. KWCHT/2024/001 or staff@example.com">
            <p class="text-xs text-slate-500 mt-1.5">Students use Matric No. &nbsp;|&nbsp; Staff use Email</p>
            <x-input-error :messages="$errors->get('login')" class="mt-2 text-rose-500 text-xs" />
        </div>

        <!-- Password -->
        <div x-data="{ show: false }">
            <label for="password" class="block text-sm font-semibold text-slate-700 mb-1">{{ __('Password') }}</label>
            <div class="relative">
                <input id="password" :type="show ? 'text' : 'password'" name="password" required autocomplete="current-password"
                       class="block w-full px-4 py-2.5 rounded-lg border border-slate-300 bg-white text-slate-900 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition shadow-sm sm:text-sm pr-10"
                       placeholder="••••••••">
                <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 flex items-center pr-3 text-slate-400 hover:text-slate-600 transition">
                    <!-- Eye icon (show password) -->
                    <svg x-show="!show" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                    <!-- Eye off icon (hide password) -->
                    <svg x-show="show" style="display: none;" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path></svg>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-rose-500 text-xs" />
        </div>

        <!-- Remember Me & Forgot Password -->
        <div class="flex items-center justify-between">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-slate-300 text-indigo-600 shadow-sm focus:ring-indigo-500 cursor-pointer" name="remember">
                <span class="ms-2 text-sm text-slate-600">{{ __('Remember me') }}</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-sm font-medium text-indigo-600 hover:text-indigo-500" href="{{ route('password.request') }}">
                    {{ __('Forgot password?') }}
                </a>
            @endif
        </div>

        <div class="pt-2">
            <button type="submit" class="w-full flex justify-center py-2.5 px-4 border border-transparent rounded-lg shadow-sm text-sm font-bold text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition">
                {{ __('Log in') }}
            </button>
        </div>

        <!-- Divider -->
        <div class="relative my-2">
            <div class="absolute inset-0 flex items-center"><div class="w-full border-t border-slate-200"></div></div>
            <div class="relative flex justify-center text-xs"><span class="px-3 bg-white text-slate-400">New student?</span></div>
        </div>

        <!-- Create Account / Closed notice -->
        @php
            $regEnabled = \App\Models\Setting::where('key', 'student_registration_enabled')->value('value') !== '0';
        @endphp
        @if($regEnabled)
            <a href="{{ route('student.register') }}"
               class="w-full flex justify-center py-2.5 px-4 border-2 border-indigo-200 rounded-lg text-sm font-bold text-indigo-600 hover:bg-indigo-50 hover:border-indigo-400 transition">
                Create a Library Account
            </a>
        @else
            <div class="p-3 bg-slate-50 border border-slate-200 rounded-lg text-center text-xs text-slate-500 font-medium">
                Student online self-registration is currently closed.
            </div>
        @endif
    </form>
</x-guest-layout>
