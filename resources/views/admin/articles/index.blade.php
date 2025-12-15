@extends('admin.layout')

@section('title', 'Articles')
@section('subtitle', 'Manage all articles')

@section('content')

    <div class="flex flex-col gap-4">

        {{-- Header --}}
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
            <div>
                <h1 class="text-xl font-semibold text-slate-800">Articles</h1>
                <p class="text-xs text-slate-500 mt-1">
                    Create, edit, publish and manage all articles.
                </p>
            </div>

            <a href="{{ route('admin.articles.create') }}"
                class="inline-flex items-center justify-center rounded-lg bg-emerald-600 px-4 py-2
                      text-sm font-medium text-white shadow-sm hover:bg-emerald-700 focus:outline-none">
                New Article
            </a>
        </div>

        {{-- Filters --}}
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-4">
            <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-3 items-end">
                <div class="md:col-span-2">
                    <label class="block text-xs font-medium text-slate-600 mb-1">
                        Search
                    </label>
                    <input type="text" name="search" id="article-filter-search" placeholder="Search by title..."
                        value="{{ $filters['search'] ?? '' }}"
                        class="block w-full rounded-lg border border-slate-200 px-3 py-2 text-sm
                               shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                </div>

                <div>
                    <label class="block text-xs font-medium text-slate-600 mb-1">
                        Status
                    </label>
                    <select name="status" id="article-filter-status"
                        class="block w-full rounded-lg border border-slate-200 px-3 py-2 text-sm
                               shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                        <option value="">Any status</option>
                        <option value="draft" @selected(($filters['status'] ?? '') === 'draft')>Draft</option>
                        <option value="published" @selected(($filters['status'] ?? '') === 'published')>Published</option>
                        <option value="archived" @selected(($filters['status'] ?? '') === 'archived')>Archived</option>
                    </select>
                </div>

                <div class="flex items-center gap-2 justify-end">
                    <button type="submit"
                        class="inline-flex items-center justify-center rounded-lg border border-slate-200 px-3 py-2
                              text-xs font-medium text-slate-700 hover:bg-slate-50">
                        Filter
                    </button>

                    <a href="{{ route('admin.articles.index') }}"
                        class="inline-flex items-center justify-center rounded-lg border border-slate-200 px-3 py-2
                              text-xs font-medium text-slate-700 hover:bg-slate-50">
                        Reset
                    </a>
                </div>
            </form>

            <p class="text-[11px] text-slate-400 mt-2">
                * Live search below.
            </p>
        </div>

        {{-- Table --}}
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
            <table class="min-w-full divide-y divide-slate-200 text-sm">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-4 py-2 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">ID</th>
                        <th class="px-4 py-2 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">Title
                        </th>
                        <th class="px-4 py-2 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">Excerpt
                        </th>
                        <th class="px-4 py-2 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">Status
                        </th>
                        <th class="px-4 py-2 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">Author
                        </th>
                        <th class="px-4 py-2 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">Image
                        </th>
                        <th class="px-4 py-2 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">Created
                        </th>
                        <th class="px-4 py-2 text-right text-xs font-semibold text-slate-500 uppercase tracking-wide">
                            Actions</th>
                    </tr>
                </thead>
                <tbody id="articles-tbody" class="divide-y divide-slate-100">
                    @foreach ($articles as $article)
                        <tr class="hover:bg-slate-50/80">
                            <td class="px-4 py-2 text-xs text-slate-500">#{{ $article->id }}</td>
                            <td class="px-4 py-2 text-sm font-medium text-slate-800">{{ $article->title }}</td>
                            <td class="px-4 py-2 text-sm text-slate-600">
                                {{ \Illuminate\Support\Str::limit(strip_tags($article->content), 80) }}
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
                            <td class="px-4 py-2">
                                @if ($article->image)
                                    <img src="{{ $article->image }}"
                                        class="h-8 w-7 rounded object-cover border border-slate-200">
                                @else
                                    <span class="text-xs text-slate-400">No image</span>
                                @endif
                            </td>
                            <td class="px-4 py-2 text-xs text-slate-500">
                                {{ $article->created_at->format('Y-m-d') }}
                            </td>

                            <td class="px-4 py-2 text-right">
                                <div class="inline-flex flex-wrap items-center justify-end gap-1">
                                    <a href="{{ route('admin.articles.edit', $article) }}"
                                        class="inline-flex items-center rounded-lg border border-slate-200 px-2 py-1
                                              text-xs font-medium text-slate-700 hover:bg-slate-50">
                                        Edit
                                    </a>

                                    <form action="{{ route('admin.articles.toggle-status', $article) }}" method="POST"
                                        class="inline-block">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit"
                                            class="inline-flex items-center rounded-lg border border-emerald-200 px-2 py-1
                                                       text-xs font-medium text-emerald-700 hover:bg-emerald-50">
                                            {{ $article->status === 'published' ? 'Unpublish' : 'Publish' }}
                                        </button>
                                    </form>

                                    <form action="{{ route('admin.articles.destroy', $article) }}" method="POST"
                                        class="inline-block"
                                        onsubmit="return confirm('Are you sure you want to delete this article?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="inline-flex items-center rounded-lg border border-rose-200 px-2 py-1
                                                       text-xs font-medium text-rose-700 hover:bg-rose-50">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{-- Pagination fallback --}}
            <div id="articles-pagination" class="border-t border-slate-100 bg-slate-50 px-4 py-3">
                {{ $articles->links() }}
            </div>
        </div>

    </div>

@endsection
