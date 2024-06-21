<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreTableRequest;
use App\Models\Service;

class TableController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tables = Service::whereType(1)->paginate(config('admin.pagination'));
        return view('admin.tables.index', compact('tables'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.tables.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTableRequest $request)
    {
        Service::create([
            'name' => $request->name,
            'type' => '1',
        ]);
        return redirect()->route('tables.index')->with('success', 'Added Successfully');
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
        return view('admin.tables.edit', compact('service'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreTableRequest $request, $id )
    {
        $service = Service::find($id);
        $service->update([
            'name' => $request->name,
        ]);

        return redirect()->route('tables.index')->with('success', 'Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id )
    {
        $service = Service::find($id);
        $service->delete();
        return redirect()->route('tables.index')->with('success', 'Deleted Successfully');
    }
}