<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PageBlockResource;
use App\Models\PageBlock;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class PageBlockController extends Controller
{
    public function index(Request $request): AnonymousResourceCollection
    {
        $page = $request->string('page')->toString();

        $query = PageBlock::query()->orderBy('order')->orderBy('id');

        if ($page !== '') {
            $query->where('page', $page);
        }

        return PageBlockResource::collection($query->get());
    }
}
