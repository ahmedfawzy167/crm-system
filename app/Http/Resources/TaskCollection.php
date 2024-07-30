<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class TaskCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request)
    {
        return [
            'tasks' => $this->collection->map(function ($task) {
                return [
                    'id' => $task->id,
                    'title' => $task->title,
                    'description' => $task->description,
                    'user' => $task->user->name,
                    'lead' => $task->lead,
                    'opportunity' => $task->opportunity,
                    'date' => $task->date,
                    'due date' => $task->due_date
                ];
            })
        ];
    }
}
