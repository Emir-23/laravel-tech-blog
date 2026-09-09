@extends('layouts.app')

@section('title', isset($category) ? 'Kategori: '.$category->name.' — '.config('app.name') : config('app.name'))

@section('content')
    @unless (isset($category))
        {{-- Dark/Cyber Hero: 16:9 görsel + alt siyah fade-out --}}
        <section class="relative mb-10 overflow-hidden rounded-2xl shadow-2xl shadow-black/40">
            <div class="relative aspect-[16/9] w-full min-h-[280px] sm:min-h-[360px]">
                <img
                    src="{{ asset('images/hero-cyber.png') }}"
                    alt="{{ config('app.name') }} — teknoloji, yazılım ve gelecek"
                    class="absolute inset-0 h-full w-full object-cover"
                >

                {{-- Üst koyuluk: metin okunabilirliği --}}
                <div class="pointer-events-none absolute inset-0 bg-gradient-to-t from-black via-black/55 to-black/20"></div>

                {{-- Alt siyah maske: site arka planıyla pürüzsüz birleşme --}}
                <div class="pointer-events-none absolute inset-x-0 bottom-0 h-1/2 bg-gradient-to-t from-black via-black/70 to-transparent"></div>

                <div class="absolute inset-0 flex items-end">
                    <div class="relative z-10 w-full max-w-2xl px-6 pb-10 sm:px-12 sm:pb-14">
                        <span class="inline-flex items-center rounded-full border border-white/15 bg-white/10 px-3 py-1 text-xs font-medium text-slate-200 backdrop-blur-sm">
                            {{ config('app.name') }}'e hoş geldiniz
                        </span>
                        <h1 class="mt-4 text-3xl font-bold tracking-tight text-white sm:text-4xl lg:text-5xl">
                            Teknoloji, Yazılım ve Gelecek
                        </h1>
                        <p class="mt-4 text-base leading-relaxed text-slate-300 sm:text-lg">
                            Yazılım geliştirme, yapay zeka ve teknoloji dünyasındaki en güncel konuları
                            ele alan yazılarla bilginizi tazeleyin. Her hafta yeni içerikler.
                        </p>
                    </div>
                </div>
            </div>
        </section>
    @endunless

    @if (isset($category))
        <div class="mb-6 flex flex-wrap items-center justify-between gap-3 rounded-xl border border-white/10 bg-white/10 px-5 py-4 shadow-sm backdrop-blur-md">
            <div>
                <p class="text-xs font-medium uppercase tracking-wide text-slate-400">Kategori</p>
                <h1 class="text-xl font-semibold text-white">{{ $category->name }}</h1>
            </div>
            <a
                href="{{ route('home') }}"
                class="text-sm font-medium text-slate-300 transition hover:text-white"
            >
                &larr; Tüm yazılar
            </a>
        </div>
    @else
        <div class="mb-6">
            <h1 class="text-2xl font-bold tracking-tight text-white">Son yazılar</h1>
            <p class="mt-1 text-slate-300">En güncel içerikleri keşfedin.</p>
        </div>
    @endif

    {{-- Filtre formu: kategori + tarih aralığı --}}
    <form
        method="GET"
        action="{{ route('home') }}"
        class="mb-8 space-y-4 rounded-xl border border-white/10 bg-white/10 p-4 backdrop-blur-md"
    >
        {{-- Kategori chip'leri: tıklanınca gizli input'a yazıp formu göndeririz (JS yok, her chip bir link) --}}
        @if (isset($categories) && $categories->isNotEmpty())
            <div class="flex flex-wrap gap-2">
                <a
                    href="{{ route('home', array_filter(['from' => $from ?? request('from'), 'to' => $to ?? request('to')])) }}"
                    class="inline-flex items-center rounded-full border px-3.5 py-1.5 text-xs font-medium backdrop-blur-md transition {{ empty($category) ? 'border-cyan-400/50 bg-cyan-500/20 text-cyan-200' : 'border-white/10 bg-white/10 text-slate-300 hover:border-white/20 hover:bg-white/15 hover:text-white' }}"
                >
                    Tümü
                </a>

                @foreach ($categories as $filterCategory)
                    <a
                        href="{{ route('home', array_filter([
                        'category' => $filterCategory->slug,
                        'from' => $from ?? request('from'),
                        'to' => $to ?? request('to'),
                        'sort' => $sort ?? request('sort'),
                    ])) }}"
                        class="inline-flex items-center rounded-full border px-3.5 py-1.5 text-xs font-medium backdrop-blur-md transition {{ isset($category) && $category->id === $filterCategory->id ? 'border-cyan-400/50 bg-cyan-500/20 text-cyan-200' : 'border-white/10 bg-white/10 text-slate-300 hover:border-white/20 hover:bg-white/15 hover:text-white' }}"
                    >
                        {{ $filterCategory->name }}
                    </a>
                @endforeach
            </div>
        @endif

        {{-- Tarih alanları --}}
        <div>
            <label for="sort" class="mb-1 block text-xs font-medium text-slate-300">Sıralama</label>
            <select
                id="sort"
                name="sort"
                onchange="this.form.submit()"
                class="rounded-lg border border-white/15 bg-black/30 px-3 py-2 text-sm text-slate-100 outline-none focus:border-cyan-400/50"
            >
                <option value="newest" @selected(($sort ?? request('sort', 'newest')) === 'newest')>
                    En Yeni Yayınlananlar
                </option>
                <option value="popular" @selected(($sort ?? request('sort')) === 'popular')>
                    En Çok Okunanlar
                </option>
                <option value="liked" @selected(($sort ?? request('sort')) === 'liked')>
                    En Çok Beğenilenler
                </option>
            </select>
        </div>

            <div>
                <label for="to" class="mb-1 block text-xs font-medium text-slate-300">Bitiş</label>
                <input
                    id="to"
                    type="date"
                    name="to"
                    value="{{ $to ?? request('to') }}"
                    class="rounded-lg border border-white/15 bg-black/30 px-3 py-2 text-sm text-slate-100 outline-none focus:border-cyan-400/50"
                >
            </div>

            {{-- Kategori chip ile seçildiyse tarihi uygularken kategoriyi de gönder --}}
            @if (! empty($category))
                <input type="hidden" name="category" value="{{ $category->slug }}">
            @endif

            <button
                type="submit"
                class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white transition hover:bg-blue-500"
            >
                Filtrele
            </button>

            <a
                href="{{ route('home') }}"
                class="rounded-lg border border-white/15 px-4 py-2 text-sm text-slate-300 transition hover:bg-white/10 hover:text-white"
            >
                Temizle
            </a>
        </div>
    </form>

    @if ($posts->isEmpty())
        <div class="rounded-xl border border-dashed border-white/20 bg-white/5 py-16 text-center text-slate-400 backdrop-blur-md">
            Henüz yazı eklenmemiş.
        </div>
    @else
        <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
            @foreach ($posts as $post)
                <article class="group flex flex-col overflow-hidden rounded-xl border border-white/10 bg-white/10 shadow-lg shadow-black/20 backdrop-blur-md transition hover:border-white/20 hover:bg-white/15 hover:shadow-xl hover:shadow-black/30">
                    <a href="{{ route('post', $post->slug) }}" class="block overflow-hidden">
                        @if ($post->image)
                            <img
                                src="{{ Storage::url($post->image) }}"
                                alt="{{ $post->title }}"
                                class="h-48 w-full rounded-t-xl object-cover transition duration-300 group-hover:scale-105"
                            >
                        @else
                            <div class="flex h-48 w-full flex-col items-center justify-center gap-2 rounded-t-xl bg-black/30 text-slate-400">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-10 w-10">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5z" />
                                </svg>
                                <span class="text-xs font-medium">Görsel yok</span>
                            </div>
                        @endif
                    </a>

                    <div class="flex flex-1 flex-col p-5">
                        <div class="mb-2 flex flex-wrap items-center gap-1.5">
                            @foreach ($post->categories as $postCategory)
                                <a
                                    href="{{ route('category', $postCategory->slug) }}"
                                    class="inline-flex items-center rounded-full bg-white/10 px-2.5 py-1 text-xs font-medium text-slate-200 ring-1 ring-white/10 transition hover:bg-white/20 hover:text-white"
                                >
                                    {{ $postCategory->name }}
                                </a>
                            @endforeach
                        </div>

                        <h2 class="line-clamp-2 text-lg font-semibold text-white">
                            <a href="{{ route('post', $post->slug) }}" class="transition hover:text-slate-300">
                                {{ $post->title }}
                            </a>
                        </h2>

                        <a
                            href="{{ route('post', $post->slug) }}"
                            class="mt-4 inline-flex items-center gap-1 text-sm font-medium text-slate-200 transition-all hover:gap-2 hover:text-white"
                        >
                            Devamını oku
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-4 w-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 8.25L21 12m0 0l-3.75 3.75M21 12H3" />
                            </svg>
                        </a>
                    </div>
                </article>
            @endforeach
        </div>

        <div class="mt-10">
            {{ $posts->links() }}
        </div>
    @endif
@endsection
