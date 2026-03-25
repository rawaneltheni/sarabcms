<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BlogPostResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title ?? null,
            'slug' => $this->slug ?? null,
            'excerpt' => $this->excerpt ?? null,
            'content' => $this->content ?? null,
            'image' => $this->image ?? null,
            'image_url' => $this->image ? asset('storage/' . $this->image) : null,
            'published_at' => $this->date ?? null,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
