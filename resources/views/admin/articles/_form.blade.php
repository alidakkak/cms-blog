@csrf

<div class="space-y-5">

    {{-- Title --}}
    <div class="space-y-1">
        <label for="title" class="block text-sm font-medium text-slate-700">
            Title <span class="text-rose-500">*</span>
        </label>
        <input type="text" name="title" id="title" required value="{{ old('title', $article->title ?? '') }}"
            class="block w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm
                   shadow-sm focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500
                   placeholder:text-slate-400"
            placeholder="Article title">
        @error('title')
            <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
        @enderror
    </div>

    {{-- Content (TinyMCE) --}}
    <div class="space-y-1">
        <label for="content" class="block text-sm font-medium text-slate-700">
            Content <span class="text-rose-500">*</span>
        </label>
        <textarea name="content" id="content" rows="10"
            class="block w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm
                   shadow-sm focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500">{{ old('content', $article->content ?? '') }}</textarea>
        @error('content')
            <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
        @enderror
    </div>

    {{-- Status --}}
    <div class="space-y-1">
        <label for="status" class="block text-sm font-medium text-slate-700">
            Status
        </label>

        @php
            $statusValue = old('status', $article->status ?? 'draft');
        @endphp

        <select name="status" id="status"
            class="block w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm
                   shadow-sm focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500">
            <option value="draft" @selected($statusValue === 'draft')>Draft</option>
            <option value="published" @selected($statusValue === 'published')>Published</option>
            <option value="archived" @selected($statusValue === 'archived')>Archived</option>
        </select>

        @error('status')
            <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
        @enderror
    </div>

    {{-- Enable / Disable Comments --}}
    <div class="space-y-2">
        <label for="comments_enabled" class="block text-sm font-medium text-slate-700">
            Comments
        </label>

        @php
            $commentsEnabled = old('comments_enabled', $article->comments_enabled ?? true);
        @endphp

        <label class="inline-flex items-center cursor-pointer select-none">
            <input type="hidden" name="comments_enabled" value="0">

            <input type="checkbox" name="comments_enabled" id="comments_enabled" value="1" class="sr-only peer"
                @checked(old('comments_enabled', $article->comments_enabled ?? true))>

            {{-- Toggle --}}
            <div
                class="relative w-10 h-5 bg-slate-300 rounded-full
                   peer-checked:bg-emerald-600
                   transition-colors duration-200
                   after:content-['']
                   after:absolute after:top-[2px] after:left-[2px]
                   after:w-4 after:h-4 after:bg-white after:rounded-full
                   after:transition-transform after:duration-200
                   peer-checked:after:translate-x-5">
            </div>

            {{-- Label text --}}
            <span class="ml-3 text-sm font-medium text-slate-700">
                Allow comments on this article
            </span>
        </label>

        <p class="text-xs text-slate-500">
            If disabled, users will not be able to add new comments.
        </p>

        @error('comments_enabled')
            <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
        @enderror
    </div>


    {{-- Image upload + Preview --}}
    <div class="space-y-2">
        <label for="image" class="block text-sm font-medium text-slate-700">
            Cover Image
        </label>

        <input type="file" name="image" id="image" accept="image/*"
            class="block w-full text-sm text-slate-700
                   file:mr-3 file:rounded-lg file:border-0 file:bg-slate-900 file:px-3 file:py-2
                   file:text-sm file:font-medium file:text-white hover:file:bg-slate-800">

        @error('image')
            <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
        @enderror

        <div class="mt-2 flex items-center gap-3">
            <img id="image-preview" src="{{ $article->image }}" alt="Preview"
                class="rounded-lg border border-slate-200 max-h-32 {{ isset($article) && $article->image ? '' : 'hidden' }}">
            <p class="text-xs text-slate-400">
                PNG / JPG, max 2MB.
            </p>
        </div>
    </div>

</div>
