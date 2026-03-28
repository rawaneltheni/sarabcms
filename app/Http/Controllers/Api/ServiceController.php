<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ServiceResource;
use App\Models\Service;
use App\Support\ApiCache;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Cache;

class ServiceController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $services = Cache::remember(ApiCache::key('services:index'), now()->addMinutes(10), static function () {
            return Service::query()
                ->select(['id', 'title', 'description', 'icon', 'image', 'url', 'order', 'created_at', 'updated_at'])
                ->orderBy('order')
                ->orderBy('id')
                ->get();
        });

        return ServiceResource::collection($services);
    }

    public function show(Service $service): ServiceResource
    {
        $service = Cache::remember(ApiCache::key('services:show:' . $service->getKey()), now()->addMinutes(10), static function () use ($service) {
            return Service::query()
                ->select(['id', 'title', 'description', 'icon', 'image', 'url', 'order', 'created_at', 'updated_at'])
                ->findOrFail($service->getKey());
        });

        return new ServiceResource($service);
    }
}
