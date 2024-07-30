<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class NoteCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request)
    {
        return [
            'notes' => $this->collection->map(function ($note) {
                return [
                    'id' => $note->id,
                    'content' => $note->content,
                    'user' => $note->user->name,
                    'lead' => $note->lead,
                    'opportunity' => $note->opportunity,
                ];
            })
        ];
    }
}
