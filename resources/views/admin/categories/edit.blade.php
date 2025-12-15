@extends('admin.layout')

@section('title', 'Edit Category')
@section('subtitle', 'Update the category information')

@section('content')
    <div class="max-w-2xl space-y-4">

        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
            <div class="mb-4">
                <h2 class="text-base font-semibold text-slate-800">
                    Category details
                </h2>
                <p class="text-xs text-slate-500 mt-1">
                    Make changes to this category and save when you’re done.
                </p>
            </div>

            <form action="{{ route('admin.categories.update', $category) }}" method="POST" class="space-y-6">
                @method('PUT')
                @include('admin.categories._form', ['category' => $category])

                <div class="flex items-center justify-end gap-2 pt-2">
                    <a href="{{ route('admin.categories.index') }}"
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
