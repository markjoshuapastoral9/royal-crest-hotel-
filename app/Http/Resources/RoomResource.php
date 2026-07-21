<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RoomResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'                => $this->id,
            'name'              => $this->name,
            'room_number'       => $this->room_number,
            'room_type'         => $this->whenLoaded('roomType', fn() => [
                'id'   => $this->roomType->id,
                'name' => $this->roomType->name,
            ]),
            'description'       => $this->description,
            'price_per_night'   => (float) $this->price_per_night,
            'formatted_price'   => $this->formatted_price,
            'capacity'          => $this->capacity,
            'beds'              => $this->beds,
            'bathrooms'         => $this->bathrooms,
            'floor'             => $this->floor,
            'size_sqm'          => $this->size_sqm,
            'view'              => $this->view,
            'status'            => $this->status,
            'thumbnail_url'     => $this->thumbnail_url,
            'amenities'         => $this->whenLoaded('amenities', fn() =>
                $this->amenities->pluck('name')
            ),
            'has_wifi'          => $this->has_wifi,
            'has_aircon'        => $this->has_aircon,
            'has_tv'            => $this->has_tv,
            'has_minibar'       => $this->has_minibar,
            'breakfast_included'=> $this->breakfast_included,
            'is_featured'       => $this->is_featured,
        ];
    }
}
