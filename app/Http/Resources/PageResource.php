<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class PageResource extends JsonResource
{
  /**
   * Transform the resource into an array.
   *
   * @return array<string, mixed>
   */
  public function toArray(Request $request): array
  {
    return [
      "title" => $this->title,
      "slug" => $this->slug,
      "description" => $this->description,
      "updated_at" => $this->updated_at,
      "image" => $this->image
        ? Storage::disk("public")->url($this->image)
        : null,
    ];
  }
}
