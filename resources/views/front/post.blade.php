@extends('layouts.app')

@section('title', $post->title.' — '.config('app.name'))
@section('meta_description', Str::limit(trim(strip_tags($post->content)), 160))

@section('reading_progress')
    <div
        id="reading-progress"
        class="fixed left-0 top-0 z-50 h-1 w-0 bg-gradient-to-r from-blue-500 via-cyan-400 to-blue-400 shadow-[0_0_12px_rgba(34,211,238,0.65)] transition-[width] duration-75"
        role="progressbar"
        aria-valuemin="0"
        aria-valuemax="100"
        aria-valuenow="0"
        aria-label="Okuma ilerlemesi"
    ></div>
@endsection

@section('content')
    <div class="relative lg:grid lg:grid-cols-[minmax(0,1fr)_14rem] lg:gap-10">
        <article class="mx-auto max-w-3xl lg:mx-0" data-article>
            @if ($post->image)
                <div class="mb-8 overflow-hidden rounded-2xl shadow-md">
                    <img
                        src="{{ Storage::url($post->image) }}"
                        alt="{{ $post->title }}"
                        class="h-72 w-full object-cover sm:h-96"
                    >
                </div>
            @endif

            <header class="mb-8">
                <div class="flex flex-wrap items-center gap-3 text-sm text-slate-300">
                    <div class="flex flex-wrap items-center gap-1.5">
                        @foreach ($post->categories as $postCategory)
                            <a
                                href="{{ route('category', $postCategory->slug) }}"
                                class="inline-flex items-center rounded-full bg-white/10 px-2.5 py-1 text-xs font-medium text-slate-200 ring-1 ring-white/10 transition hover:bg-white/20 hover:text-white"
                            >
                                {{ $postCategory->name }}
                            </a>
                        @endforeach
                    </div>
                    <span aria-hidden="true">&middot;</span>
                    <time datetime="{{ ($post->published_at ?? $post->created_at)->toIso8601String() }}">
                        {{ ($post->published_at ?? $post->created_at)->format('d.m.Y') }}
                    </time>
                    <span aria-hidden="true">&middot;</span>
                    <span class="inline-flex items-center gap-1 text-slate-400">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" class="h-3.5 w-3.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        {{ $post->views_count }} görüntülenme
                    </span>
                    <span aria-hidden="true">&middot;</span>
                    @include('front.partials.like-badge')
                </div>

                <h1 class="mt-3 text-3xl font-bold tracking-tight text-white sm:text-4xl">
                    {{ $post->title }}
                </h1>
            </header>

            <div class="prose-content" data-post-content>
                {!! $post->content !!}
            </div>

            @include('front.partials.like-cta')

            <div class="mt-6 border-t border-white/10 pt-6">
                <a
                    href="{{ route('home') }}"
                    class="inline-flex items-center gap-1 text-sm font-medium text-slate-300 transition hover:text-white"
                >
                    &larr; Tüm yazılara dön
                </a>
            </div>
        </article>

        <aside class="mt-10 hidden lg:block">
            <div class="sticky top-24 rounded-xl border border-white/10 bg-white/5 p-4 backdrop-blur-md" data-toc-wrap>
                <p class="mb-3 text-xs font-semibold uppercase tracking-wide text-cyan-300">İçindekiler</p>
                <nav data-toc class="space-y-1 text-sm text-slate-400">
                    <p class="text-xs text-slate-500" data-toc-empty>Bu yazıda başlık bulunamadı.</p>
                </nav>
            </div>
        </aside>
    </div>
@endsection

@push('scripts')
<script>
    (function () {
        const progress = document.getElementById('reading-progress');
        const article = document.querySelector('[data-article]');
        const content = document.querySelector('[data-post-content]');
        const toc = document.querySelector('[data-toc]');
        const tocEmpty = document.querySelector('[data-toc-empty]');

        if (progress && article) {
            const updateProgress = () => {
                const rect = article.getBoundingClientRect();
                const total = article.offsetHeight - window.innerHeight;
                const scrolled = Math.min(Math.max(-rect.top, 0), Math.max(total, 1));
                const pct = total > 0 ? (scrolled / total) * 100 : (window.scrollY > 0 ? 100 : 0);
                progress.style.width = pct + '%';
                progress.setAttribute('aria-valuenow', String(Math.round(pct)));
            };

            window.addEventListener('scroll', updateProgress, { passive: true });
            window.addEventListener('resize', updateProgress);
            updateProgress();
        }

        if (!content || !toc) return;

        const headings = content.querySelectorAll('h2, h3');
        if (!headings.length) return;

        tocEmpty?.remove();

        headings.forEach((heading, index) => {
            if (!heading.id) {
                heading.id = 'section-' + (index + 1);
            }

            const link = document.createElement('a');
            link.href = '#' + heading.id;
            link.textContent = heading.textContent.trim();
            link.className = heading.tagName === 'H3'
                ? 'block rounded-md py-1 pl-3 text-xs text-slate-400 transition hover:bg-white/5 hover:text-cyan-300'
                : 'block rounded-md py-1.5 text-sm text-slate-300 transition hover:bg-white/5 hover:text-cyan-300';

            toc.appendChild(link);
        });
    })();
</script>
@endpush
