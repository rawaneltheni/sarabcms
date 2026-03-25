<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BlogPostResource;
use App\Models\BlogPost;

class BlogPostController extends Controller
{
    public function index()
    {
        $blogPosts = BlogPost::latest()->paginate(10);
        return BlogPostResource::collection($blogPosts);
    }

    public function show(BlogPost $blogPost)
    {
        return new BlogPostResource($blogPost);
    }
}
