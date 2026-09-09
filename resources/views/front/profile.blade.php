@extends('layouts.app')

@section('title', 'Profilim — '.config('app.name'))

@section('content')
    <div class="mb-8 flex flex-col gap-6 rounded-xl border border-white/10 bg-white/10 p-6 shadow-lg shadow-black/20 backdrop-blur-md sm:flex-row sm:items-center sm:justify-between">
        <div class="flex items-center gap-4">
            <span class="flex h-14 w-14 items-center justify-center rounded-full bg-white/15 text-lg font-bold text-white ring-1 ring-white/20">
                {{ Str::of($user->name)->substr(0, 1)->upper() }}
            </span>
            <div>
                <h1 class="text-xl font-semibold text-white">{{ $user->name }}</h1>
                <p class="text-sm text-slate-300">{{ $user->email }}</p>
            </div>
        </div>

        <div class="flex flex-wrap items-center gap-3 text-sm text-slate-300">
            <span class="inline-flex items-center rounded-full bg-white/10 px-3 py-1 font-medium text-slate-200 ring-1 ring-white/10">
                Üyelik: {{ $user->created_at->format('d.m.Y') }}
            </span>
            <span class="inline-flex items-center rounded-full bg-emerald-500/20 px-3 py-1 font-medium text-emerald-300 ring-1 ring-emerald-400/20">
                {{ $likedPosts->total() }} beğenilen yazı
            </span>
        </div>
    </div>

    <div class="mb-6">
        <h2 class="text-lg font-semibold text-white">Beğendiğim Yazılar</h2>
        <p class="mt-1 text-sm text-slate-300">Beğendiğiniz tüm içerikleri burada bulabilirsiniz.</p>
    </div>

    @if ($likedPosts->isEmpty())
        <div class="rounded-xl border border-dashed border-white/20 bg-white/5 py-16 text-center text-slate-400 backdrop-blur-md">
            Henüz beğendiğiniz bir yazı yok.
            <div class="mt-3">
                <a href="{{ route('home') }}" class="text-sm font-medium text-slate-300 hover:text-white">
                    Yazılara göz atın &rarr;
                </a>
            </div>
        </div>
    @else
        <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
            @foreach ($likedPosts as $post)
                <article class="group flex flex-col overflow-hidden rounded-xl border border-white/10 bg-white/10 shadow-lg shadow-black/20 backdrop-blur-md transition hover:border-white/20 hover:bg-white/15">
                    <a href="{{ route('post', $post->slug) }}" class="block overflow-hidden">
                        @if ($post->image)
                            <img
                                src="{{ Storage::url($post->image) }}"
                                alt="{{ $post->title }}"
                                class="h-40 w-full object-cover transition duration-300 group-hover:scale-105"
                            >
                        @else
                            <div class="flex h-40 w-full items-center justify-center bg-black/30 text-slate-400">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-8 w-8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5z" />
                                </svg>
                            </div>
                        @endif
                    </a>

                    <div class="flex flex-1 flex-col p-4">
                        <div class="mb-2 flex flex-wrap items-center gap-1.5">
                            @foreach ($post->categories as $postCategory)
                                <span class="inline-flex items-center rounded-full bg-white/10 px-2.5 py-1 text-xs font-medium text-slate-200 ring-1 ring-white/10">
                                    {{ $postCategory->name }}
                                </span>
                            @endforeach
                        </div>

                        <h3 class="line-clamp-2 text-base font-semibold text-white">
                            <a href="{{ route('post', $post->slug) }}" class="transition hover:text-slate-300">
                                {{ $post->title }}
                            </a>
                        </h3>

                        <div class="mt-auto flex items-center justify-between pt-4">
                            <a
                                href="{{ route('post', $post->slug) }}"
                                class="inline-flex items-center gap-1 text-sm font-medium text-slate-200 transition-all hover:gap-2 hover:text-white"
                            >
                                Devamını oku
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-4 w-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 8.25L21 12m0 0l-3.75 3.75M21 12H3" />
                                </svg>
                            </a>

                            <form method="POST" action="{{ route('post.like', $post->slug) }}">
                                @csrf
                                <button
                                    type="submit"
                                    title="Beğenmekten vazgeç"
                                    class="inline-flex items-center text-rose-400 transition hover:text-rose-300"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-5 w-5">
                                        <path d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>

        <div class="mt-10">
            {{ $likedPosts->links() }}
        </div>
    @endif
@endsection
