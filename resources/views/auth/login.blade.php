@extends('layouts.guest')

@section('title', 'Giriş Yap')

@section('content')
    <h1 class="text-xl font-semibold tracking-tight text-slate-900">Giriş yap</h1>
    <p class="mt-1 text-sm text-slate-500">Hesabınıza erişmek için bilgilerinizi girin.</p>

    @if (session('status'))
        <div class="mt-4 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login.store') }}" class="mt-6 space-y-4">
        @csrf

        <div>
            <label for="email" class="mb-1 block text-sm font-medium text-slate-700">E-posta</label>
            <input
                id="email"
                type="email"
                name="email"
                value="{{ old('email') }}"
                required
                autofocus
                autocomplete="email"
                class="block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm shadow-sm outline-none focus:border-slate-900 focus:ring-1 focus:ring-slate-900"
            >
            @error('email')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <div class="flex items-center justify-between">
                <label for="password" class="mb-1 block text-sm font-medium text-slate-700">Şifre</label>
                <a href="{{ route('password.request') }}" class="text-xs font-medium text-slate-500 transition hover:text-slate-900">
                    Şifremi unuttum
                </a>
            </div>
            <input
                id="password"
                type="password"
                name="password"
                required
                autocomplete="current-password"
                class="block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm shadow-sm outline-none focus:border-slate-900 focus:ring-1 focus:ring-slate-900"
            >
            @error('password')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <button
            type="submit"
            class="w-full rounded-lg bg-slate-900 px-4 py-2.5 text-sm font-medium text-white transition hover:bg-slate-800"
        >
            Giriş yap
        </button>
    </form>

    <p class="mt-6 text-center text-sm text-slate-500">
        Hesabınız yok mu?
        <a href="{{ route('register') }}" class="font-medium text-slate-900 underline">Kayıt olun</a>
    </p>
@endsection
