<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', config('app.name')) — {{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-100 text-slate-800 antialiased">
    <div class="flex min-h-screen flex-col items-center justify-center px-4 py-12">
        <a href="{{ url('/') }}" class="mb-6 flex items-center gap-2 text-slate-900">
            <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-slate-900 text-sm font-bold text-white">
                {{ Str::of(config('app.name'))->substr(0, 1) }}
            </span>
            <span class="text-base font-semibold tracking-tight">
                {{ config('app.name') }}
            </span>
        </a>

        <div class="w-full max-w-md rounded-xl border border-slate-200 bg-white p-8 shadow-sm">
            @yield('content')
        </div>
    </div>
</body>
</html>
