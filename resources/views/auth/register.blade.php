@extends('layouts.front')

@section('title', 'Register')

@section('content')

    <div class="min-h-[70vh] flex items-center justify-center">
        <div class="w-full max-w-lg">

            {{-- Card --}}
            <div class="bg-white border border-slate-200 shadow-sm rounded-2xl overflow-hidden">

                {{-- Header --}}
                <div class="px-6 py-5 border-b border-slate-100">
                    <h1 class="text-xl font-bold text-slate-900">Create your account</h1>
                    <p class="text-sm text-slate-500 mt-1">
                        Join to comment and interact with articles.
                    </p>
                </div>

                {{-- Form --}}
                <div class="px-6 py-6">
                    <form method="POST" action="{{ route('register') }}" class="space-y-5">
                        @csrf

                        {{-- Name --}}
                        <div class="space-y-1">
                            <label for="name" class="block text-sm font-medium text-slate-700">
                                Name <span class="text-rose-500">*</span>
                            </label>
                            <input id="name" type="text" name="name" value="{{ old('name') }}" required
                                autofocus autocomplete="name" placeholder="Your full name"
                                class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm shadow-sm
                                   focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500">
                            @error('name')
                                <p class="text-xs text-rose-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Email --}}
                        <div class="space-y-1">
                            <label for="email" class="block text-sm font-medium text-slate-700">
                                Email <span class="text-rose-500">*</span>
                            </label>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required
                                autocomplete="username" placeholder="you@example.com"
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
                            <input id="password" type="password" name="password" required autocomplete="new-password"
                                placeholder="••••••••"
                                class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm shadow-sm
                                   focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500">
                            @error('password')
                                <p class="text-xs text-rose-600">{{ $message }}</p>
                            @enderror
                            <p class="text-xs text-slate-500">
                                Use at least 8 characters.
                            </p>
                        </div>

                        {{-- Confirm Password --}}
                        <div class="space-y-1">
                            <label for="password_confirmation" class="block text-sm font-medium text-slate-700">
                                Confirm Password <span class="text-rose-500">*</span>
                            </label>
                            <input id="password_confirmation" type="password" name="password_confirmation" required
                                autocomplete="new-password" placeholder="••••••••"
                                class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm shadow-sm
                                   focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500">
                            @error('password_confirmation')
                                <p class="text-xs text-rose-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Actions --}}
                        <div class="pt-2 flex items-center justify-between">
                            <a href="{{ route('login') }}"
                                class="text-sm font-medium text-slate-600 hover:text-slate-900 hover:underline">
                                Already registered?
                            </a>

                            <button type="submit"
                                class="inline-flex items-center justify-center rounded-lg bg-emerald-600 px-5 py-2.5
                                   text-sm font-semibold text-white shadow-sm hover:bg-emerald-700
                                   focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2">
                                Register
                            </button>
                        </div>

                    </form>
                </div>

            </div>

            {{-- Small note --}}
            <p class="text-center text-xs text-slate-500 mt-4">
                By registering, you agree to our basic usage policy.
            </p>
        </div>
    </div>

@endsection
