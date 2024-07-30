<?php

namespace App\Http\Controllers;

use App\Http\Resources\LeadCollection;
use App\Http\Resources\LeadResource;
use App\Models\Lead;
use Illuminate\Http\Request;

class LeadController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $leads = Lead::with('user')->get();
        return new LeadCollection($leads);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'description' => ['required', 'string', 'max:800'],
            'source' => ['required', 'max:50']
        ]);

        $lead = new Lead();
        $lead->user_id = $request->user_id;
        $lead->description = $request->description;
        $lead->source = $request->source;
        $lead->save();

        return response()->json([
            'status' => 'Success',
            'message' => 'Lead Created Successfully',
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Lead $lead)
    {
        if ($lead != null) {
            return new LeadResource($lead);
        } else {
            return response()->json([
                'status' => 'Error',
                'message' => 'Lead Not Found',
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Lead $lead)
    {
        $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'description' => ['required', 'string', 'max:800'],
            'status' => ['required', 'string', 'between:5,30'],
            'source' => ['required', 'max:50']
        ]);

        $lead->user_id = $request->user_id;
        $lead->description = $request->description;
        $lead->status = $request->status;
        $lead->source = $request->source;
        $lead->update();

        return response()->json([
            'status' => 'Success',
            'message' => 'Lead Updated Successfully',
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Lead $lead)
    {
        $lead->delete();
        return response()->json([
            'status' => 'Success',
            'message' => 'Lead Deleted Successfully',
        ], 200);
    }
}
