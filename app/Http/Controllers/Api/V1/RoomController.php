<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Room;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\RoomResource;
use App\Http\Resources\Api\V1\RoomCollection;
use App\Services\V1\RoomQuery;
use App\Http\Requests\Api\V1\StoreRoomRequest;
use App\Http\Requests\Api\V1\UpdateRoomRequest;
use Illuminate\Support\Facades\Log;


class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return new RoomCollection(Room::all());
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRoomRequest $request)
    {
        return new RoomResource(Room::create($request->all()));
    }

    /**
     * Display the specified resource.
     */
    public function show($roomId)
    {
        $room = Room::where('room_id', $roomId)->firstOrFail();
        return new RoomResource($room);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRoomRequest $request, $roomId)
    {   
        // Log::debug('Validated data:', $request->all());
        $room = Room::where('room_id', $roomId)->firstOrFail();
        $validated = $request->all();
        unset($validated['room_id']);
        unset($validated['outdoorPm25']);
        $room->update($validated);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($roomId)
    {
        $room = Room::where('room_id', $roomId)->firstOrFail();

        if(!$room){
            return response()->json(['message' => 'Room not found'], 404);
        }

        $room->delete();

        return response()->json(['message' => 'Room has been deleted']);
    }
}
