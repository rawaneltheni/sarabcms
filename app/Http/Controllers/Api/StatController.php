<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\StatResource;
use App\Models\Stat;

class StatController extends Controller
{
    public function index()
    {
        $stats = Stat::latest()->get();
        return StatResource::collection($stats);
    }

    public function show(Stat $stat)
    {
        return new StatResource($stat);
    }
}
