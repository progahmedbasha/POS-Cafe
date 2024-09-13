<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use App\Models\Service;
use App\Models\Shift;
use Illuminate\Http\Request;

class ExpensesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $expenses = Expense::paginate(config('admin.pagination'));
        return view('admin.expenses.index', compact('expenses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.expenses.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $isActiveShift = Shift::where('status', 1)->first();
        if($isActiveShift == null)
        {
            return redirect()->back()->with('error', 'برجاء فتح وردية جديده');
        }
        Expense::create([
            'user_id' => auth()->user()->id,
            'shift_id' => auth()->user()->getUserShift()->id,
            'price' => $request->price,
            'note' => $request->note
        ]);
        return redirect()->route('expenses.index')->with('success', 'Added Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Expense $expense)
    {
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $expense = Expense::find($id);
        return view('admin.expenses.edit', compact('expense'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $expense = Expense::find($id);
        $expense->update($request->all());
        return redirect()->route('expenses.index')->with('success', 'Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id )
    {
        $expense = Expense::find($id);
        $expense->delete();
        return redirect()->route('expenses.index')->with('success', 'Deleted Successfully');
    }
}