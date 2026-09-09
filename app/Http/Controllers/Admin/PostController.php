<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PostController extends Controller
{
    public function index(): View
    {
        $posts = Post::query()
            ->with('categories')
            ->withCount('likes')
            ->latest()
            ->paginate(15);

        return view('admin.posts.index', compact('posts'));
    }

    public function create(): View
    {
        $categories = Category::query()->orderBy('name')->get();

        return view('admin.posts.create', compact('categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validatePost($request);

        $data = [
            'title' => $validated['title'],
            'slug' => $this->uniqueSlug($validated['title']),
            'content' => $validated['content'],
            'is_published' => $request->boolean('is_published'),
            'published_at' => $validated['published_at'] ?? null,
        ];

        if ($request->boolean('is_published') && empty($data['published_at'])) {
            $data['published_at'] = now();
        }

        if (! $request->boolean('is_published')) {
            $data['published_at'] = $validated['published_at'] ?? null;
        }

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('posts', 'public');
        }

        $post = Post::query()->create($data);

        $post->categories()->sync($validated['categories']);

        return redirect()
            ->route('admin.posts.index')
            ->with('success', 'Yazı oluşturuldu.');
    }

    public function edit(Post $post): View
    {
        $categories = Category::query()->orderBy('name')->get();

        return view('admin.posts.edit', compact('post', 'categories'));
    }

    public function update(Request $request, Post $post): RedirectResponse
    {
        $validated = $this->validatePost($request);

        $data = [
            'title' => $validated['title'],
            'slug' => $this->uniqueSlug($validated['title'], $post->id),
            'content' => $validated['content'],
            'is_published' => $request->boolean('is_published'),
            'published_at' => $validated['published_at'] ?? null,
        ];

        if ($request->boolean('is_published') && empty($data['published_at'])) {
            $data['published_at'] = $post->published_at ?? now();
        }

        if ($request->hasFile('image')) {
            if ($post->image) {
                Storage::disk('public')->delete($post->image);
            }

            $data['image'] = $request->file('image')->store('posts', 'public');
        }

        $post->update($data);

        $post->categories()->sync($validated['categories']);

        return redirect()
            ->route('admin.posts.index')
            ->with('success', 'Yazı güncellendi.');
    }

    public function destroy(Post $post): RedirectResponse
    {
        if ($post->image) {
            Storage::disk('public')->delete($post->image);
        }

        $post->delete();

        return redirect()
            ->route('admin.posts.index')
            ->with('success', 'Yazı silindi.');
    }

    /**
     * @return array{categories: array<int, int>, title: string, content: string, published_at: ?string}
     */
    private function validatePost(Request $request): array
    {
        return $request->validate([
            'categories' => ['required', 'array', 'min:1'],
            'categories.*' => ['integer', 'exists:categories,id'],
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
            'image' => ['nullable', 'image', 'max:2048'],
            'published_at' => ['nullable', 'date'],
        ]);
    }

    private function uniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $base = Str::slug($title) ?: 'yazi';
        $slug = $base;
        $i = 1;

        while (
            Post::query()
                ->where('slug', $slug)
                ->when($ignoreId !== null, fn ($query) => $query->where('id', '!=', $ignoreId))
                ->exists()
        ) {
            $slug = $base.'-'.$i;
            $i++;
        }

        return $slug;
    }
}
