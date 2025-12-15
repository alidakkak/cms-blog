@extends('layouts.front')

@section('title', $article->title)

@section('content')

    {{-- Title + Author --}}
    <h1 class="text-3xl font-bold text-slate-900 mb-3">{{ $article->title }}</h1>

    <div class="text-sm text-slate-500 mb-6">
        By <span class="font-medium text-slate-700">{{ $article->author->name }}</span> —
        {{ $article->created_at->format('M d, Y') }}
    </div>

    {{-- Image --}}
    @if ($article->image)
        <img src="{{ $article->image }}" alt="{{ $article->title }}"
            class="w-full rounded-xl mb-6 shadow-sm border border-slate-200">
    @endif

    {{-- Content --}}
    <div class="prose prose-slate max-w-none mb-10">
        {!! $article->content !!}
    </div>

    {{-- Related Articles --}}
    <h2 class="text-xl font-semibold text-slate-800 mb-4">Related articles</h2>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        @forelse($related as $rel)
            <a href="{{ route('article.show', $rel->id) }}"
                class="border border-slate-200 rounded-xl p-4 bg-white shadow-sm hover:shadow-md">
                <h3 class="text-md font-semibold text-slate-800">{{ $rel->title }}</h3>
                <p class="text-sm text-slate-500 mt-1">
                    {{ Str::limit(strip_tags($rel->content), 80) }}
                </p>
            </a>
        @empty
            <p class="text-slate-500 text-sm">No related articles.</p>
        @endforelse

    </div>

    {{-- Add Comment --}}
    <h3 class="text-xl font-semibold mt-10 mb-4">Comments</h3>

    @if (!$article->comments_enabled)
        <p class="text-sm text-slate-500">Comments are disabled for this article.</p>
    @else
        @auth
            <form method="POST" action="{{ route('comments.store') }}" class="mb-6">
                @csrf
                <input type="hidden" name="article_id" value="{{ $article->id }}">
                <textarea name="body" required class="w-full border rounded-lg p-3 text-sm" placeholder="Write your comment..."></textarea>
                <button class="mt-2 px-4 py-2 bg-emerald-600 text-white rounded-lg">
                    Submit
                </button>
            </form>
        @else
            <p class="text-sm text-slate-500">
                You must <a href="{{ route('login') }}" class="text-emerald-600 underline">login</a> to comment.
            </p>
        @endauth

        {{-- Approved comments --}}
        @foreach ($article->comments->where('status', 'approved') as $comment)
            <div class="border rounded-lg p-3 mb-3">
                <div class="text-xs text-slate-500 mb-1">
                    {{ $comment->user->name }} • {{ $comment->created_at->diffForHumans() }}
                </div>
                <p class="text-sm text-slate-800">
                    {{ $comment->body }}
                </p>
            </div>
        @endforeach
    @endif


@endsection
