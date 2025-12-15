<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Admin Panel')</title>

    {{-- Vite assets --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Material Icons --}}
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght@400;500;600&display=swap" />

    <style>
        :root {
            --sidebar-width: 260px;
        }

        #admin-sidebar {
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            width: var(--sidebar-width);
            background: #ffffff;
            border-right: 1px solid #e5e7eb;
            z-index: 50;
        }

        .admin-main {
            margin-left: var(--sidebar-width);
        }
    </style>
    <script src="//unpkg.com/alpinejs" defer></script>

</head>

<body class="bg-slate-100 min-h-screen antialiased">

    <aside id="admin-sidebar" class="text-slate-800 flex flex-col shadow-sm">

        {{-- Header --}}
        <div class="h-16 px-4 flex items-center gap-2 border-b border-slate-200">
            <span class="material-symbols-outlined text-emerald-600">apps</span>
            <span class="text-lg font-semibold tracking-wide">CMS Admin</span>
        </div>

        {{-- Navigation --}}
        <nav class="flex-1 px-3 py-4 overflow-y-auto text-sm space-y-1">

            @php
                $role = auth()->user()->role ?? 'user';
                $isAdmin = $role === 'admin';
                $isEditor = $role === 'editor';
            @endphp

            <p class="px-3 mb-1 text-[11px] uppercase tracking-wide text-slate-400">
                CONTENT
            </p>

            {{-- Dashboard: admin فقط --}}
            @if ($isAdmin)
                <a href="{{ route('admin.dashboard') }}"
                    class="flex items-center gap-2 px-3 py-2 rounded-xl
                  hover:bg-slate-100 hover:text-slate-900
                  {{ request()->routeIs('admin.dashboard') ? 'bg-emerald-600 text-white shadow-inner' : 'text-slate-600' }}">
                    <span class="material-symbols-outlined text-base">dashboard</span>
                    <span>Dashboard</span>
                </a>
            @endif

            {{-- Articles: admin + editor --}}
            @if ($isAdmin || $isEditor)
                <a href="{{ route('admin.articles.index') }}"
                    class="flex items-center gap-2 px-3 py-2 rounded-xl
                  hover:bg-slate-100 hover:text-slate-900
                  {{ request()->routeIs('admin.articles.*') ? 'bg-emerald-600 text-white shadow-inner' : 'text-slate-600' }}">
                    <span class="material-symbols-outlined text-base">article</span>
                    <span>Articles</span>
                </a>
            @endif

            {{-- Categories: admin فقط --}}
            @if ($isAdmin)
                <a href="{{ route('admin.categories.index') }}"
                    class="flex items-center gap-2 px-3 py-2 rounded-xl
                  hover:bg-slate-100 hover:text-slate-900
                  {{ request()->routeIs('admin.categories.*') ? 'bg-emerald-600 text-white shadow-inner' : 'text-slate-600' }}">
                    <span class="material-symbols-outlined text-base">category</span>
                    <span>Categories</span>
                </a>
            @endif

            {{-- COMMUNITY (admin فقط) --}}
            @if ($isAdmin)
                <p class="px-3 mt-4 mb-1 text-[11px] uppercase tracking-wide text-slate-400">
                    COMMUNITY
                </p>

                <a href="{{ route('admin.comments.index') }}"
                    class="flex items-center gap-2 px-3 py-2 rounded-xl
                  hover:bg-slate-100 hover:text-slate-900
                  {{ request()->routeIs('admin.comments.*') ? 'bg-emerald-600 text-white shadow-inner' : 'text-slate-600' }}">
                    <span class="material-symbols-outlined text-base">chat</span>
                    <span>Comments</span>
                </a>

                <a href="{{ route('admin.contact-messages.index') }}"
                    class="flex items-center gap-2 px-3 py-2 rounded-xl
                  hover:bg-slate-100 hover:text-slate-900
                  {{ request()->routeIs('admin.contact-messages.*') ? 'bg-emerald-600 text-white shadow-inner' : 'text-slate-600' }}">
                    <span class="material-symbols-outlined text-base">mail</span>
                    <span>Contact Messages</span>
                </a>
            @endif

        </nav>


        {{-- User Info --}}
        <div class="h-18 border-t border-slate-200 px-4 py-3 flex items-center justify-between bg-slate-50 text-xs">
            <div class="flex items-center gap-2">
                <div
                    class="h-8 w-8 rounded-full bg-emerald-600 flex items-center justify-center text-[11px] font-bold text-white">
                    {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                </div>
                <div class="flex flex-col">
                    <span class="font-semibold text-xs">
                        {{ auth()->user()->name ?? 'Admin' }}
                    </span>
                    <span class="text-[11px] text-slate-500">
                        {{ auth()->user()->role ?? 'admin' }}
                    </span>
                </div>
            </div>

            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit"
                    class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-medium
                               bg-rose-600 text-white hover:bg-rose-700">
                    Logout
                </button>
            </form>
        </div>
    </aside>

    {{-- Main Content --}}
    <div class="admin-main min-h-screen flex flex-col">

        {{-- Top bar --}}
        <header
            class="h-16 bg-white border-b border-slate-200 flex items-center justify-between px-6 sticky top-0 z-20">
            <div>
                <h1 class="text-lg font-semibold text-slate-800">@yield('title')</h1>
                <p class="text-xs text-slate-500">@yield('subtitle')</p>
            </div>

            <a href="{{ url('/') }}"
                class="inline-flex items-center text-xs font-medium text-slate-600 hover:text-slate-900 hover:underline">
                <span class="material-symbols-outlined text-base mr-1">home</span>
                Visit Site
            </a>
        </header>

        {{-- Page Content --}}
        <main class="flex-1 p-6">
            <div class="max-w-6xl mx-auto">
                @yield('content')
            </div>
        </main>

    </div>

    {{-- TinyMCE --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.8.3/tinymce.min.js"></script>

    @stack('scripts')

</body>

</html>
