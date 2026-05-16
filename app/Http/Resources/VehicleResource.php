<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VehicleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
   public function toArray($request): array
{
    return [
        'id' => $this->id,
        'brand' => $this->brand,
        'model' => $this->model,
        'year' => $this->year,
        'price' => $this->price,
        'stock' => $this->stock,
        'category' => $this->category->name
    ];
}
}
