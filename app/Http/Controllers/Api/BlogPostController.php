<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BlogPostResource;
use App\Models\BlogPost;
use App\Support\ApiCache;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Cache;

class BlogPostController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $blogPosts = Cache::remember(ApiCache::key('blog-posts:index'), now()->addMinutes(10), static function () {
            return BlogPost::query()
                ->select(['id', 'title', 'slug', 'excerpt', 'content', 'image', 'date', 'created_at', 'updated_at'])
                ->latest('date')
                ->latest('id')
                ->simplePaginate(10);
        });

        return BlogPostResource::collection($blogPosts);
    }

    public function show(string $blogPost): JsonResponse
    {
        $payload = Cache::remember(ApiCache::key('blog-posts:show:' . $blogPost), now()->addMinutes(10), static function () use ($blogPost): array {
            $post = BlogPost::query()
                ->select(['id', 'title', 'slug', 'excerpt', 'content', 'image', 'date', 'created_at', 'updated_at'])
                ->where('slug', $blogPost)
                ->orWhere('id', $blogPost)
                ->firstOrFail();

            $related = BlogPost::query()
                ->select(['id', 'title', 'slug', 'excerpt', 'image', 'date', 'created_at', 'updated_at'])
                ->whereKeyNot($post->getKey())
                ->latest('date')
                ->latest('id')
                ->limit(2)
                ->get();

            return [
                'post' => (new BlogPostResource($post))->resolve(),
                'related' => BlogPostResource::collection($related)->resolve(),
            ];
        });

        return response()->json([
            'data' => $payload,
        ]);
    }
}
