<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProjectResource;
use App\Models\Project;
use Illuminate\Support\Facades\Schema;

class ProjectController extends Controller
{
    public function index()
    {
        $query = Project::query();

        if (Schema::hasColumn('projects', 'show_on_homepage')) {
            $query->orderByDesc('show_on_homepage');
        }

        if (Schema::hasColumn('projects', 'homepage_order')) {
            $query->orderBy('homepage_order');
        }

        $projects = $query
            ->latest('id')
            ->paginate(12);

        return ProjectResource::collection($projects);
    }

    public function show(Project $project)
    {
        return new ProjectResource($project);
    }
}
