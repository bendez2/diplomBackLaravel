<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ApplicationResource extends JsonResource
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
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'type_id' => $this->type_id,
            'type' => $this->type,
            'text' => $this->text,
            'location' => $this->location,
            'executionTime' => $this->executiontime,
            'status_id' =>$this->status_id,
            'status' => $this ->status,
            'comment' => $this->comment,
            'closeTime' => $this->closetime,
            'initiator_id' => $this->initiator_id,
            'initiator' => $this->initiator,
            'historyExecutor' => $this->historyexecutor,
            'startWork' => $this->startwork,
            'employee_id' => $this->employee_id,
            'employee' => $this->employee,
        ];
    }
}
