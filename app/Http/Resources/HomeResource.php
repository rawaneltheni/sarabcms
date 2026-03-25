<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HomeResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'h1' => $this->h1,
            'h2' => $this->h2,
            'body' => $this->body,
            'btn_text' => $this->btn_text,
            'btn_link' => $this->btn_link,
            'order' => $this->order,
            'image_url' => $this->image_url,
        ];
    }
}
