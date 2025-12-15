<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'My Blog')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Google Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet" />

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="bg-slate-50 min-h-screen">

    {{-- Navigation Bar --}}
    <nav class="bg-white shadow-sm border-b border-slate-200">
        <div class="max-w-6xl mx-auto px-4 py-4 flex items-center justify-between">
            @auth
                @if (auth()->user()->role === 'admin')
                    <a href="{{ route('admin.dashboard') }}" class="hover:text-emerald-600">
                        Dashboard
                    </a>
                @elseif (auth()->user()->role === 'editor')
                    <a href="{{ route('admin.articles.index') }}" class="hover:text-emerald-600">
                        Manage Articles
                    </a>
                @endif

                {{-- Logout button for any logged-in user --}}
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit"
                        class="inline-flex items-center rounded-lg bg-slate-900 px-4 py-2 text-xs font-semibold text-white
                       hover:bg-slate-800">
                        Logout
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}"
                    class="inline-flex items-center rounded-lg px-4 py-2 text-xs font-semibold
                              border border-slate-200 text-slate-700 hover:bg-slate-50">
                    Login
                </a>

                <a href="{{ route('register') }}"
                    class="inline-flex items-center rounded-lg bg-emerald-600 px-4 py-2 text-xs font-semibold text-white hover:bg-emerald-700">
                    Register
                </a>
            @endauth

            <div class="hidden md:flex items-center gap-6 text-sm">
                <a href="/" class="hover:text-emerald-600">Home</a>
                <a href="/categories/1" class="hover:text-emerald-600">Categories</a>
                <a href="/contact" class="hover:text-emerald-600">Contact</a>
            </div>
        </div>
    </nav>

    {{-- Page Content --}}
    <main class="max-w-6xl mx-auto px-4 py-10">
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="border-t border-slate-200 mt-10 py-6 text-center text-sm text-slate-500">
        © {{ date('Y') }} MyBlog. All rights reserved.
    </footer>

</body>

</html>
