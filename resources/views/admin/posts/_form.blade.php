@php
    $isEdit = $post !== null;
    $hasExistingImage = $isEdit && $post->image;
@endphp

<form
    method="POST"
    action="{{ $isEdit ? route('admin.posts.update', $post) : route('admin.posts.store') }}"
    enctype="multipart/form-data"
    class="grid grid-cols-1 gap-6 lg:grid-cols-3"
>
    @csrf
    @if ($isEdit)
        @method('PUT')
    @endif

    <div class="space-y-6 lg:col-span-2">
        <div class="rounded-xl border border-slate-700 bg-slate-800 p-6 shadow-sm">
            <label for="title" class="mb-1 block text-sm font-medium text-slate-200">Başlık</label>
            <input
                id="title"
                type="text"
                name="title"
                value="{{ old('title', $isEdit ? $post->title : '') }}"
                required
                maxlength="255"
                class="block w-full rounded-lg border border-slate-600 bg-slate-900/60 px-3 py-2 text-sm text-slate-100 shadow-sm outline-none transition focus:border-blue-500 focus:bg-slate-900 focus:ring-1 focus:ring-blue-500"
            >
            @error('title')
                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
            @enderror

            <p class="mt-2 text-xs text-slate-400">
                SEO slug kayıtta otomatik üretilir{{ $isEdit ? ' (şu an: '.$post->slug.')' : '' }}. Çakışma olursa sonuna numara eklenir.
            </p>
        </div>

        <div class="rounded-xl border border-slate-700 bg-slate-800 p-6 shadow-sm">
            <label for="content-editor" class="mb-2 block text-sm font-medium text-slate-200">İçerik</label>

            <div class="mb-3 flex flex-wrap items-center gap-1 rounded-lg border border-slate-700 bg-slate-900/50 p-1.5" data-editor-toolbar>
                <button type="button" data-cmd="bold" title="Kalın" class="rounded px-2 py-1 text-sm font-bold text-slate-200 transition hover:bg-slate-700">B</button>
                <button type="button" data-cmd="italic" title="İtalik" class="rounded px-2 py-1 text-sm italic text-slate-200 transition hover:bg-slate-700">I</button>
                <button type="button" data-cmd="underline" title="Altı çizili" class="rounded px-2 py-1 text-sm underline text-slate-200 transition hover:bg-slate-700">U</button>
                <span class="mx-1 w-px self-stretch bg-slate-600"></span>
                <button type="button" data-cmd="formatBlock" data-value="h2" title="Başlık 2" class="rounded px-2 py-1 text-sm font-semibold text-slate-200 transition hover:bg-slate-700">H2</button>
                <button type="button" data-cmd="formatBlock" data-value="h3" title="Başlık 3" class="rounded px-2 py-1 text-sm font-semibold text-slate-200 transition hover:bg-slate-700">H3</button>
                <button type="button" data-cmd="formatBlock" data-value="p" title="Paragraf" class="rounded px-2 py-1 text-sm text-slate-200 transition hover:bg-slate-700">P</button>
                <span class="mx-1 w-px self-stretch bg-slate-600"></span>
                <button type="button" data-cmd="insertUnorderedList" title="Madde listesi" class="rounded px-2 py-1 text-sm text-slate-200 transition hover:bg-slate-700">• Liste</button>
                <button type="button" data-cmd="insertOrderedList" title="Numaralı liste" class="rounded px-2 py-1 text-sm text-slate-200 transition hover:bg-slate-700">1. Liste</button>
                <button type="button" data-cmd="createLink" data-prompt="Bağlantı adresi (URL)" title="Bağlantı ekle" class="rounded px-2 py-1 text-sm text-slate-200 transition hover:bg-slate-700">Link</button>
                <span class="mx-1 w-px self-stretch bg-slate-600"></span>
                <button type="button" data-cmd="removeFormat" title="Biçimlendirmeyi temizle" class="rounded px-2 py-1 text-sm text-slate-200 transition hover:bg-slate-700">Temizle</button>
                <span class="mx-1 w-px self-stretch bg-slate-600"></span>

                <label title="Yazı rengi" class="flex items-center gap-1.5 rounded px-1.5 py-1 text-xs text-slate-400">
                    <input
                        type="color"
                        data-editor-color
                        value="#e2e8f0"
                        class="h-7 w-7 cursor-pointer appearance-none rounded-full border-2 border-slate-600 bg-transparent p-0 shadow [&::-webkit-color-swatch]:rounded-full [&::-webkit-color-swatch]:border-0 [&::-webkit-color-swatch-wrapper]:rounded-full [&::-webkit-color-swatch-wrapper]:p-0"
                    >
                    Renk
                </label>
            </div>

            <div
                id="content-editor"
                contenteditable="true"
                data-editor-body
                class="prose prose-sm min-h-[400px] max-w-none rounded-lg border border-slate-600 bg-slate-900/60 p-4 text-sm text-slate-200 shadow-sm outline-none transition focus:border-blue-500 focus:bg-slate-900 focus:ring-2 focus:ring-blue-500/20"
            >{!! old('content', $isEdit ? $post->content : '') !!}</div>

            <textarea name="content" data-editor-source class="hidden">{{ old('content', $isEdit ? $post->content : '') }}</textarea>

            @error('content')
                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
            @enderror
            <p class="mt-2 text-xs text-slate-400">
                Hazır bir editör paketi kullanılmadı; araç çubuğu <code class="text-blue-300">contenteditable</code> ve tarayıcının <code class="text-blue-300">document.execCommand</code> API'siyle çalışır.
            </p>
        </div>
    </div>

    <div class="space-y-6">
        <div class="rounded-xl border border-slate-700 bg-slate-800 p-6 shadow-sm">
            <p class="mb-1 block text-sm font-medium text-slate-200">Kategoriler</p>
            <p class="mb-3 text-xs text-slate-400">Bu yazı için bir veya daha fazla kategori seçebilirsiniz.</p>

            @php
                $selectedCategoryIds = collect(old('categories', $isEdit ? $post->categories->pluck('id')->all() : []))
                    ->map(fn ($id) => (int) $id)
                    ->all();
            @endphp

            <div class="max-h-56 space-y-1 overflow-y-auto rounded-lg border border-slate-700 bg-slate-900/50 p-2">
                @forelse ($categories as $category)
                    <label class="flex cursor-pointer items-center gap-2 rounded-lg px-2.5 py-2 text-sm text-slate-200 transition hover:bg-slate-700/60">
                        <input
                            type="checkbox"
                            name="categories[]"
                            value="{{ $category->id }}"
                            @checked(in_array($category->id, $selectedCategoryIds, true))
                            class="h-4 w-4 rounded border-slate-600 bg-slate-900 text-blue-600 focus:ring-blue-500"
                        >
                        {{ $category->name }}
                    </label>
                @empty
                    <p class="px-2.5 py-2 text-sm text-slate-400">
                        Önce en az bir kategori oluşturmalısınız.
                    </p>
                @endforelse
            </div>

            @error('categories')
                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
            @enderror
            @error('categories.*')
                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <div class="rounded-xl border border-slate-700 bg-slate-800 p-6 shadow-sm">
            <p class="mb-2 block text-sm font-medium text-slate-200">Kapak görseli</p>

            <label
                for="image-input"
                data-image-drop
                class="group relative flex h-48 w-full cursor-pointer flex-col items-center justify-center overflow-hidden rounded-lg border-2 border-dashed border-slate-600 bg-slate-900/50 p-6 text-center transition hover:border-blue-500/50 hover:bg-slate-900"
            >
                <img
                    src="{{ $hasExistingImage ? Storage::url($post->image) : '' }}"
                    alt="{{ $isEdit ? $post->title : 'Kapak önizleme' }}"
                    data-image-preview
                    class="absolute inset-0 h-full w-full object-cover {{ $hasExistingImage ? '' : 'hidden' }}"
                >

                <div data-image-placeholder class="flex flex-col items-center {{ $hasExistingImage ? 'hidden' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-10 w-10 text-slate-500 transition group-hover:text-blue-400">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9.75v4.5m2.25-2.25h-4.5" />
                    </svg>
                    <p class="mt-2 text-sm font-medium text-slate-300">Görsel yüklemek için tıklayın</p>
                    <p class="text-xs text-slate-500">JPG, PNG veya WebP · maksimum 2 MB</p>
                </div>

                <span data-image-overlay class="absolute inset-0 hidden items-center justify-center bg-slate-950/50 text-xs font-medium text-white opacity-0 transition group-hover:flex group-hover:opacity-100">
                    Değiştirmek için tıklayın
                </span>

                <input
                    id="image-input"
                    type="file"
                    name="image"
                    accept="image/*"
                    data-image-input
                    class="hidden"
                >
            </label>

            <p class="mt-2 text-xs text-slate-400">{{ $isEdit ? 'Boş bırakılırsa mevcut görsel korunur.' : '' }}</p>
            @error('image')
                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <div class="rounded-xl border border-slate-700 bg-slate-800 p-6 shadow-sm">
            <p class="mb-3 text-sm font-medium text-slate-200">Yayın durumu</p>

            <label class="flex cursor-pointer items-center gap-2">
                <input
                    type="checkbox"
                    name="is_published"
                    value="1"
                    @checked(old('is_published', $isEdit ? $post->is_published : false))
                    class="h-4 w-4 rounded border-slate-600 bg-slate-900 text-blue-600 focus:ring-blue-500"
                >
                <span class="text-sm text-slate-200">Yayınla / Zamanla</span>
            </label>
            <p class="mt-1 text-xs text-slate-400">İşaretlenmezse yazı "Taslak" olarak kaydedilir.</p>

            <div class="mt-4">
                <label for="published_at" class="mb-1 block text-sm font-medium text-slate-200">Yayın tarihi ve saati</label>
                <input
                    id="published_at"
                    type="datetime-local"
                    name="published_at"
                    value="{{ old('published_at', $isEdit && $post->published_at ? $post->published_at->format('Y-m-d\\TH:i') : '') }}"
                    class="block w-full rounded-lg border border-slate-600 bg-slate-900/60 px-3 py-2 text-sm text-slate-100 outline-none transition focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                >
                <p class="mt-1 text-xs text-slate-400">
                    İleri bir tarih seçerseniz yazı o zamana kadar ziyaretçilere görünmez. Boş bırakılırsa hemen yayınlanır.
                </p>
                @error('published_at')
                    <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="flex items-center gap-2">
            <button
                type="submit"
                class="flex-1 rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-medium text-white shadow-sm transition hover:bg-blue-500"
            >
                {{ $isEdit ? 'Güncelle' : 'Kaydet' }}
            </button>
            <a
                href="{{ route('admin.posts.index') }}"
                class="rounded-lg border border-slate-600 px-4 py-2.5 text-sm text-slate-300 transition hover:border-slate-500 hover:bg-slate-700 hover:text-white"
            >
                İptal
            </a>
        </div>
    </div>
</form>

<script>
    (function () {
        // Zengin metin editörü: contenteditable + document.execCommand, harici paket yok.
        const editor = document.querySelector('[data-editor-body]');
        const source = document.querySelector('[data-editor-source]');
        const toolbar = document.querySelector('[data-editor-toolbar]');
        const colorPicker = document.querySelector('[data-editor-color]');

        if (editor && source && toolbar) {
            const syncSource = () => {
                source.value = editor.innerHTML;
            };

            editor.addEventListener('input', syncSource);
            syncSource();

            toolbar.addEventListener('click', (event) => {
                const button = event.target.closest('[data-cmd]');
                if (!button) return;

                event.preventDefault();
                editor.focus();

                const cmd = button.dataset.cmd;
                let value = button.dataset.value ?? null;

                if (button.dataset.prompt) {
                    value = window.prompt(button.dataset.prompt, 'https://');
                    if (!value) return;
                }

                document.execCommand(cmd, false, value);
                syncSource();
            });

            if (colorPicker) {
                colorPicker.addEventListener('input', () => {
                    editor.focus();
                    document.execCommand('foreColor', false, colorPicker.value);
                    syncSource();
                });
            }

            editor.closest('form').addEventListener('submit', syncSource);
        }

        // Kapak görseli yükleme kutusu + canlı önizleme.
        const imageInput = document.querySelector('[data-image-input]');
        const imagePreview = document.querySelector('[data-image-preview]');
        const imagePlaceholder = document.querySelector('[data-image-placeholder]');

        if (imageInput && imagePreview) {
            imageInput.addEventListener('change', () => {
                const file = imageInput.files?.[0];
                if (!file) return;

                const reader = new FileReader();
                reader.onload = (e) => {
                    imagePreview.src = e.target.result;
                    imagePreview.classList.remove('hidden');
                    imagePlaceholder?.classList.add('hidden');
                };
                reader.readAsDataURL(file);
            });
        }
    })();
</script>
