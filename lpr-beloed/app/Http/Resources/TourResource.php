<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Tour */
class TourResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'          => $this->id,
            'title'       => $this->title,
            'description' => $this->description,
            'start_date'  => $this->start_date?->format('Y-m-d'),
            'days'        => (int) $this->days,
            'price'       => (float) $this->price,
            'is_hot'      => $this->is_hot ? 'yes' : 'no',   // формат C: логические - "yes"/"no"
            'country'     => [
                'id'   => $this->country_id,
                'name' => $this->whenLoaded('country', fn () => $this->country->name), // только если связь загружена
            ],
            'created_at'  => $this->created_at?->toIso8601String(),
        ];
    }
}
