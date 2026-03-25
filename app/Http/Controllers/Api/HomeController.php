<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\HomeResource;
use App\Models\Home;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class HomeController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        return HomeResource::collection(Home::query()->orderBy('order')->get());
    }

    public function show(Home $home): HomeResource
    {
        return new HomeResource($home);
    }
}
