<?php

namespace App\Http\Controllers;

use App\Models\Opportunity;
use Illuminate\Http\Request;
use App\Http\Resources\OpportunityCollection;
use App\Http\Resources\OpportunityResource;

class OpportunityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $opportunities = Opportunity::with('user')->get();
        return new OpportunityCollection($opportunities);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:50'],
            'description' => ['required', 'string', 'max:800'],
            'user_id' => ['required', 'exists:users,id'],
            'amount' => ['required', 'regex:/^\d+(\.\d{1,2})?$/', 'gt:0'],
            'expected_close_date' => 'required|date_format:Y-m-d'
        ]);

        $opportunity = new Opportunity();
        $opportunity->title = $request->title;
        $opportunity->description = $request->description;
        $opportunity->user_id = $request->user_id;
        $opportunity->amount = $request->amount;
        $opportunity->expected_close_date = $request->expected_close_date;
        $opportunity->save();

        return response()->json([
            'status' => 'Success',
            'message' => 'Opportunity Created Successfully',
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Opportunity $opportunity)
    {
        if ($opportunity != null) {
            return new OpportunityResource($opportunity);
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
    public function update(Request $request, Opportunity $opportunity)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:50'],
            'description' => ['required', 'string', 'max:800'],
            'user_id' => ['required', 'exists:users,id'],
            'amount' => ['required', 'regex:/^\d+(\.\d{1,2})?$/', 'gt:0'],
            'expected_close_date' => 'required|date_format:Y-m-d'
        ]);

        $opportunity->title = $request->title;
        $opportunity->description = $request->description;
        $opportunity->user_id = $request->user_id;
        $opportunity->amount = $request->amount;
        $opportunity->expected_close_date = $request->expected_close_date;
        $opportunity->status = $request->status;
        $opportunity->update();

        return response()->json([
            'status' => 'Success',
            'message' => 'Opportunity Updated Successfully',
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Opportunity $opportunity)
    {
        $opportunity->delete();

        return response()->json([
            'status' => 'Success',
            'message' => 'Opportunity Deleted Successfully',
        ], 200);
    }
}
