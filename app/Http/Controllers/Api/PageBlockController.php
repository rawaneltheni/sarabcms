<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PageBlockResource;
use App\Models\PageBlock;
use App\Support\ApiCache;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Cache;

class PageBlockController extends Controller
{
    public function index(Request $request): AnonymousResourceCollection
    {
        $page = $request->string('page')->toString();

        $cacheKey = $page === ''
            ? ApiCache::key('page-blocks:index:all')
            : ApiCache::key('page-blocks:index:' . $page);

        $blocks = Cache::remember($cacheKey, now()->addMinutes(10), static function () use ($page) {
            $query = PageBlock::query()
                ->select(['id', 'page', 'key', 'eyebrow', 'title', 'subtitle', 'description', 'cta_label', 'cta_url', 'secondary_cta_label', 'secondary_cta_url', 'meta', 'order'])
                ->orderBy('order')
                ->orderBy('id');

            if ($page !== '') {
                $query->where('page', $page);
            }

            return $query->get();
        });

        return PageBlockResource::collection($blocks);
    }
}
