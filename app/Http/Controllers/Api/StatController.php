<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\StatResource;
use App\Models\Stat;
use App\Support\ApiCache;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Cache;

class StatController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $stats = Cache::remember(ApiCache::key('stats:index'), now()->addMinutes(10), static function () {
            return Stat::query()
                ->select(['id', 'icon', 'number', 'label', 'order', 'created_at', 'updated_at'])
                ->orderBy('order')
                ->orderBy('id')
                ->get();
        });

        return StatResource::collection($stats);
    }

    public function show(Stat $stat): StatResource
    {
        $stat = Cache::remember(ApiCache::key('stats:show:' . $stat->getKey()), now()->addMinutes(10), static function () use ($stat) {
            return Stat::query()
                ->select(['id', 'icon', 'number', 'label', 'order', 'created_at', 'updated_at'])
                ->findOrFail($stat->getKey());
        });

        return new StatResource($stat);
    }
}
