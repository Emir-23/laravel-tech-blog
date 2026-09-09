<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', config('app.name'))</title>
    <meta name="description" content="@yield('meta_description', 'Yazılım, teknoloji ve geliştirici kültürü üzerine yazılar.')">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="flex min-h-screen flex-col bg-gradient-to-b from-blue-100 via-blue-900 to-black text-slate-200 antialiased">
    @hasSection('reading_progress')
        @yield('reading_progress')
    @endif

    <header class="sticky top-0 z-30 border-b border-white/10 bg-slate-950/50 backdrop-blur-md">
        <div class="mx-auto flex max-w-5xl items-center justify-between gap-4 px-4 py-4 sm:px-6 lg:px-8">
            <a href="{{ url('/') }}" class="flex items-center gap-2 text-white">
                <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-white/10 text-sm font-bold text-white ring-1 ring-white/20">
                    {{ Str::of(config('app.name'))->substr(0, 1) }}
                </span>
                <span class="text-base font-semibold tracking-tight">
                    {{ config('app.name') }}
                </span>
            </a>

            <nav class="flex items-center gap-3 text-sm font-medium text-slate-300 sm:gap-5">
                <a href="{{ url('/') }}" class="transition hover:text-white">
                    Ana sayfa
                </a>

                @php
                    $socialLinks = $socialLinks ?? ['linkedin_url' => null, 'github_url' => null, 'twitter_url' => null];
                @endphp

                <div class="hidden items-center gap-2 sm:flex">
                    @if (! empty($socialLinks['linkedin_url']))
                        <a
                            href="{{ $socialLinks['linkedin_url'] }}"
                            target="_blank"
                            rel="noopener noreferrer"
                            title="LinkedIn"
                            class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-white/15 bg-white/5 text-lg text-slate-300 transition hover:border-blue-500/50 hover:bg-blue-500/10 hover:text-blue-500"
                        >
                            <i class="fa-brands fa-linkedin-in"></i>
                        </a>
                    @endif

                    @if (! empty($socialLinks['github_url']))
                        <a
                            href="{{ $socialLinks['github_url'] }}"
                            target="_blank"
                            rel="noopener noreferrer"
                            title="GitHub"
                            class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-white/15 bg-white/5 text-lg text-slate-300 transition hover:border-blue-500/50 hover:bg-blue-500/10 hover:text-blue-500"
                        >
                            <i class="fa-brands fa-github"></i>
                        </a>
                    @endif

                    @if (! empty($socialLinks['twitter_url']))
                        <a
                            href="{{ $socialLinks['twitter_url'] }}"
                            target="_blank"
                            rel="noopener noreferrer"
                            title="X (Twitter)"
                            class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-white/15 bg-white/5 text-lg text-slate-300 transition hover:border-blue-500/50 hover:bg-blue-500/10 hover:text-blue-500"
                        >
                            <i class="fa-brands fa-twitter"></i>
                        </a>
                    @endif
                </div>

                @auth
                    @if (auth()->user()->isAdmin())
                        <a
                            href="{{ route('admin.dashboard') }}"
                            class="inline-flex items-center gap-1.5 rounded-lg bg-white/10 px-3.5 py-2 text-sm font-medium text-white ring-1 ring-white/20 shadow-sm transition hover:bg-white/20"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-4 w-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                            </svg>
                            Yönetim Paneli
                        </a>
                    @else
                        <span class="hidden text-slate-400 lg:inline">
                            Merhaba, {{ auth()->user()->name }}
                        </span>
                        <a
                            href="{{ route('profile') }}"
                            class="inline-flex items-center gap-1.5 rounded-lg border border-white/15 bg-white/5 px-3.5 py-2 text-sm font-medium text-slate-200 transition hover:bg-white/10 hover:text-white"
                        >
                            Profilim
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button
                                type="submit"
                                class="inline-flex items-center gap-1.5 rounded-lg border border-white/15 bg-white/5 px-3.5 py-2 text-sm font-medium text-slate-200 transition hover:bg-white/10 hover:text-white"
                            >
                                Çıkış yap
                            </button>
                        </form>
                    @endif
                @else
                    <a
                        href="{{ route('login') }}"
                        class="inline-flex items-center gap-1.5 rounded-lg border border-white/15 bg-white/5 px-3.5 py-2 text-sm font-medium text-slate-200 transition hover:bg-white/10 hover:text-white"
                    >
                        Giriş Yap
                    </a>
                    <a
                        href="{{ route('register') }}"
                        class="inline-flex items-center gap-1.5 rounded-lg bg-white/15 px-3.5 py-2 text-sm font-medium text-white ring-1 ring-white/25 shadow-sm transition hover:bg-white/25"
                    >
                        Kayıt Ol
                    </a>
                @endauth
            </nav>
        </div>
    </header>

    <main class="flex-1">
        <div class="mx-auto w-full max-w-5xl px-4 py-10 sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-6 rounded-lg border border-emerald-400/30 bg-emerald-500/15 px-4 py-3 text-sm text-emerald-200 backdrop-blur-sm">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('status'))
                <div class="mb-6 rounded-lg border border-emerald-400/30 bg-emerald-500/15 px-4 py-3 text-sm text-emerald-200 backdrop-blur-sm">
                    {{ session('status') }}
                </div>
            @endif

            @yield('content')
        </div>
    </main>

    <footer class="border-t border-white/10 bg-black/40 backdrop-blur-sm">
        <div class="mx-auto flex max-w-5xl flex-col items-center gap-4 px-4 py-6 sm:flex-row sm:justify-between sm:px-6 lg:px-8">
            <p class="text-center text-sm text-slate-400 sm:text-left">
                &copy; {{ now()->year }} {{ config('app.name') }}. Tüm hakları saklıdır.
            </p>

            <div class="flex items-center gap-2">
                @if (! empty($socialLinks['linkedin_url']))
                    <a
                        href="{{ $socialLinks['linkedin_url'] }}"
                        target="_blank"
                        rel="noopener noreferrer"
                        title="LinkedIn"
                        class="inline-flex h-10 w-10 items-center justify-center rounded-lg border border-white/15 bg-white/5 text-lg text-slate-300 transition hover:border-blue-500/50 hover:bg-blue-500/10 hover:text-blue-500"
                    >
                        <i class="fa-brands fa-linkedin-in"></i>
                    </a>
                @endif
                @if (! empty($socialLinks['github_url']))
                    <a
                        href="{{ $socialLinks['github_url'] }}"
                        target="_blank"
                        rel="noopener noreferrer"
                        title="GitHub"
                        class="inline-flex h-10 w-10 items-center justify-center rounded-lg border border-white/15 bg-white/5 text-lg text-slate-300 transition hover:border-blue-500/50 hover:bg-blue-500/10 hover:text-blue-500"
                    >
                        <i class="fa-brands fa-github"></i>
                    </a>
                @endif
                @if (! empty($socialLinks['twitter_url']))
                    <a
                        href="{{ $socialLinks['twitter_url'] }}"
                        target="_blank"
                        rel="noopener noreferrer"
                        title="X (Twitter)"
                        class="inline-flex h-10 w-10 items-center justify-center rounded-lg border border-white/15 bg-white/5 text-lg text-slate-300 transition hover:border-blue-500/50 hover:bg-blue-500/10 hover:text-blue-500"
                    >
                        <i class="fa-brands fa-twitter"></i>
                    </a>
                @endif
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
