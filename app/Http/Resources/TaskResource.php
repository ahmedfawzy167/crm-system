<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'user' => $this->user->name,
            'lead' => $this->lead->description,
            'opportunity' => $this->opportunity->title,
            'date' => $this->date,
            'due date' => $this->due_date,
            'status' => $this->statuses
        ];
    }
}
