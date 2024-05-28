<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use DB;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $invoices = Order::with('user');
        $users = User::all();
        if (isset($request->from) && isset($request->to))
            $invoices = $invoices->whereBetween(DB::raw('DATE(created_at)'), [$request->from, $request->to]);
        if (isset($request->user_id))
            $invoices->where('user_id', $request->user_id);
        $invoices = $invoices->paginate(config('admin.pagination'));
        $sum = $invoices->sum('total_price');
        return view('admin.invoices.index', compact('invoices', 'sum', 'users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
       
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }
}