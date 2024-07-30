<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class OpportunityCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request)
    {
        return [
            'opportunities' => $this->collection->map(function ($opportunity) {
                return [
                    'id' => $opportunity->id,
                    'title' => $opportunity->title,
                    'description' => $opportunity->description,
                    'user' => $opportunity->user->name,
                    'amount' => $opportunity->amount,
                    'expected_close_date' => $opportunity->expected_close_date,
                    'status' => $opportunity->status,
                ];
            })
        ];
    }
}
