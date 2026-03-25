<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AboutResource;
use App\Models\About;

class AboutController extends Controller
{
    public function index()
    {
        $abouts = About::latest()->get();
        return AboutResource::collection($abouts);
    }

    public function show(About $about)
    {
        return new AboutResource($about);
    }
}
