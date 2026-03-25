<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ServiceResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title ?? null,
            'description' => $this->description ?? null,
            'icon' => $this->icon ?? null,
            'image' => $this->image ?? null,
            'image_url' => $this->image ? asset('storage/' . $this->image) : null,
            'url' => $this->url ?? null,
            'order' => $this->order ?? null,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
