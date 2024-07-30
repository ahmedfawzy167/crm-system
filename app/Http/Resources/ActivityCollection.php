<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ActivityCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request)
    {
        return [
            'activities' => $this->collection->map(function ($activity) {
                return [
                    'id' => $activity->id,
                    'user' => $activity->user->name,
                    'lead' => $activity->lead->description,
                    'opportunity' => $activity->opportunity->title,
                ];
            })
        ];
    }
}
