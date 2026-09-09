@extends('layouts.guest')

@section('title', 'Kayıt Ol')

@section('content')
    <h1 class="text-xl font-semibold tracking-tight text-slate-900">Hesap oluştur</h1>
    <p class="mt-1 text-sm text-slate-500">Yeni bir okuyucu hesabı oluşturun.</p>

    <form method="POST" action="{{ route('register.store') }}" class="mt-6 space-y-4">
        @csrf

        <div>
            <label for="name" class="mb-1 block text-sm font-medium text-slate-700">Ad Soyad</label>
            <input
                id="name"
                type="text"
                name="name"
                value="{{ old('name') }}"
                required
                autofocus
                autocomplete="name"
                maxlength="255"
                class="block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm shadow-sm outline-none focus:border-slate-900 focus:ring-1 focus:ring-slate-900"
            >
            @error('name')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="email" class="mb-1 block text-sm font-medium text-slate-700">E-posta</label>
            <input
                id="email"
                type="email"
                name="email"
                value="{{ old('email') }}"
                required
                autocomplete="email"
                class="block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm shadow-sm outline-none focus:border-slate-900 focus:ring-1 focus:ring-slate-900"
            >
            @error('email')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="password" class="mb-1 block text-sm font-medium text-slate-700">Şifre</label>
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
            <label for="password_confirmation" class="mb-1 block text-sm font-medium text-slate-700">Şifre (tekrar)</label>
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
            Kayıt ol
        </button>
    </form>

    <p class="mt-6 text-center text-sm text-slate-500">
        Zaten hesabınız var mı?
        <a href="{{ route('login') }}" class="font-medium text-slate-900 underline">Giriş yapın</a>
    </p>
@endsection
