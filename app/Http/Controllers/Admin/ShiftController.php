<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Shift;
use DB;
use Illuminate\Http\Request;

class ShiftController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $shifts = Shift::whereStatus(2)->paginate();
        $isActiveShift = Shift::where('status', 1)->first();
        return view('admin.shifts.index', compact('shifts', 'isActiveShift'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.shifts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       
       $shift = Shift::create([
            'user_id' => auth()->user()->id,
            'start_cash' => $request->start_cash,
            'start_time' => \Carbon\Carbon::now('Africa/Cairo'),
            'type' => $request->type,
            'description' => $request->description
        ]);
        $orders = Order::where('status', 1)->get();
        if($orders->count() > 0){
            foreach($orders as $order){
                $order->update(['shift_id' => $shift->id]);
            }
        }
        return redirect()->route('shifts.index')->with('success', 'Added Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $shift = Shift::find($id);
        return view('admin.shifts.edit', compact('shift'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
       Shift::create([
            'user_id' => auth()->user()->id,
            'start_cash' => $request->start_cash,
            'end_time' => \Carbon\Carbon::now('Africa/Cairo'),
            'type' => $request->type,
            'description' => $request->description
        ]);
        return redirect()->route('shifts.index')->with('success', 'Updated Successfully');
    }
    public function getActiveShift(Request $request)
    {
        $isActiveShift = Shift::where('status', 1)->first();
        return view('admin.shifts.close-shift', compact('isActiveShift'));
    }
    public function closeShift(Request $request)
    {
        $shift = auth()->user()->getUserShift();
        $shift->update([
                'end_cash' => $request->end_cash,
                'end_time' => \Carbon\Carbon::now('Africa/Cairo'),
                'status' => 2,
                'description' => $request->description
            ]);
            return redirect()->route('shifts.index')->with('success', 'Updated Successfully');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }
}