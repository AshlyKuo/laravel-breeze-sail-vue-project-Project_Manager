<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'date' => $this->date,
            'houseCode' => $this->house_code,
            'houseId' => $this->house_id,
            'client' => $this->client,
            'phone' => $this->phone,
            'email' => $this->email,
            'sales' => $this->sales,
            'installer' => $this->installer,
            'address' => $this->address,
            'amounts' => $this->amounts,
            'progress' => $this->progress,
            'completed' => $this->completed,
            'clientSatisfaction' => $this->client_satisfaction,
            'zs2' => $this->zs2,
            'ffu' => $this->ffu,
            'zef' => $this->zef,
            'zrh' => $this->zrh,
            'notes' => $this->notes,
            'currency'=> $this->currency
        ];
    }
}
