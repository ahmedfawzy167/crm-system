<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class LeadCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request)
    {
        return [
            'leads' => $this->collection->map(function ($lead) {
                return [
                    'id' => $lead->id,
                    'user' => $lead->user->name,
                    'description' => $lead->description,
                    'status' => $lead->status,
                    'source' => $lead->source,
                ];
            })
        ];
    }
}
