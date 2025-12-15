@extends('layouts.front')

@section('title', 'Home')

@section('content')

    {{-- Search + Filter --}}
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-5 mb-8">
        <form method="GET" action="/" class="grid grid-cols-1 md:grid-cols-3 gap-4">

            {{-- Search --}}
            <div class="col-span-1">
                <input type="text" name="search" placeholder="Search articles..." value="{{ request('search') }}"
                    class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-emerald-500 focus:border-emerald-500">
            </div>

            {{-- Category Filter --}}
            <div class="col-span-1">
                <select name="category"
                    class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-emerald-500 focus:border-emerald-500">
                    <option value="">All categories</option>

                    @foreach ($categories as $cat)
                        <option value="{{ $cat->id }}" @selected(request('category') == $cat->id)>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-span-1 flex">
                <button class="px-5 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700">
                    Filter
                </button>
            </div>
        </form>
    </div>

    {{-- Articles Grid --}}
    <div class="max-w-6xl mx-auto">

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">

            @foreach ($articles as $article)
                <a href="{{ route('article.show', $article->id) }}"
                    class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden hover:shadow-md transition">

                    @if ($article->image)
                        <img src="{{ $article->image }}" class="h-48 w-full object-cover">
                    @endif

                    <div class="p-4">
                        <h3 class="text-lg font-semibold text-slate-800 mb-1">
                            {{ $article->title }}
                        </h3>
                        <p class="text-sm text-slate-500 line-clamp-2 mb-2">
                            {{ Str::limit(strip_tags($article->content), 120) }}
                        </p>
                        <span class="text-xs text-slate-400">
                            {{ $article->created_at->format('M d, Y') }}
                        </span>
                    </div>

                </a>
            @endforeach

        </div>

    </div>


    {{-- Pagination --}}
    <div class="mt-10">
        {{ $articles->links() }}
    </div>

@endsection
