<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NoteResource extends JsonResource
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
            'content' => $this->content,
            'user' => $this->user->name,
            'lead' => $this->lead->description,
            'opportunity' => $this->opportunity->title,
        ];
    }
}
