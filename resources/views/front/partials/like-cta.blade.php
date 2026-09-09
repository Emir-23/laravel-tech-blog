{{--
    Makale sonunda gösterilen büyük, şık beğeni Call-to-Action kutusu.
    Bekler: $post, $isLiked, $likesCount
--}}
<div class="mt-12 rounded-2xl border border-rose-400/20 bg-gradient-to-br from-rose-500/15 via-white/5 to-black/40 p-8 text-center shadow-lg shadow-black/30 backdrop-blur-md">
    <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-rose-500/20 text-rose-300 ring-1 ring-rose-400/30">
        <svg
            xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 24 24"
            stroke-width="1.5"
            stroke="currentColor"
            fill="{{ $isLiked ? 'currentColor' : 'none' }}"
            class="h-7 w-7 {{ $isLiked ? 'animate-heart-pop' : '' }}"
        >
            <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
        </svg>
    </div>

    <h3 class="mt-4 text-lg font-semibold text-white">
        {{ $isLiked ? 'Bu yazıyı beğendiniz!' : 'Bu yazıyı beğendiniz mi?' }}
    </h3>
    <p class="mx-auto mt-1 max-w-sm text-sm text-slate-300">
        <span class="font-semibold text-white">{{ $likesCount }}</span>
        kişi bu yazıyı beğendi. Siz de düşüncenizi bir kalp ile paylaşın.
    </p>

    <div class="mt-5">
        @auth
            <form method="POST" action="{{ route('post.like', $post->slug) }}">
                @csrf
                <button
                    type="submit"
                    class="inline-flex items-center gap-2 rounded-full px-6 py-3 text-sm font-semibold shadow-sm transition {{ $isLiked ? 'bg-rose-500 text-white hover:bg-rose-600' : 'border border-rose-400/40 bg-white/10 text-rose-300 hover:bg-rose-500/20' }}"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 24 24"
                        stroke-width="1.5"
                        stroke="currentColor"
                        fill="{{ $isLiked ? 'currentColor' : 'none' }}"
                        class="h-4 w-4"
                    >
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                    </svg>
                    {{ $isLiked ? 'Beğenmekten vazgeç' : 'Beğen' }}
                </button>
            </form>
        @else
            <a
                href="{{ route('login') }}"
                class="inline-flex items-center gap-2 rounded-full bg-rose-500 px-6 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-rose-600"
            >
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" class="h-4 w-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                </svg>
                Beğenmek için giriş yap
            </a>
        @endauth
    </div>
</div>
