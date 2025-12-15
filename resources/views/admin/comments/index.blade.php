@extends('admin.layout')

@section('title', 'Comments')
@section('subtitle', 'Approve, or delete article comments')

@section('content')

    {{-- Summary cards --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">

        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-4 flex items-center gap-3">
            <div class="h-9 w-9 rounded-full bg-sky-100 text-sky-700 flex items-center justify-center">
                <span class="material-symbols-outlined text-base">forum</span>
            </div>
            <div>
                <p class="text-xs font-medium text-slate-500 uppercase tracking-wide">Total</p>
                <p class="text-xl font-semibold text-slate-900">{{ $totalCount ?? $comments->total() }}</p>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-4 flex items-center gap-3">
            <div class="h-9 w-9 rounded-full bg-amber-100 text-amber-800 flex items-center justify-center">
                <span class="material-symbols-outlined text-base">hourglass_top</span>
            </div>
            <div>
                <p class="text-xs font-medium text-slate-500 uppercase tracking-wide">Pending</p>
                <p class="text-xl font-semibold text-amber-700">{{ $pendingCount ?? 0 }}</p>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-4 flex items-center gap-3">
            <div class="h-9 w-9 rounded-full bg-emerald-100 text-emerald-800 flex items-center justify-center">
                <span class="material-symbols-outlined text-base">task_alt</span>
            </div>
            <div>
                <p class="text-xs font-medium text-slate-500 uppercase tracking-wide">Approved</p>
                <p class="text-xl font-semibold text-emerald-700">{{ $approvedCount ?? 0 }}</p>
            </div>
        </div>

    </div>

    {{-- Filter form --}}
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-4 mb-6">
        <form method="GET" action="{{ route('admin.comments.index') }}"
            class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">

            {{-- Search --}}
            <div class="col-span-2">
                <label class="block text-xs font-semibold text-slate-600 mb-1">Search</label>
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Search by comment, user, email, or article title..."
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
                    <option value="pending" @selected(request('status') === 'pending')>Pending</option>
                    <option value="approved" @selected(request('status') === 'approved')>Approved</option>
                </select>
            </div>

            {{-- Buttons --}}
            <div class="flex gap-2">
                <button type="submit"
                    class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium rounded-lg
                               bg-emerald-600 text-white hover:bg-emerald-700 flex-1">
                    Apply
                </button>

                @if (request()->hasAny(['search', 'status']))
                    <a href="{{ route('admin.comments.index') }}"
                        class="inline-flex items-center justify-center px-3 py-2 text-xs font-medium rounded-lg
                              border border-slate-200 text-slate-600 hover:bg-slate-50">
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    {{-- Table --}}
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="px-4 py-3 border-b border-slate-100 flex items-center justify-between">
            <h2 class="text-sm font-semibold text-slate-800">Comments</h2>
            <span class="text-xs text-slate-500">
                Showing {{ $comments->firstItem() ?? 0 }}–{{ $comments->lastItem() ?? 0 }} of {{ $comments->total() }}
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-slate-50 border-b border-slate-100">
                    <tr>
                        <th class="px-4 py-2 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">User
                        </th>
                        <th class="px-4 py-2 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">Article
                        </th>
                        <th class="px-4 py-2 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">Comment
                        </th>
                        <th class="px-4 py-2 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">Status
                        </th>
                        <th class="px-4 py-2 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">Created
                        </th>
                        <th class="px-4 py-2 text-right text-xs font-semibold text-slate-500 uppercase tracking-wide">
                            Actions</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100">
                    @forelse($comments as $comment)
                        <tr class="hover:bg-slate-50/60">
                            {{-- User --}}
                            <td class="px-4 py-3 align-top">
                                <div class="font-semibold text-slate-800">{{ $comment->user->name ?? '—' }}</div>
                                <div class="text-xs text-slate-500">{{ $comment->user->email ?? '' }}</div>
                            </td>

                            {{-- Article --}}
                            <td class="px-4 py-3 align-top">
                                <div class="font-semibold text-slate-800">
                                    {{ $comment->article->title ?? '—' }}
                                </div>
                                <div class="text-xs text-slate-500">ID: {{ $comment->article_id }}</div>
                            </td>

                            {{-- Short comment --}}
                            <td class="px-4 py-3 align-top max-w-md">
                                <p class="text-xs text-slate-600 line-clamp-2">
                                    {{ Str::limit($comment->body, 130) }}
                                </p>
                            </td>

                            {{-- Status --}}
                            <td class="px-4 py-3 align-top">
                                @if ($comment->status === 'pending')
                                    <span
                                        class="inline-flex items-center rounded-full bg-amber-50 px-2.5 py-0.5 text-[11px] font-semibold text-amber-800">
                                        ● Pending
                                    </span>
                                @elseif($comment->status === 'approved')
                                    <span
                                        class="inline-flex items-center rounded-full bg-emerald-50 px-2.5 py-0.5 text-[11px] font-semibold text-emerald-800">
                                        ● Approved
                                    </span>
                                @endif
                            </td>

                            {{-- Created --}}
                            <td class="px-4 py-3 align-top text-xs text-slate-500">
                                <div>{{ $comment->created_at->format('Y-m-d') }}</div>
                                <div class="text-[11px] text-slate-400">{{ $comment->created_at->format('H:i') }}</div>
                            </td>

                            {{-- Actions --}}
                            <td class="px-4 py-3 align-top text-right">
                                <div class="inline-flex items-center gap-2">

                                    {{-- Approve --}}
                                    @if ($comment->status !== 'approved')
                                        <form method="POST" action="{{ route('admin.comments.approve', $comment) }}">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit"
                                                class="inline-flex items-center justify-center px-3 py-1.5 text-xs font-semibold rounded-lg
                                                       bg-emerald-600 text-white hover:bg-emerald-700">
                                                Approve
                                            </button>
                                        </form>
                                    @endif

                                    {{-- Delete --}}
                                    <form method="POST" action="{{ route('admin.comments.destroy', $comment) }}"
                                        onsubmit="return confirm('Delete this comment permanently?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="inline-flex items-center justify-center px-3 py-1.5 text-xs font-semibold rounded-lg
                                                   bg-rose-600 text-white hover:bg-rose-700">
                                            Delete
                                        </button>
                                    </form>

                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-6 text-center text-sm text-slate-500">
                                No comments found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($comments->hasPages())
            <div class="border-t border-slate-100 px-4 py-3">
                {{ $comments->links() }}
            </div>
        @endif
    </div>

@endsection
