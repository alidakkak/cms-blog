@extends('admin.layout')

@section('title', 'Edit Article')
@section('subtitle', 'Update article content')

@section('content')
    <div class="max-w-3xl space-y-4">

        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
            <div class="mb-4">
                <h2 class="text-base font-semibold text-slate-800">
                    Article details
                </h2>
                <p class="text-xs text-slate-500 mt-1">
                    Make changes and save to update this article.
                </p>
            </div>

            <form action="{{ route('admin.articles.update', $article) }}" method="POST" enctype="multipart/form-data"
                class="space-y-6">
                @method('PUT')
                @include('admin.articles._form', ['article' => $article])

                <div class="flex items-center justify-end gap-2 pt-2">
                    <a href="{{ route('admin.articles.index') }}"
                        class="inline-flex items-center rounded-lg border border-slate-200 px-4 py-2
                              text-xs font-medium text-slate-700 hover:bg-slate-50">
                        Cancel
                    </a>

                    <button type="submit"
                        class="inline-flex items-center rounded-lg bg-emerald-600 px-4 py-2
                                   text-xs font-semibold text-white shadow-sm hover:bg-emerald-700
                                   focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-1">
                        Update
                    </button>
                </div>
            </form>
        </div>

    </div>
@endsection
