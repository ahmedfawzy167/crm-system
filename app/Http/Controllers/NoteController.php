<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\Request;
use App\Http\Resources\NoteResource;
use App\Http\Resources\NoteCollection;

class NoteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $notes = Note::with('user', 'lead', 'opportunity')->get();
        return new NoteCollection($notes);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'content' => ['required', 'string', 'max:800'],
            'user_id' => ['required', 'exists:users,id'],
            'lead_id' => ['required', 'exists:leads,id'],
            'opportunity_id' => ['required', 'exists:opportunities,id'],
        ]);

        $note = new Note();
        $note->content = $request->content;
        $note->user_id = $request->user_id;
        $note->lead_id = $request->lead_id;
        $note->opportunity_id = $request->opportunity_id;
        $note->save();

        return response()->json([
            'status' => 'Success',
            'message' => 'Note Created Successfully',
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Note $note)
    {
        if ($note != null) {
            return new NoteResource($note);
        } else {
            return response()->json([
                'status' => 'Error',
                'message' => 'Note Not Found',
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Note $note)
    {
        $request->validate([
            'content' => ['required', 'string', 'max:800'],
            'user_id' => ['required', 'exists:users,id'],
            'lead_id' => ['required', 'exists:leads,id'],
            'opportunity_id' => ['required', 'exists:opportunities,id'],
        ]);

        $note->content = $request->content;
        $note->user_id = $request->user_id;
        $note->lead_id = $request->lead_id;
        $note->opportunity_id = $request->opportunity_id;
        $note->update();

        return response()->json([
            'status' => 'Success',
            'message' => 'Note Updated Successfully',
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Note $note)
    {
        $note->delete();
        return response()->json([
            'status' => 'Success',
            'message' => 'Note Deleted Successfully',
        ], 200);
    }
}
