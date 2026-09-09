<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Panel') — {{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-900 text-slate-200 antialiased">
    <div class="flex min-h-screen">
        <aside class="flex w-60 shrink-0 flex-col border-r border-slate-700 bg-slate-800 text-slate-200">
            <div class="border-b border-slate-700 px-5 py-4">
                <a href="{{ route('admin.dashboard') }}" class="text-sm font-semibold tracking-wide text-white">
                    {{ config('app.name') }}
                </a>
                <p class="mt-0.5 text-xs text-slate-400">Admin paneli</p>
            </div>

            <nav class="flex-1 space-y-1 px-3 py-4 text-sm">
                @php
                    $navBase = 'flex items-center gap-3 rounded-lg border-l-2 px-3 py-2 transition';
                    $navActive = 'border-blue-500 bg-blue-600/20 text-white shadow-inner';
                    $navInactive = 'border-transparent text-slate-300 hover:border-slate-600 hover:bg-slate-700/60 hover:text-white';
                @endphp

                <a
                    href="{{ route('admin.dashboard') }}"
                    class="{{ $navBase }} {{ request()->routeIs('admin.dashboard') ? $navActive : $navInactive }}"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5 shrink-0">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                    </svg>
                    Gösterge paneli
                </a>
                <a
                    href="{{ route('admin.categories.index') }}"
                    class="{{ $navBase }} {{ request()->routeIs('admin.categories.*') ? $navActive : $navInactive }}"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5 shrink-0">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6z" />
                    </svg>
                    Kategoriler
                </a>
                <a
                    href="{{ route('admin.posts.index') }}"
                    class="{{ $navBase }} {{ request()->routeIs('admin.posts.*') ? $navActive : $navInactive }}"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5 shrink-0">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                    </svg>
                    Yazılar
                </a>
                <a
                    href="{{ route('admin.settings.edit') }}"
                    class="{{ $navBase }} {{ request()->routeIs('admin.settings.*') ? $navActive : $navInactive }}"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5 shrink-0">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.174.1.331.246.46.433l.998.997c.404.404.412 1.06.018 1.473l-1.833 1.833a1.125 1.125 0 00-.288.84c.025.34.025.68 0 1.02a1.125 1.125 0 00.288.84l1.833 1.834c.394.413.386 1.069-.018 1.473l-.998.997a1.125 1.125 0 00-.46.433c-.332.184-.582.496-.645.87l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.063-.374-.313-.686-.645-.87a1.125 1.125 0 00-.46-.433l-.998-.997a1.05 1.05 0 01-.018-1.473l1.833-1.834a1.125 1.125 0 00.288-.84 6.55 6.55 0 010-1.02 1.125 1.125 0 00-.288-.84L5.48 9.04a1.05 1.05 0 01-.018-1.473l.998-.997c.13-.187.287-.333.46-.433.332-.184.582-.496.645-.87l.213-1.28z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    Site Ayarları
                </a>
            </nav>
        </aside>

        <div class="flex min-w-0 flex-1 flex-col bg-slate-900">
            <header class="flex h-14 items-center justify-between border-b border-slate-700 bg-slate-800 px-6">
                <h1 class="text-sm font-medium text-white">@yield('heading', 'Panel')</h1>

                <div class="flex items-center gap-4">
                    <a
                        href="{{ url('/') }}"
                        target="_blank"
                        rel="noopener"
                        class="inline-flex items-center gap-1.5 rounded-lg border border-slate-600 bg-slate-700/50 px-3 py-1.5 text-sm text-slate-200 transition hover:border-blue-500 hover:bg-blue-600/20 hover:text-white"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-4 w-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                        </svg>
                        Siteyi Görüntüle
                    </a>

                    <span class="text-sm text-slate-400">{{ auth()->user()->email }}</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button
                            type="submit"
                            class="rounded-lg border border-slate-600 bg-slate-700/50 px-3 py-1.5 text-sm text-slate-200 transition hover:border-slate-500 hover:bg-slate-700 hover:text-white"
                        >
                            Çıkış yap
                        </button>
                    </form>
                </div>
            </header>

            <main class="flex-1 p-6">
                @if (session('success'))
                    <div class="mb-4 rounded-lg border border-emerald-500/30 bg-emerald-500/15 px-4 py-3 text-sm text-emerald-300">
                        {{ session('success') }}
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    @stack('scripts')
</body>
</html>
