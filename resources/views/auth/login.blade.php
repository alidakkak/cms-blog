@extends('layouts.front')

@section('title', 'Login')

@section('content')

    <div class="min-h-[70vh] flex items-center justify-center">
        <div class="w-full max-w-lg">

            <div class="bg-white border border-slate-200 shadow-sm rounded-2xl overflow-hidden">

                {{-- Header --}}
                <div class="px-6 py-5 border-b border-slate-100">
                    <h1 class="text-xl font-bold text-slate-900">Welcome back</h1>
                    <p class="text-sm text-slate-500 mt-1">
                        Login to comment and manage your account.
                    </p>
                </div>

                <div class="px-6 py-6">

                    {{-- Session Status --}}
                    @if (session('status'))
                        <div
                            class="mb-4 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-2 text-sm text-emerald-800">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}" class="space-y-5">
                        @csrf

                        {{-- Email --}}
                        <div class="space-y-1">
                            <label for="email" class="block text-sm font-medium text-slate-700">
                                Email <span class="text-rose-500">*</span>
                            </label>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required
                                autofocus autocomplete="username" placeholder="you@example.com"
                                class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm shadow-sm
                                   focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500">
                            @error('email')
                                <p class="text-xs text-rose-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Password --}}
                        <div class="space-y-1">
                            <label for="password" class="block text-sm font-medium text-slate-700">
                                Password <span class="text-rose-500">*</span>
                            </label>
                            <input id="password" type="password" name="password" required autocomplete="current-password"
                                placeholder="••••••••"
                                class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm shadow-sm
                                   focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500">
                            @error('password')
                                <p class="text-xs text-rose-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Remember + Forgot --}}
                        <div class="flex items-center justify-between">
                            <label class="inline-flex items-center gap-2 text-sm text-slate-600 select-none">
                                <input id="remember_me" type="checkbox" name="remember"
                                    class="rounded border-slate-300 text-emerald-600 focus:ring-emerald-500">
                                Remember me
                            </label>

                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}"
                                    class="text-sm font-medium text-slate-600 hover:text-slate-900 hover:underline">
                                    Forgot password?
                                </a>
                            @endif
                        </div>

                        {{-- Submit --}}
                        <button type="submit"
                            class="w-full inline-flex items-center justify-center rounded-lg bg-emerald-600 px-4 py-2.5
                               text-sm font-semibold text-white shadow-sm hover:bg-emerald-700
                               focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2">
                            Log in
                        </button>

                        {{-- Register link --}}
                        <p class="text-center text-sm text-slate-600">
                            Don’t have an account?
                            <a href="{{ route('register') }}" class="font-semibold text-emerald-700 hover:underline">
                                Register
                            </a>
                        </p>

                    </form>
                </div>
            </div>

            <p class="text-center text-xs text-slate-500 mt-4">
                Secure login powered by Laravel Auth.
            </p>

        </div>
    </div>

@endsection
