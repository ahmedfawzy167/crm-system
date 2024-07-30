<?php

namespace App\Http\Controllers;

use App\Http\Resources\ActivityCollection;
use App\Http\Resources\ActivityResource;
use App\Models\Activity;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $activities = Activity::with('user', 'lead', 'opportunity')->get();
        return new ActivityCollection($activities);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'lead_id' => ['required', 'exists:leads,id'],
            'opportunity_id' => ['required', 'exists:opportunities,id'],
            'details' => ['required', 'string', 'max:100'],
            'date' => ['required', 'date'],
            'status' => ['required', 'string']
        ]);

        $activity = new Activity();
        $activity->user_id = $request->user_id;
        $activity->lead_id = $request->lead_id;
        $activity->opportunity_id = $request->opportunity_id;
        $activity->details = $request->details;
        $activity->date = $request->date;
        $activity->status = $request->status;
        $activity->save();

        return response()->json([
            'status' => 'Success',
            'message' => 'Activity Created Successfully',
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Activity $activity)
    {
        if ($activity != null) {
            return new ActivityResource($activity);
        } else {
            return response()->json([
                'status' => 'Error',
                'message' => 'Activity Not Found',
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Activity $activity)
    {
        $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'lead_id' => ['required', 'exists:leads,id'],
            'opportunity_id' => ['required', 'exists:opportunities,id'],
            'details' => ['required', 'string', 'max:100'],
            'date' => ['required', 'date'],
            'status' => ['required', 'string']
        ]);

        $activity->user_id = $request->user_id;
        $activity->lead_id = $request->lead_id;
        $activity->opportunity_id = $request->opportunity_id;
        $activity->details = $request->details;
        $activity->date = $request->date;
        $activity->status = $request->status;
        $activity->update();

        return response()->json([
            'status' => 'Success',
            'message' => 'Activity Updated Successfully',
        ], 200);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Activity $activity)
    {
        $activity->delete();
        return response()->json([
            'status' => 'Success',
            'message' => 'Activity Deleted Successfully',
        ], 200);
    }
}
