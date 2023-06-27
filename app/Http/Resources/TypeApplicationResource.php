<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TypeApplicationResource extends JsonResource
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
            'nameapplications_id' => $this->nameapplications_id,
            'nameapplication' => $this->nameapplication,
            'priorities_id' => $this->priorities_id,
            'priority' => $this->priority,
            'slaDay' => $this->slaDay,
            'slaHours' => $this->slaHours,
            'sla' => $this->sla,
        ];
    }
}
