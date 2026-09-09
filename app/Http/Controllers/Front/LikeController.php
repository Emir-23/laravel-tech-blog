<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    /**
     * Giriş yapmış kullanıcı için bir yazıyı beğen/beğenmekten vazgeç (toggle).
     */
    public function toggle(Request $request, string $slug): RedirectResponse
    {
        $post = Post::query()
            ->where('slug', $slug)
            ->live()
            ->firstOrFail();

        $user = $request->user();

        if ($post->isLikedBy($user)) {
            $post->likes()->detach($user->id);
        } else {
            $post->likes()->attach($user->id);
        }

        // Kullanıcıyı geldiği sayfaya (yazı detayı veya profil) geri gönder.
        return redirect()->back(fallback: route('post', $post->slug));
    }
}
