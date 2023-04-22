<?php

namespace App\Http\Resources;

use App\Models\Comparison;
use Illuminate\Http\Resources\Json\JsonResource;

class ComparisonResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'index' => (new Comparison())->getTable(),
            'id' => $this->id,
            'slug' => $this->slug,
            'title' => $this->title,
            'image' => either($this->image, '/images/no-image.png'),
            'price' => $this->price,
            'featured' => $this->featured,
            'products_count' => $this->products_count
        ];
    }
}
