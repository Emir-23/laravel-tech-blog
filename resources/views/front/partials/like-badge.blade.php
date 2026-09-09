{{--
    Kompakt beğeni rozeti: başlığın altında, tarih/kategori ile birlikte gösterilir.
    Bekler: $post, $isLiked, $likesCount
--}}
@auth
    <form method="POST" action="{{ route('post.like', $post->slug) }}" class="inline-flex">
        @csrf
        <button
            type="submit"
            title="{{ $isLiked ? 'Beğenmekten vazgeç' : 'Beğen' }}"
            class="group inline-flex items-center gap-1.5 rounded-full border px-3 py-1 text-xs font-medium transition {{ $isLiked ? 'border-rose-400/40 bg-rose-500/20 text-rose-300' : 'border-white/15 bg-white/5 text-slate-300 hover:border-rose-400/40 hover:bg-rose-500/15 hover:text-rose-300' }}"
        >
            <svg
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 24 24"
                stroke-width="1.5"
                stroke="currentColor"
                fill="{{ $isLiked ? 'currentColor' : 'none' }}"
                class="h-3.5 w-3.5 transition group-hover:scale-110 {{ $isLiked ? 'animate-heart-pop' : '' }}"
            >
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
            </svg>
            <span>{{ $likesCount }}</span>
        </button>
    </form>
@else
    <a
        href="{{ route('login') }}"
        title="Beğenmek için giriş yap"
        class="group inline-flex items-center gap-1.5 rounded-full border border-white/15 bg-white/5 px-3 py-1 text-xs font-medium text-slate-300 transition hover:border-rose-400/40 hover:bg-rose-500/15 hover:text-rose-300"
    >
        <svg
            xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 24 24"
            stroke-width="1.5"
            stroke="currentColor"
            fill="none"
            class="h-3.5 w-3.5 transition group-hover:scale-110"
        >
            <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
        </svg>
        <span>{{ $likesCount }}</span>
    </a>
@endauth
