<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AboutResource;
use App\Models\About;
use App\Support\ApiCache;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Cache;

class AboutController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $abouts = Cache::remember(ApiCache::key('abouts:index'), now()->addMinutes(10), static function () {
            return About::query()
                ->select(['id', 'heading1', 'heading2', 'description', 'image1', 'image2', 'image3', 'features', 'created_at', 'updated_at'])
                ->latest('id')
                ->limit(1)
                ->get();
        });

        return AboutResource::collection($abouts);
    }

    public function show(About $about): AboutResource
    {
        $about = Cache::remember(ApiCache::key('abouts:show:' . $about->getKey()), now()->addMinutes(10), static function () use ($about) {
            return About::query()
                ->select(['id', 'heading1', 'heading2', 'description', 'image1', 'image2', 'image3', 'features', 'created_at', 'updated_at'])
                ->findOrFail($about->getKey());
        });

        return new AboutResource($about);
    }
}
