<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Giriş yapmış kullanıcının profil bilgilerini ve beğendiği yazıları göster.
     */
    public function index(): View
    {
        $user = auth()->user();

        $likedPosts = $user->likedPosts()
            ->with('categories')
            ->orderByDesc('posts.created_at')
            ->paginate(6);

        return view('front.profile', compact('user', 'likedPosts'));
    }
}
