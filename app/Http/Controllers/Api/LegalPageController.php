<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\LegalPageResource;
use App\Models\LegalPage;
use App\Support\ApiCache;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Cache;

class LegalPageController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $pages = Cache::remember(ApiCache::key('legal-pages:index'), now()->addMinutes(10), static function () {
            return LegalPage::query()
                ->select(['id', 'slug', 'title', 'content', 'updated_at'])
                ->orderBy('id')
                ->get();
        });

        return LegalPageResource::collection($pages);
    }

    public function show(string $slug): LegalPageResource
    {
        $page = Cache::remember(ApiCache::key('legal-pages:show:' . $slug), now()->addMinutes(10), static function () use ($slug) {
            return LegalPage::query()
                ->select(['id', 'slug', 'title', 'content', 'updated_at'])
                ->where('slug', $slug)
                ->firstOrFail();
        });

        return new LegalPageResource($page);
    }
}
