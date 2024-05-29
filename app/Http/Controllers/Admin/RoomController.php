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
        $product = new Product();
        $product->name = $request->name;
        $product->price = $request->price;
        if (request()->photo) {
            $product->photo = $this->saveImage($request->photo, $product->image);
        }
        $product->save();
        return redirect()->route('products.index')->with('success', 'Added Successfully');
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
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Deleted Successfully');
    }

    public function saveImage($filename, $path)
    {
        $file = time() . '.' . $filename->getClientOriginalExtension();
            request()->photo->move(public_path($path), $file);
        return $file;
    }
    public function menu()
    {
        $products = Product::all();
        return view('website.menu', compact('products'));
    }
}