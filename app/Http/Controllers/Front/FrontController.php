<?php

namespace App\Http\Controllers\Front;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use Illuminate\View\View;

class FrontController extends Controller
{
    public function index(Request $request): View
    {
        $categories = Category::query()->orderBy('name')->get();

        // Formdan gelen filtreler (yoksa null)
        $categorySlug = $request->query('category');
        $from = $request->query('from');
        $to = $request->query('to');
        $sort = $request->query('sort', 'newest');

        $posts = Post::query()
            ->with('categories')
            ->live(); // sadece yayınlanmış ileri tarihli yazılar sızmasın

        // Kategori seçildiyse: o kategoriye bağlı yazılar
        if ($categorySlug) {
            $posts->whereHas('categories', function ($query) use ($categorySlug) {
                $query->where('categories.slug', $categorySlug);
            });
        }

        // Başlangıç tarihi: published_at >= from
        if ($from) {
            $posts->whereDate('published_at', '>=', $from);
        }

        // Bitiş tarihi: published_at <= to
        if ($to) {
            $posts->whereDate('published_at', '<=', $to);
        }

        $posts = $posts
            // Beğeni sıralaması için likes_count üretir (sadece liked seçilince yeterli,
            // ama her zaman eklemek de zararsızdır)
            ->withCount('likes')
            ->when($sort === 'popular', function ($query) {
                // En çok okunanlar
                $query->orderByDesc('views_count');
            })
            ->when($sort === 'liked', function ($query) {
                // En çok beğenilenler (withCount('likes') → likes_count)
                $query->orderByDesc('likes_count');
            })
            ->when($sort === 'newest' || ! in_array($sort, ['popular', 'liked'], true), function ($query) {
                // Varsayılan / bilinmeyen değer: en yeni yayın
                $query->latest('published_at');
            })
            ->paginate(6)
            ->withQueryString();

        // Blade'de aktif kategori chip'i için (opsiyonel ama faydalı)
        $category = $categorySlug
            ? $categories->firstWhere('slug', $categorySlug)
            : null;

        return view('front.index', compact('posts', 'categories', 'category', 'from', 'to','sort'));
    }

    public function category(string $slug): View
    {
        $category = Category::query()
            ->where('slug', $slug)
            ->firstOrFail();

        $categories = Category::query()->orderBy('name')->get();

        $posts = Post::query()
            ->with('categories')
            ->whereHas('categories', function ($query) use ($category) {
                $query->where('categories.id', $category->id);
            })
            ->live()
            ->latest('published_at')
            ->paginate(6);

        return view('front.index', compact('posts', 'category', 'categories'));
    }

    public function post(string $slug): View
    {
        $post = Post::query()
            ->with('categories')
            ->where('slug', $slug)
            ->live()
            ->firstOrFail();

        $post->increment('views_count');

        $isLiked = $post->isLikedBy(auth()->user());
        $likesCount = $post->likes()->count();

        return view('front.post', compact('post', 'isLiked', 'likesCount'));
    }
}
