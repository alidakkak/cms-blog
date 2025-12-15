{{-- resources/views/admin/categories/create.blade.php --}}

@extends('admin.layout')

@section('title', 'Create Category')
@section('subtitle', 'Add a new category for organizing articles')

@section('content')
    <div class="max-w-2xl space-y-4">

        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
            <div class="mb-4">
                <h2 class="text-base font-semibold text-slate-800">
                    Category details
                </h2>
                <p class="text-xs text-slate-500 mt-1">
                    Fill in the basic information for this category.
                </p>
            </div>

            <form action="{{ route('admin.categories.store') }}" method="POST" class="space-y-6">
                @include('admin.categories._form', ['category' => new \App\Models\Category()])

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
                        Save
                    </button>
                </div>
            </form>
        </div>

    </div>
@endsection
