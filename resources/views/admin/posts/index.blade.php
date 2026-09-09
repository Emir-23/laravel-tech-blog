@extends('layouts.admin')

@section('title', 'Yazılar')
@section('heading', 'Yazılar')

@section('content')
    <div class="mb-4 flex items-center justify-end">
        <a
            href="{{ route('admin.posts.create') }}"
            class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white shadow-sm transition hover:bg-blue-500"
        >
            Yeni yazı
        </a>
    </div>

    <div class="overflow-hidden rounded-xl border border-slate-700 bg-slate-800 shadow-sm">
        <table class="min-w-full divide-y divide-slate-700 text-sm">
            <thead class="bg-slate-800/80 text-left text-slate-400">
                <tr>
                    <th class="px-4 py-3 font-medium">Kapak</th>
                    <th class="px-4 py-3 font-medium">Başlık</th>
                    <th class="px-4 py-3 font-medium">Kategori</th>
                    <th class="px-4 py-3 font-medium">Durum</th>
                    <th class="px-4 py-3 font-medium">Görüntülenme</th>
                    <th class="px-4 py-3 font-medium">Beğeni Sayısı</th>
                    <th class="px-4 py-3 font-medium">Tarih</th>
                    <th class="px-4 py-3 text-right font-medium">İşlemler</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-700">
                @forelse ($posts as $post)
                    <tr class="transition hover:bg-slate-700/40">
                        <td class="px-4 py-3">
                            @if ($post->image)
                                <img
                                    src="{{ Storage::url($post->image) }}"
                                    alt="{{ $post->title }}"
                                    class="h-16 w-16 rounded-md object-cover ring-1 ring-slate-600"
                                >
                            @else
                                <div class="h-16 w-16 rounded-md bg-slate-700 ring-1 ring-slate-600"></div>
                            @endif
                        </td>
                        <td class="px-4 py-3 font-medium text-white">
                            {{ $post->title }}
                            <div class="text-xs text-slate-400">{{ $post->slug }}</div>
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex flex-wrap gap-1">
                                @foreach ($post->categories as $category)
                                    <span class="inline-flex items-center rounded-full bg-blue-600/20 px-2.5 py-1 text-xs font-medium text-blue-300 ring-1 ring-blue-500/30">
                                        {{ $category->name }}
                                    </span>
                                @endforeach
                            </div>
                        </td>
                        <td class="px-4 py-3">
                            @if (! $post->is_published)
                                <span class="inline-flex items-center rounded-full bg-amber-500/20 px-2.5 py-1 text-xs font-medium text-amber-300 ring-1 ring-amber-500/30">
                                    Taslak
                                </span>
                            @elseif ($post->isScheduled())
                                <span class="inline-flex items-center rounded-full bg-cyan-500/20 px-2.5 py-1 text-xs font-medium text-cyan-300 ring-1 ring-cyan-500/30">
                                    Zamanlandı
                                    @if ($post->published_at)
                                        <span class="ml-1 opacity-80">{{ $post->published_at->format('d.m H:i') }}</span>
                                    @endif
                                </span>
                            @else
                                <span class="inline-flex items-center rounded-full bg-emerald-500/20 px-2.5 py-1 text-xs font-medium text-emerald-300 ring-1 ring-emerald-500/30">
                                    Yayında
                                </span>
                            @endif
                        </td>
                        <td class="px-4 py-3">
                            <span class="inline-flex items-center gap-1 rounded-full bg-blue-600/20 px-2.5 py-1 text-xs font-medium text-blue-300 ring-1 ring-blue-500/30">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" class="h-3.5 w-3.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                {{ $post->views_count }}
                            </span>
                        </td>
                        <td class="px-4 py-3">
                            <span class="inline-flex items-center gap-1 rounded-full bg-rose-500/20 px-2.5 py-1 text-xs font-medium text-rose-300 ring-1 ring-rose-500/30">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-3.5 w-3.5">
                                    <path d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                                </svg>
                                {{ $post->likes_count }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-slate-400">{{ $post->created_at->format('d.m.Y') }}</td>
                        <td class="px-4 py-3">
                            <div class="flex justify-end gap-2">
                                <a
                                    href="{{ route('admin.posts.edit', $post) }}"
                                    class="rounded-lg px-3 py-1.5 text-xs font-medium text-slate-300 transition hover:bg-slate-700 hover:text-white"
                                >
                                    Düzenle
                                </a>
                                <form
                                    method="POST"
                                    action="{{ route('admin.posts.destroy', $post) }}"
                                    onsubmit="return confirm('Bu yazı silinecek. Devam edilsin mi?')"
                                >
                                    @csrf
                                    @method('DELETE')
                                    <button
                                        type="submit"
                                        class="rounded-lg px-3 py-1.5 text-xs font-medium text-red-400 transition hover:bg-red-500/15 hover:text-red-300"
                                    >
                                        Sil
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="px-4 py-10 text-center text-slate-400">
                            Henüz yazı yok.
                            <a href="{{ route('admin.posts.create') }}" class="text-blue-400 underline hover:text-blue-300">İlk yazıyı ekle</a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if ($posts->hasPages())
        <div class="mt-4">
            {{ $posts->links() }}
        </div>
    @endif
@endsection
