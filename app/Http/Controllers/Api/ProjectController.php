<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProjectResource;
use App\Models\Project;
use App\Support\ApiCache;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Cache;

class ProjectController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $projects = Cache::remember(ApiCache::key('projects:index'), now()->addMinutes(10), static function () {
            return Project::query()
                ->select(['id', 'title', 'slug', 'category', 'description', 'image_path', 'show_on_homepage', 'homepage_order', 'created_at', 'updated_at'])
                ->orderByDesc('show_on_homepage')
                ->orderBy('homepage_order')
                ->orderByDesc('id')
                ->simplePaginate(12);
        });

        return ProjectResource::collection($projects);
    }

    public function show(Project $project): ProjectResource
    {
        $project = Cache::remember(ApiCache::key('projects:show:' . $project->getKey()), now()->addMinutes(10), static function () use ($project) {
            return Project::query()
                ->select(['id', 'title', 'slug', 'category', 'description', 'image_path', 'show_on_homepage', 'homepage_order', 'created_at', 'updated_at'])
                ->findOrFail($project->getKey());
        });

        return new ProjectResource($project);
    }
}
