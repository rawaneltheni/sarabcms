<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AboutResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'heading1' => $this->heading1 ?? null,
            'heading2' => $this->heading2 ?? null,
            'description' => $this->description ?? null,
            'features' => $this->features ?? [],
            'image1' => $this->image1 ?? null,
            'image2' => $this->image2 ?? null,
            'image3' => $this->image3 ?? null,
            'image1_url' => $this->image1 ? asset('storage/' . $this->image1) : null,
            'image2_url' => $this->image2 ? asset('storage/' . $this->image2) : null,
            'image3_url' => $this->image3 ? asset('storage/' . $this->image3) : null,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
