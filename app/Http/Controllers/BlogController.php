<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use Illuminate\Contracts\View\View;

class BlogController extends Controller
{
    public function index(): View
    {
        $posts = BlogPost::query()
            ->orderByDesc('date')
            ->orderByDesc('created_at')
            ->paginate(9);

        $featuredPost = $posts->first();

        return view('blog.index', [
            'featuredPost' => $featuredPost,
            'posts' => $posts,
        ]);
    }

    public function show(string $slug): View
    {
        $post = BlogPost::query()
            ->where('slug', $slug)
            ->firstOrFail();

        $relatedPosts = BlogPost::query()
            ->whereKeyNot($post->getKey())
            ->orderByDesc('date')
            ->orderByDesc('created_at')
            ->limit(3)
            ->get();

        return view('blog.show', [
            'post' => $post,
            'relatedPosts' => $relatedPosts,
        ]);
    }
}
