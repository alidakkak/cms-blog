@extends('admin.layout')

@section('title', 'Categories')
@section('subtitle', 'Manage article categories')

@section('content')

    <div class="flex flex-col gap-4">

        {{-- Header --}}
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
            <div>
                <h1 class="text-xl font-semibold text-slate-800">Categories</h1>
                <p class="text-xs text-slate-500 mt-1">
                    Create, edit, and organize article categories.
                </p>
            </div>

            <a href="{{ route('admin.categories.create') }}"
                class="inline-flex items-center justify-center rounded-lg bg-emerald-600 px-4 py-2
                      text-sm font-medium text-white shadow-sm hover:bg-emerald-700 focus:outline-none">
                New Category
            </a>
        </div>

        {{-- Filters --}}
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-4">
            <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-3 items-end">
                <div class="md:col-span-2">
                    <label class="block text-xs font-medium text-slate-600 mb-1">
                        Search
                    </label>
                    <input type="text" name="search" id="filter-search" placeholder="Search by name..."
                        value="{{ $filters['search'] ?? '' }}"
                        class="block w-full rounded-lg border border-slate-200 px-3 py-2 text-sm
                               shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                </div>

                <div>
                    <label class="block text-xs font-medium text-slate-600 mb-1">
                        Status
                    </label>
                    <select name="status" id="filter-status"
                        class="block w-full rounded-lg border border-slate-200 px-3 py-2 text-sm
                               shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                        <option value="">Any status</option>
                        <option value="active" @selected(($filters['status'] ?? '') === 'active')>Active</option>
                        <option value="inactive" @selected(($filters['status'] ?? '') === 'inactive')>Inactive</option>
                    </select>
                </div>

                <div class="flex items-center gap-2 justify-end">
                    <button type="submit"
                        class="inline-flex items-center justify-center rounded-lg border border-slate-200 px-3 py-2
                              text-xs font-medium text-slate-700 hover:bg-slate-50">
                        Filter
                    </button>

                    <a href="{{ route('admin.categories.index') }}"
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
                        <th class="px-4 py-2 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">Name
                        </th>
                        <th class="px-4 py-2 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">
                            Description</th>
                        <th class="px-4 py-2 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">Status
                        </th>
                        <th class="px-4 py-2 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">Created
                        </th>
                        <th class="px-4 py-2 text-right text-xs font-semibold text-slate-500 uppercase tracking-wide">
                            Actions</th>
                    </tr>
                </thead>
                <tbody id="categories-tbody" class="divide-y divide-slate-100">
                    @foreach ($categories as $category)
                        <tr class="hover:bg-slate-50/80">
                            <td class="px-4 py-2 text-xs text-slate-500">
                                #{{ $category->id }}
                            </td>
                            <td class="px-4 py-2 text-sm font-medium text-slate-800">
                                {{ $category->name }}
                            </td>
                            <td class="px-4 py-2 text-sm text-slate-600">
                                {{ \Illuminate\Support\Str::limit($category->description, 60) }}
                            </td>
                            <td class="px-4 py-2">
                                @if ($category->status === 'active')
                                    <span
                                        class="inline-flex items-center rounded-full bg-emerald-50 px-2 py-0.5 text-xs font-medium text-emerald-700">
                                        ● Active
                                    </span>
                                @else
                                    <span
                                        class="inline-flex items-center rounded-full bg-slate-100 px-2 py-0.5 text-xs font-medium text-slate-600">
                                        ● Inactive
                                    </span>
                                @endif
                            </td>
                            <td class="px-4 py-2 text-xs text-slate-500">
                                {{ $category->created_at->format('Y-m-d') }}
                            </td>
                            <td class="px-4 py-2 text-right">
                                <div class="inline-flex items-center gap-1">
                                    <a href="{{ route('admin.categories.edit', $category) }}"
                                        class="inline-flex items-center rounded-lg border border-slate-200 px-2 py-1
                                              text-xs font-medium text-slate-700 hover:bg-slate-50">
                                        Edit
                                    </a>

                                    <form action="{{ route('admin.categories.destroy', $category) }}" method="POST"
                                        onsubmit="return confirm('Are you sure you want to delete this category?');">
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

            {{-- Pagination --}}
            <div id="categories-pagination" class="border-t border-slate-100 bg-slate-50 px-4 py-3">
                {{ $categories->links() }}
            </div>
        </div>

    </div>

@endsection
