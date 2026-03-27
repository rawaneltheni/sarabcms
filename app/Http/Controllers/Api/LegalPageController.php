<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\LegalPageResource;
use App\Models\LegalPage;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class LegalPageController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        return LegalPageResource::collection(LegalPage::query()->orderBy('id')->get());
    }

    public function show(string $slug): LegalPageResource
    {
        $page = LegalPage::query()->where('slug', $slug)->firstOrFail();

        return new LegalPageResource($page);
    }
}
