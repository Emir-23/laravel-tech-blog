@php
    $isEdit = $category !== null;
@endphp

<div class="max-w-xl rounded-xl border border-slate-700 bg-slate-800 p-6 shadow-sm">
    <form
        method="POST"
        action="{{ $isEdit ? route('admin.categories.update', $category) : route('admin.categories.store') }}"
        class="space-y-4"
    >
        @csrf
        @if ($isEdit)
            @method('PUT')
        @endif

        <div>
            <label for="name" class="mb-1 block text-sm font-medium text-slate-200">Kategori adı</label>
            <input
                id="name"
                type="text"
                name="name"
                value="{{ old('name', $isEdit ? $category->name : '') }}"
                required
                maxlength="255"
                data-slug-source
                class="block w-full rounded-lg border border-slate-600 bg-slate-900/60 px-3 py-2 text-sm text-slate-100 shadow-sm outline-none transition placeholder:text-slate-500 focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
            >
            @error('name')
                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <p class="mb-1 text-sm font-medium text-slate-200">SEO slug</p>
            <p class="rounded-lg border border-slate-700 bg-slate-900/50 px-3 py-2 font-mono text-sm text-slate-300">
                <span data-slug-preview>{{ $isEdit ? $category->slug : 'ad-yazildikca-olusur' }}</span>
            </p>
            <p class="mt-1 text-xs text-slate-400">Kayıtta Laravel <code class="text-blue-300">Str::slug</code> ile üretilir. Aynı isimde çakışma olursa sonuna numara eklenir.</p>
        </div>

        <div class="flex items-center gap-2">
            <button
                type="submit"
                class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white shadow-sm transition hover:bg-blue-500"
            >
                {{ $isEdit ? 'Güncelle' : 'Kaydet' }}
            </button>
            <a
                href="{{ route('admin.categories.index') }}"
                class="rounded-lg border border-slate-600 px-4 py-2 text-sm text-slate-300 transition hover:border-slate-500 hover:bg-slate-700 hover:text-white"
            >
                İptal
            </a>
        </div>
    </form>
</div>

<script>
    (function () {
        const source = document.querySelector('[data-slug-source]');
        const preview = document.querySelector('[data-slug-preview]');
        if (!source || !preview) return;

        const slugify = (value) => value
            .toString()
            .toLowerCase()
            .replaceAll('ç', 'c')
            .replaceAll('ğ', 'g')
            .replaceAll('ı', 'i')
            .replaceAll('ö', 'o')
            .replaceAll('ş', 's')
            .replaceAll('ü', 'u')
            .replace(/[^a-z0-9]+/g, '-')
            .replace(/^-+|-+$/g, '');

        source.addEventListener('input', () => {
            preview.textContent = slugify(source.value) || 'ad-yazildikca-olusur';
        });
    })();
</script>
