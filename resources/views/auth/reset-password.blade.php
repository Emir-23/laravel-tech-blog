@extends('layouts.guest')

@section('title', 'Şifre Sıfırla')

@section('content')
    <h1 class="text-xl font-semibold tracking-tight text-slate-900">Yeni şifre belirle</h1>
    <p class="mt-1 text-sm text-slate-500">Hesabınız için yeni bir şifre oluşturun.</p>

    <form method="POST" action="{{ route('password.update') }}" class="mt-6 space-y-4">
        @csrf

        <input type="hidden" name="token" value="{{ $token }}">

        <div>
            <label for="email" class="mb-1 block text-sm font-medium text-slate-700">E-posta</label>
            <input
                id="email"
                type="email"
                name="email"
                value="{{ old('email', $email) }}"
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
            <label for="password" class="mb-1 block text-sm font-medium text-slate-700">Yeni şifre</label>
            <input
                id="password"
                type="password"
                name="password"
                required
                autocomplete="new-password"
                class="block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm shadow-sm outline-none focus:border-slate-900 focus:ring-1 focus:ring-slate-900"
            >
            <p class="mt-1 text-xs text-slate-400">En az 8 karakter.</p>
            @error('password')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="password_confirmation" class="mb-1 block text-sm font-medium text-slate-700">Yeni şifre (tekrar)</label>
            <input
                id="password_confirmation"
                type="password"
                name="password_confirmation"
                required
                autocomplete="new-password"
                class="block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm shadow-sm outline-none focus:border-slate-900 focus:ring-1 focus:ring-slate-900"
            >
        </div>

        <button
            type="submit"
            class="w-full rounded-lg bg-slate-900 px-4 py-2.5 text-sm font-medium text-white transition hover:bg-slate-800"
        >
            Şifreyi sıfırla
        </button>
    </form>
@endsection
