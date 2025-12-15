{{-- resources/views/admin/categories/_form.blade.php --}}

@csrf

<div class="space-y-4">

    {{-- Name --}}
    <div class="space-y-1">
        <label for="name" class="block text-sm font-medium text-slate-700">
            Name <span class="text-rose-500">*</span>
        </label>

        <input
            type="text"
            name="name"
            id="name"
            value="{{ old('name', $category->name ?? '') }}"
            required
            class="block w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm
                   shadow-sm focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500
                   placeholder:text-slate-400"
            placeholder="e.g. News, Technology, Lifestyle"
        >

        @error('name')
            <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
        @enderror
    </div>

    {{-- Description --}}
    <div class="space-y-1">
        <label for="description" class="block text-sm font-medium text-slate-700">
            Description
        </label>

        <textarea
            name="description"
            id="description"
            rows="3"
            class="block w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm
                   shadow-sm focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500
                   placeholder:text-slate-400 resize-y min-h-[96px]"
            placeholder="Short description about this category (optional)"
        >{{ old('description', $category->description ?? '') }}</textarea>

        @error('description')
            <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
        @enderror
    </div>

    {{-- Status --}}
    <div class="space-y-1">
        <label for="status" class="block text-sm font-medium text-slate-700">
            Status
        </label>

        @php
            $statusValue = old('status', $category->status ?? 'active');
        @endphp

        <select
            name="status"
            id="status"
            class="block w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm
                   shadow-sm focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500"
        >
            <option value="active" @selected($statusValue === 'active')>Active</option>
            <option value="inactive" @selected($statusValue === 'inactive')>Inactive</option>
        </select>

        @error('status')
            <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
        @enderror
    </div>

</div>
