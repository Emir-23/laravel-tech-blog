@extends('layouts.admin')

@section('title', 'Kategoriler')
@section('heading', 'Kategoriler')

@section('content')
    <div class="mb-4 flex items-center justify-end">
        <a
            href="{{ route('admin.categories.create') }}"
            class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white shadow-sm transition hover:bg-blue-500"
        >
            Yeni kategori
        </a>
    </div>

    <div class="overflow-hidden rounded-xl border border-slate-700 bg-slate-800 shadow-sm">
        <table class="min-w-full divide-y divide-slate-700 text-sm">
            <thead class="bg-slate-800/80 text-left text-slate-400">
                <tr>
                    <th class="px-4 py-3 font-medium">Ad</th>
                    <th class="px-4 py-3 font-medium">Slug</th>
                    <th class="px-4 py-3 font-medium">Yazı</th>
                    <th class="px-4 py-3 font-medium">Tarih</th>
                    <th class="px-4 py-3 text-right font-medium">İşlemler</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-700">
                @forelse ($categories as $category)
                    <tr class="transition hover:bg-slate-700/40">
                        <td class="px-4 py-3 font-medium text-white">{{ $category->name }}</td>
                        <td class="px-4 py-3 text-slate-400">{{ $category->slug }}</td>
                        <td class="px-4 py-3 text-slate-400">
                            <span class="inline-flex items-center rounded-full bg-blue-600/20 px-2.5 py-1 text-xs font-medium text-blue-300 ring-1 ring-blue-500/30">
                                {{ $category->posts_count }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-slate-400">{{ $category->created_at->format('d.m.Y') }}</td>
                        <td class="px-4 py-3">
                            <div class="flex justify-end gap-2">
                                <a
                                    href="{{ route('admin.categories.edit', $category) }}"
                                    class="rounded-lg px-3 py-1.5 text-xs font-medium text-slate-300 transition hover:bg-slate-700 hover:text-white"
                                >
                                    Düzenle
                                </a>
                                <form
                                    method="POST"
                                    action="{{ route('admin.categories.destroy', $category) }}"
                                    onsubmit="return confirm('Bu kategori silinecek. Bağlı olduğu yazılardan kategori bağlantısı kaldırılır (yazılar silinmez). Devam edilsin mi?')"
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
                        <td colspan="5" class="px-4 py-10 text-center text-slate-400">
                            Henüz kategori yok.
                            <a href="{{ route('admin.categories.create') }}" class="text-blue-400 underline hover:text-blue-300">İlk kategoriyi ekle</a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if ($categories->hasPages())
        <div class="mt-4">
            {{ $categories->links() }}
        </div>
    @endif
@endsection
