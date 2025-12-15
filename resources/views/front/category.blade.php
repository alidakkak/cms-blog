@extends('layouts.front')

@section('title', $category->name)

@section('content')
    <div class="space-y-8">

        <div class="flex flex-col gap-2">
            <h1 class="text-2xl md:text-3xl font-bold text-slate-900">
                Categories
            </h1>
            <p class="text-sm text-slate-500">
                Browse articles by category. You are viewing:
                <span class="font-semibold text-slate-800">"{{ $category->name }}"</span>
            </p>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm px-4 py-3">
            <div class="flex items-center gap-2 overflow-x-auto no-scrollbar">

                <a href="{{ route('home') }}"
                    class="whitespace-nowrap inline-flex items-center px-3 py-1.5 rounded-full text-xs md:text-sm
                          border border-slate-200 text-slate-600 hover:bg-slate-100">
                    All articles
                </a>

                @foreach ($categories as $cat)
                    <a href="{{ route('category.show', $cat) }}"
                        class="whitespace-nowrap inline-flex items-center px-3 py-1.5 rounded-full text-xs md:text-sm
                              border
                              @if ($cat->id === $category->id) bg-emerald-600 border-emerald-600 text-white
                              @else
                                  border-slate-200 text-slate-600 hover:bg-slate-100 @endif">
                        {{ $cat->name }}
                    </a>
                @endforeach
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5">
            <h2 class="text-lg font-semibold text-slate-800 mb-4">
                Articles in "{{ $category->name }}"
            </h2>

            @if ($articles->count() === 0)
                <p class="text-sm text-slate-500">
                    There are no articles in this category yet.
                </p>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-6">
                    @foreach ($articles as $article)
                        <a href="{{ route('article.show', $article->id) }}"
                            class="group bg-white border border-slate-200 rounded-2xl overflow-hidden shadow-sm hover:shadow-lg hover:-translate-y-1 transition">

                            @if ($article->image)
                                <div class="h-40 w-full overflow-hidden">
                                    <img src="{{ $article->image }}" alt="{{ $article->title }}"
                                        class="w-full h-full object-cover group-hover:brightness-90 transition">
                                </div>
                            @endif

                            <div class="p-4">
                                <h3
                                    class="text-sm font-semibold text-slate-900 mb-1 line-clamp-2 group-hover:text-emerald-600 transition">
                                    {{ $article->title }}
                                </h3>

                                <p class="text-xs text-slate-600 line-clamp-2 mb-2">
                                    {{ Str::limit(strip_tags($article->content), 100) }}
                                </p>

                                <div class="text-[11px] text-slate-400">
                                    {{ $article->created_at->format('M d, Y') }}
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>

                <div class="mt-8">
                    {{ $articles->links() }}
                </div>
            @endif
        </div>

    </div>
@endsection
