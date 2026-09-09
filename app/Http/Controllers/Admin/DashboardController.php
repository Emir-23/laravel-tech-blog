<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $stats = [
            'posts' => Post::query()->count(),
            'categories' => Category::query()->count(),
            'views' => (int) Post::query()->sum('views_count'),
            'likes' => DB::table('post_user')->count(),
        ];

        // Chart.js: en çok okunan yazılar (bar)
        $topPosts = Post::query()
            ->orderByDesc('views_count')
            ->limit(8)
            ->get(['title', 'views_count']);

        $viewsChart = [
            'labels' => $topPosts->pluck('title')->values()->all(),
            'data' => $topPosts->pluck('views_count')->values()->all(),
        ];

        // Chart.js: kategori başına yazı dağılımı (doughnut)
        $categoryStats = Category::query()
            ->withCount('posts')
            ->orderByDesc('posts_count')
            ->get();

        $categoryChart = [
            'labels' => $categoryStats->pluck('name')->values()->all(),
            'data' => $categoryStats->pluck('posts_count')->values()->all(),
        ];

        return view('admin.dashboard', compact('stats', 'viewsChart', 'categoryChart'));
    }
}
