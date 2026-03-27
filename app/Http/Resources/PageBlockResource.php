<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PageBlockResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'page' => $this->page,
            'key' => $this->key,
            'eyebrow' => $this->eyebrow,
            'title' => $this->title,
            'subtitle' => $this->subtitle,
            'description' => $this->description,
            'cta_label' => $this->cta_label,
            'cta_url' => $this->cta_url,
            'secondary_cta_label' => $this->secondary_cta_label,
            'secondary_cta_url' => $this->secondary_cta_url,
            'meta' => $this->meta ?? [],
        ];
    }
}
