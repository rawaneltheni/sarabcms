<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AboutResource;
use App\Http\Resources\BlogPostResource;
use App\Http\Resources\CustomerResource;
use App\Http\Resources\HomeResource;
use App\Http\Resources\ProjectResource;
use App\Http\Resources\ServiceResource;
use App\Http\Resources\StatResource;
use App\Models\About;
use App\Models\BlogPost;
use App\Models\Customer;
use App\Models\Home;
use App\Models\Project;
use App\Models\Service;
use App\Models\Stat;
use App\Support\ApiCache;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;

class HomepageController extends Controller
{
    public function show(): JsonResponse
    {
        $payload = Cache::remember(ApiCache::key('homepage'), now()->addMinutes(10), static function (): array {
            return [
                'projects' => ProjectResource::collection(
                    Project::query()
                        ->select(['id', 'title', 'slug', 'category', 'description', 'image_path', 'show_on_homepage', 'homepage_order', 'created_at', 'updated_at'])
                        ->orderByDesc('show_on_homepage')
                        ->orderBy('homepage_order')
                        ->orderByDesc('id')
                        ->get()
                )->resolve(),
                'home' => HomeResource::collection(
                    Home::query()
                        ->select(['id', 'h1', 'h2', 'body', 'btn_text', 'btn_link', 'image', 'order'])
                        ->orderBy('order')
                        ->get()
                )->resolve(),
                'about' => AboutResource::collection(
                    About::query()
                        ->select(['id', 'heading1', 'heading2', 'description', 'image1', 'image2', 'image3', 'features', 'created_at', 'updated_at'])
                        ->latest('id')
                        ->limit(1)
                        ->get()
                )->resolve(),
                'customers' => CustomerResource::collection(
                    Customer::query()
                        ->select(['id', 'name', 'logo_path', 'website_url', 'order'])
                        ->orderBy('order')
                        ->orderBy('id')
                        ->get()
                )->resolve(),
                'services' => ServiceResource::collection(
                    Service::query()
                        ->select(['id', 'title', 'description', 'icon', 'image', 'url', 'order', 'created_at', 'updated_at'])
                        ->orderBy('order')
                        ->orderBy('id')
                        ->get()
                )->resolve(),
                'stats' => StatResource::collection(
                    Stat::query()
                        ->select(['id', 'icon', 'number', 'label', 'order', 'created_at', 'updated_at'])
                        ->orderBy('order')
                        ->orderBy('id')
                        ->get()
                )->resolve(),
                'blog_posts' => BlogPostResource::collection(
                    BlogPost::query()
                        ->select(['id', 'title', 'slug', 'excerpt', 'image', 'date', 'created_at', 'updated_at'])
                        ->latest('date')
                        ->latest('id')
                        ->limit(3)
                        ->get()
                )->resolve(),
            ];
        });

        return response()->json([
            'data' => $payload,
        ]);
    }
}
