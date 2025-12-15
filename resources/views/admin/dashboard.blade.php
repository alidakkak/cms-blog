@extends('admin.layout')

@section('title', 'Dashboard')
@section('subtitle', 'Overview of your content and activity')

@section('content')

    {{-- (Cards) --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">

        {{-- Articles --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-4 flex items-center gap-4">
            <div class="h-10 w-10 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center text-xl">
                <span class="material-symbols-outlined">article</span>
            </div>
            <div class="flex-1">
                <p class="text-xs font-medium text-slate-500 uppercase tracking-wide">
                    Articles
                </p>
                <p class="text-xl font-semibold text-slate-900">
                    {{ $articlesCount ?? 0 }}
                </p>
                <p class="text-[11px] text-slate-400">
                    Total published & draft articles
                </p>
            </div>
        </div>

        {{-- Categories --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-4 flex items-center gap-4">
            <div class="h-10 w-10 rounded-full bg-sky-100 text-sky-700 flex items-center justify-center text-xl">
                <span class="material-symbols-outlined">category</span>
            </div>
            <div class="flex-1">
                <p class="text-xs font-medium text-slate-500 uppercase tracking-wide">
                    Categories
                </p>
                <p class="text-xl font-semibold text-slate-900">
                    {{ $categoriesCount ?? 0 }}
                </p>
                <p class="text-[11px] text-slate-400">
                    Active article categories
                </p>
            </div>
        </div>

        {{-- Comments --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-4 flex items-center gap-4">
            <div class="h-10 w-10 rounded-full bg-orange-100 text-orange-700 flex items-center justify-center text-xl">
                <span class="material-symbols-outlined">chat</span>
            </div>
            <div class="flex-1">
                <p class="text-xs font-medium text-slate-500 uppercase tracking-wide">
                    Comments
                </p>
                <p class="text-xl font-semibold text-slate-900">
                    {{ $commentsCount ?? 0 }}
                </p>
                <p class="text-[11px] text-slate-400">
                    Total comments from visitors
                </p>
            </div>
        </div>

        {{-- Contact messages --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-4 flex items-center gap-4">
            <div class="h-10 w-10 rounded-full bg-rose-100 text-rose-700 flex items-center justify-center text-xl">
                <span class="material-symbols-outlined">mail</span>
            </div>
            <div class="flex-1">
                <p class="text-xs font-medium text-slate-500 uppercase tracking-wide">
                    Contact Messages
                </p>
                <p class="text-xl font-semibold text-slate-900">
                    {{ $messagesCount ?? 0 }}
                </p>
                <p class="text-[11px] text-slate-400">
                    Messages from contact form
                </p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">

        {{-- Latest articles --}}
        <div class="lg:col-span-2 bg-white rounded-2xl border border-slate-200 shadow-sm">
            <div class="px-5 py-4 border-b border-slate-100 flex items-center justify-between">
                <div>
                    <h2 class="text-sm font-semibold text-slate-800">
                        Latest articles
                    </h2>
                    <p class="text-xs text-slate-500">
                        Recently created or updated articles.
                    </p>
                </div>
                <a href="{{ route('admin.articles.index') }}"
                    class="text-xs font-medium text-emerald-700 hover:text-emerald-800 hover:underline">
                    View all
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="bg-slate-50 border-b border-slate-100">
                        <tr>
                            <th class="px-4 py-2 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">
                                Title
                            </th>
                            <th class="px-4 py-2 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">
                                Status
                            </th>
                            <th class="px-4 py-2 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">
                                Author
                            </th>
                            <th class="px-4 py-2 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">
                                Created
                            </th>
                            <th class="px-4 py-2 text-right text-xs font-semibold text-slate-500 uppercase tracking-wide">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse(($latestArticles ?? []) as $article)
                            <tr class="hover:bg-slate-50/80">
                                <td class="px-4 py-2 text-sm text-slate-800">
                                    {{ $article->title }}
                                </td>
                                <td class="px-4 py-2">
                                    @if ($article->status === 'published')
                                        <span
                                            class="inline-flex items-center rounded-full bg-emerald-50 px-2 py-0.5 text-xs font-medium text-emerald-700">
                                            ● Published
                                        </span>
                                    @elseif($article->status === 'draft')
                                        <span
                                            class="inline-flex items-center rounded-full bg-slate-100 px-2 py-0.5 text-xs font-medium text-slate-700">
                                            ● Draft
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center rounded-full bg-amber-50 px-2 py-0.5 text-xs font-medium text-amber-700">
                                            ● Archived
                                        </span>
                                    @endif
                                </td>
                                <td class="px-4 py-2 text-sm text-slate-600">
                                    {{ $article->author?->name ?? '-' }}
                                </td>
                                <td class="px-4 py-2 text-xs text-slate-500">
                                    {{ $article->created_at?->format('Y-m-d') }}
                                </td>
                                <td class="px-4 py-2 text-right">
                                    <a href="{{ route('admin.articles.edit', $article) }}"
                                        class="inline-flex items-center rounded-lg border border-slate-200 px-2 py-1
                                              text-xs font-medium text-slate-700 hover:bg-slate-50">
                                        Edit
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-6 text-center text-sm text-slate-500">
                                    No articles yet. <a href="{{ route('admin.articles.create') }}"
                                        class="text-emerald-700 hover:underline">Create the first one</a>.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Small stats / system info --}}
        <div class="space-y-4">

            {{-- Activity summary --}}
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-4">
                <h2 class="text-sm font-semibold text-slate-800 mb-2">
                    Activity summary
                </h2>
                <ul class="space-y-2 text-xs text-slate-600">
                    <li class="flex items-center justify-between">
                        <span>Published articles</span>
                        <span class="font-semibold text-slate-900">
                            {{ $publishedArticlesCount ?? 0 }}
                        </span>
                    </li>
                    <li class="flex items-center justify-between">
                        <span>Draft articles</span>
                        <span class="font-semibold text-slate-900">
                            {{ $draftArticlesCount ?? 0 }}
                        </span>
                    </li>
                    <li class="flex items-center justify-between">
                        <span>Unread contact messages</span>
                        <span class="font-semibold text-rose-600">
                            {{ $unreadMessagesCount ?? 0 }}
                        </span>
                    </li>
                    <li class="flex items-center justify-between">
                        <span>Comments awaiting review</span>
                        <span class="font-semibold text-amber-600">
                            {{ $pendingCommentsCount ?? 0 }}
                        </span>
                    </li>
                </ul>
            </div>

            {{-- Quick links --}}
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-4">
                <h2 class="text-sm font-semibold text-slate-800 mb-2">
                    Quick actions
                </h2>
                <div class="flex flex-col gap-2 text-xs">
                    <a href="{{ route('admin.articles.create') }}"
                        class="inline-flex items-center justify-between rounded-lg border border-emerald-200
                              px-3 py-2 text-emerald-700 hover:bg-emerald-50">
                        <span class="flex items-center gap-2">
                            <span class="material-symbols-outlined text-base">add</span>
                            <span>Create new article</span>
                        </span>
                        <span class="material-symbols-outlined text-base">chevron_right</span>
                    </a>

                    <a href="{{ route('admin.categories.index') }}"
                        class="inline-flex items-center justify-between rounded-lg border border-slate-200
                              px-3 py-2 text-slate-700 hover:bg-slate-50">
                        <span class="flex items-center gap-2">
                            <span class="material-symbols-outlined text-base">category</span>
                            <span>Manage categories</span>
                        </span>
                        <span class="material-symbols-outlined text-base">chevron_right</span>
                    </a>

                    <a href="{{ route('admin.comments.index') }}"
                        class="inline-flex items-center justify-between rounded-lg border border-slate-200
                              px-3 py-2 text-slate-700 hover:bg-slate-50">
                        <span class="flex items-center gap-2">
                            <span class="material-symbols-outlined text-base">chat</span>
                            <span>Review comments</span>
                        </span>
                        <span class="material-symbols-outlined text-base">chevron_right</span>
                    </a>
                </div>
            </div>

        </div>

    </div>

@endsection
