<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreRoomRequest;
use App\Models\Service;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rooms = Service::whereNotNull('ps_price')->paginate(config('admin.pagination'));
        return view('admin.rooms.index', compact('rooms'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.rooms.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRoomRequest $request)
    {
        Service::create([
            'name' => $request->name,
            'type' => '2',
            'ps_price' => $request->ps_price,
            'ps_type' => $request->ps_type
        ]);
        return redirect()->route('rooms.index')->with('success', 'Added Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $service = Service::find($id);
        return view('admin.rooms.edit', compact('service'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreRoomRequest $request, $id )
    {
        $service = Service::find($id);
        $service->update([
            'name' => $request->name,
            'ps_price' => $request->ps_price,
            'ps_type' => $request->ps_type
        ]);

        return redirect()->route('rooms.index')->with('success', 'Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id )
    {
        $service = Service::find($id);
        if($service->isActive() ){
            return redirect()->route('rooms.index')->with('error', 'يوجد أوردرات  حالية و لايمكن الحذف');
        }
        $service->delete();
        return redirect()->route('rooms.index')->with('success', 'Deleted Successfully');
    }
    public function getTrashedRooms()
    {
        $rooms = Service::onlyTrashed()->whereType(2)->paginate(config('admin.pagination'));
        return view('admin.rooms.trashed', compact('rooms'));
    }
    public function restore($id)
    {
        $room = Service::onlyTrashed()->find($id);
        $room->restore();
        return redirect()->route('rooms.index')->with('success', 'Restored Successfully');
    }
}