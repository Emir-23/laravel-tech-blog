@extends('layouts.admin')

@section('title', 'Site Ayarları')
@section('heading', 'Site Ayarları')

@section('content')
    <div class="max-w-xl rounded-xl border border-slate-700 bg-slate-800 p-6 shadow-sm">
        <p class="mb-6 text-sm text-slate-400">
            Profesyonel sosyal bağlantılarınızı buradan yönetin. Boş bırakılan alanlar ön yüzde gösterilmez.
        </p>

        <form method="POST" action="{{ route('admin.settings.update') }}" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label for="linkedin_url" class="mb-1 block text-sm font-medium text-slate-200">LinkedIn URL</label>
                <input
                    id="linkedin_url"
                    type="url"
                    name="linkedin_url"
                    value="{{ old('linkedin_url', $settings['linkedin_url']) }}"
                    placeholder="https://linkedin.com/in/..."
                    class="block w-full rounded-lg border border-slate-600 bg-slate-900/60 px-3 py-2 text-sm text-slate-100 outline-none transition focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                >
                @error('linkedin_url')
                    <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="github_url" class="mb-1 block text-sm font-medium text-slate-200">GitHub URL</label>
                <input
                    id="github_url"
                    type="url"
                    name="github_url"
                    value="{{ old('github_url', $settings['github_url']) }}"
                    placeholder="https://github.com/..."
                    class="block w-full rounded-lg border border-slate-600 bg-slate-900/60 px-3 py-2 text-sm text-slate-100 outline-none transition focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                >
                @error('github_url')
                    <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="twitter_url" class="mb-1 block text-sm font-medium text-slate-200">X (Twitter) URL</label>
                <input
                    id="twitter_url"
                    type="url"
                    name="twitter_url"
                    value="{{ old('twitter_url', $settings['twitter_url']) }}"
                    placeholder="https://x.com/..."
                    class="block w-full rounded-lg border border-slate-600 bg-slate-900/60 px-3 py-2 text-sm text-slate-100 outline-none transition focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                >
                @error('twitter_url')
                    <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <button
                type="submit"
                class="rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-medium text-white shadow-sm transition hover:bg-blue-500"
            >
                Kaydet
            </button>
        </form>
    </div>
@endsection
