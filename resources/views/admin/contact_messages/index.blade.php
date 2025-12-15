@extends('admin.layout')

@section('title', 'Contact Messages')
@section('subtitle', 'Messages submitted from the public contact form')

@section('content')

    {{-- Summary cards --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">

        {{-- Total messages --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-4 flex items-center gap-3">
            <div class="h-9 w-9 rounded-full bg-sky-100 text-sky-700 flex items-center justify-center">
                <span class="material-symbols-outlined text-base">mail</span>
            </div>
            <div>
                <p class="text-xs font-medium text-slate-500 uppercase tracking-wide">Total messages</p>
                <p class="text-xl font-semibold text-slate-900">{{ $totalCount ?? $messages->total() }}</p>
            </div>
        </div>

        {{-- Unread messages --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-4 flex items-center gap-3">
            <div class="h-9 w-9 rounded-full bg-rose-100 text-rose-700 flex items-center justify-center">
                <span class="material-symbols-outlined text-base">mark_email_unread</span>
            </div>
            <div>
                <p class="text-xs font-medium text-slate-500 uppercase tracking-wide">Unread</p>
                <p class="text-xl font-semibold text-rose-600">{{ $unreadCount ?? 0 }}</p>
            </div>
        </div>

        {{-- Latest received --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-4 flex items-center gap-3">
            <div class="h-9 w-9 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center">
                <span class="material-symbols-outlined text-base">schedule</span>
            </div>
            <div>
                <p class="text-xs font-medium text-slate-500 uppercase tracking-wide">Latest message</p>
                <p class="text-sm font-semibold text-slate-900">
                    {{ optional($messages->first())->created_at?->format('M d, Y H:i') ?? '—' }}
                </p>
            </div>
        </div>
    </div>

    {{-- Filter form --}}
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-4 mb-6">
        <form method="GET" action="{{ route('admin.contact-messages.index') }}"
            class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">

            {{-- Search --}}
            <div class="md:col-span-2">
                <label class="block text-xs font-semibold text-slate-600 mb-1">Search</label>
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Search by name, email, or message text…"
                    class="w-full px-3 py-2 text-sm border border-slate-300 rounded-lg
                              focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
            </div>

            {{-- Status --}}
            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1">Status</label>
                <select name="status"
                    class="w-full px-3 py-2 text-sm border border-slate-300 rounded-lg
                               focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                    <option value="">All</option>
                    <option value="unread" @selected(request('status') === 'unread')>Unread only</option>
                    <option value="read" @selected(request('status') === 'read')>Read only</option>
                </select>
            </div>

            {{-- Buttons --}}
            <div class="flex gap-2">
                <button type="submit"
                    class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium rounded-lg
                               bg-emerald-600 text-white hover:bg-emerald-700 flex-1">
                    Apply filters
                </button>

                @if (request()->hasAny(['search', 'status']))
                    <a href="{{ route('admin.contact-messages.index') }}"
                        class="inline-flex items-center justify-center px-3 py-2 text-xs font-medium rounded-lg
                              border border-slate-200 text-slate-600 hover:bg-slate-50">
                        Reset
                    </a>
                @endif
            </div>

        </form>
    </div>

    {{-- Messages table --}}
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">

        <div class="px-4 py-3 border-b border-slate-100 flex items-center justify-between">
            <h2 class="text-sm font-semibold text-slate-800">Contact messages</h2>
            <span class="text-xs text-slate-500">
                Showing {{ $messages->firstItem() ?? 0 }}–{{ $messages->lastItem() ?? 0 }} of {{ $messages->total() }}
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-slate-50 border-b border-slate-100">
                    <tr>
                        <th class="px-4 py-2 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">From
                        </th>
                        <th class="px-4 py-2 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">Email
                        </th>
                        <th class="px-4 py-2 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">Message
                        </th>
                        <th class="px-4 py-2 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">
                            Received at</th>
                        <th class="px-4 py-2 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">Status
                        </th>
                        <th class="px-4 py-2 text-right text-xs font-semibold text-slate-500 uppercase tracking-wide">
                            Actions</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100">
                    @forelse ($messages as $message)
                        @php
                            $isRead = (bool) ($message->is_read ?? $message->read_at);
                        @endphp

                        <tr class="hover:bg-slate-50/60 transition {{ !$isRead ? 'bg-rose-50/20' : '' }}">

                            {{-- From --}}
                            <td class="px-4 py-2 align-top">
                                <span class="font-semibold text-slate-800">{{ $message->name }}</span>
                            </td>

                            {{-- Email --}}
                            <td class="px-4 py-2 align-top">
                                <a href="mailto:{{ $message->email }}" class="text-xs text-sky-600 hover:underline">
                                    {{ $message->email }}
                                </a>
                            </td>

                            {{-- Short message --}}
                            <td class="px-4 py-2 align-top max-w-md">
                                <p class="text-xs text-slate-600 line-clamp-2">
                                    {{ Str::limit($message->message, 120) }}
                                </p>
                            </td>

                            {{-- Date --}}
                            <td class="px-4 py-2 align-top text-xs text-slate-500">
                                <div>{{ $message->created_at->format('Y-m-d') }}</div>
                                <div class="text-[11px] text-slate-400">{{ $message->created_at->format('H:i') }}</div>
                            </td>

                            {{-- Status --}}
                            <td class="px-4 py-2 align-top">
                                @if (!$isRead)
                                    <span
                                        class="inline-flex items-center rounded-full bg-rose-50 px-2.5 py-0.5 text-[11px] font-medium text-rose-700">
                                        ● Unread
                                    </span>
                                @else
                                    <span
                                        class="inline-flex items-center rounded-full bg-slate-100 px-2.5 py-0.5 text-[11px] font-medium text-slate-700">
                                        ● Read
                                    </span>
                                @endif
                            </td>

                            {{-- Actions --}}
                            <td class="px-4 py-3 align-top text-right">
                                <div class="inline-flex items-center gap-2">

                                    {{-- ✅ View Modal (Alpine.js) --}}
                                    <div x-data="{ open: false }" class="inline-block">

                                        <button type="button" @click="open = true"
                                            class="inline-flex items-center justify-center px-3 py-1.5 text-xs font-semibold rounded-lg
                                               border border-slate-200 bg-white text-slate-700 hover:bg-slate-50
                                               focus:outline-none focus:ring-2 focus:ring-emerald-500">
                                            View
                                        </button>

                                        {{-- Modal Overlay --}}
                                        <div x-show="open" x-transition.opacity
                                            class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/40"
                                            @click.self="open = false" @keydown.escape.window="open = false"
                                            style="display:none;">

                                            {{-- Modal --}}
                                            <div x-show="open" x-transition
                                                class="w-full max-w-2xl bg-white rounded-2xl shadow-2xl border border-slate-200 overflow-hidden">

                                                {{-- Header --}}
                                                <div
                                                    class="px-5 py-4 border-b border-slate-100 flex items-start justify-between gap-4">
                                                    <div class="min-w-0">
                                                        <h3 class="text-sm font-bold text-slate-900">Contact Message</h3>
                                                        <p class="text-xs text-slate-500 mt-1">
                                                            From
                                                            <span
                                                                class="font-semibold text-slate-700">{{ $message->name }}</span>
                                                            •
                                                            <a class="text-sky-600 hover:underline"
                                                                href="mailto:{{ $message->email }}">{{ $message->email }}</a>
                                                        </p>
                                                    </div>

                                                    <button type="button" @click="open = false"
                                                        class="shrink-0 inline-flex items-center justify-center h-9 w-9 rounded-lg
                                                           border border-slate-200 text-slate-600 hover:bg-slate-50">
                                                        ✕
                                                    </button>
                                                </div>

                                                {{-- Body --}}
                                                <div class="px-5 py-4">
                                                    <div class="flex items-center justify-between mb-3">
                                                        <span class="text-xs text-slate-500">
                                                            Received: {{ $message->created_at->format('Y-m-d H:i') }}
                                                        </span>

                                                        @if (!$isRead)
                                                            <span
                                                                class="inline-flex items-center rounded-full bg-rose-50 px-2.5 py-0.5 text-[11px] font-semibold text-rose-700">
                                                                ● Unread
                                                            </span>
                                                        @else
                                                            <span
                                                                class="inline-flex items-center rounded-full bg-slate-100 px-2.5 py-0.5 text-[11px] font-semibold text-slate-700">
                                                                ● Read
                                                            </span>
                                                        @endif
                                                    </div>

                                                    <div
                                                        class="rounded-xl border border-slate-200 bg-slate-50 p-4 text-sm text-slate-800 whitespace-pre-line">
                                                        {{ $message->message }}
                                                    </div>
                                                </div>

                                                {{-- Footer --}}
                                                <div
                                                    class="px-5 py-4 border-t border-slate-100 flex items-center justify-end gap-2">
                                                    <button type="button" @click="open = false"
                                                        class="inline-flex items-center justify-center px-4 py-2 text-xs font-semibold rounded-lg
                                                           border border-slate-200 bg-white text-slate-700 hover:bg-slate-50">
                                                        Close
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Mark as Read / Unread --}}
                                    @if (!$isRead)
                                        <form method="POST"
                                            action="{{ route('admin.contact-messages.read', $message) }}">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit"
                                                class="inline-flex items-center justify-center px-3 py-1.5 text-xs font-semibold rounded-lg
                                                       bg-emerald-600 text-white hover:bg-emerald-700
                                                       focus:outline-none focus:ring-2 focus:ring-emerald-500">
                                                Mark Read
                                            </button>
                                        </form>
                                    @else
                                        <form method="POST"
                                            action="{{ route('admin.contact-messages.unread', $message) }}">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit"
                                                class="inline-flex items-center justify-center px-3 py-1.5 text-xs font-semibold rounded-lg
                                                       border border-slate-200 bg-white text-slate-700 hover:bg-slate-50
                                                       focus:outline-none focus:ring-2 focus:ring-slate-400">
                                                Mark Unread
                                            </button>
                                        </form>
                                    @endif

                                </div>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-6 text-center text-sm text-slate-500">
                                No contact messages found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </div>

        @if ($messages->hasPages())
            <div class="border-t border-slate-100 px-4 py-3">
                {{ $messages->links() }}
            </div>
        @endif
    </div>

@endsection
