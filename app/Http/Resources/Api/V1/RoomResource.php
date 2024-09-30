<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RoomResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'roomId' => $this->room_id,
            'name' => $this->name,
            'houseCode' => $this->house_code,
            'houseId' => $this->house_id,
            'length' => $this->length,
            'width' => $this->width,
            'height' => $this->height,
            'outdoorPm25' => $this->outdoor_pm25,
        ];
    }
}
