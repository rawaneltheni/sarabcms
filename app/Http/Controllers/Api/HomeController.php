<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\HomeResource;
use App\Models\Home;
use App\Support\ApiCache;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $homes = Cache::remember(ApiCache::key('homes:index'), now()->addMinutes(10), static function () {
            return Home::query()
                ->select(['id', 'h1', 'h2', 'body', 'btn_text', 'btn_link', 'image', 'order'])
                ->orderBy('order')
                ->get();
        });

        return HomeResource::collection($homes);
    }

    public function show(Home $home): HomeResource
    {
        $home = Cache::remember(ApiCache::key('homes:show:' . $home->getKey()), now()->addMinutes(10), static function () use ($home) {
            return Home::query()
                ->select(['id', 'h1', 'h2', 'body', 'btn_text', 'btn_link', 'image', 'order'])
                ->findOrFail($home->getKey());
        });

        return new HomeResource($home);
    }
}
