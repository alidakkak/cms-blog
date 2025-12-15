@extends('admin.layout')

@section('title', 'Create Article')
@section('subtitle', 'Add a new article')

@section('content')
    <div class="max-w-3xl space-y-4">

        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
            <div class="mb-4">
                <h2 class="text-base font-semibold text-slate-800">
                    Article details
                </h2>
                <p class="text-xs text-slate-500 mt-1">
                    Fill in the fields below to create a new article.
                </p>
            </div>

            <form action="{{ route('admin.articles.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @include('admin.articles._form', ['article' => new \App\Models\Article()])

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
                        Save
                    </button>
                </div>
            </form>
        </div>

    </div>
@endsection

@push('scripts')
    <script>
        // TinyMCE init
        tinymce.init({
            selector: '#content',
            height: 400,
            plugins: 'link image code lists table lists',
            toolbar: 'undo redo | styleselect | bold italic underline | alignleft aligncenter alignright | bullist numlist | link | table | code',
        });

        // Image preview
        $(function() {
            $('#image').on('change', function() {
                const [file] = this.files;
                if (file) {
                    $('#image-preview')
                        .attr('src', URL.createObjectURL(file))
                        .removeClass('hidden');
                }
            });
        });
    </script>
@endpush
