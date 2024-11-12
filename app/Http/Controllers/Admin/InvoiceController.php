<?php

namespace App\Http\Controllers\Admin;

use DB;
use App\Models\User;
use App\Models\Order;
use App\Models\Shift;
use App\Models\Expense;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // public function index(Request $request)
    // {
    //     $invoices = Order::with('user');
    //     $users = User::all();
    //     $shifts = Shift::take(3)->orderBy('id', 'desc')->get();
    //     $expenses = 0;
    //     if (isset($request->from) && isset($request->to)){
    //         $invoices = $invoices->whereBetween(DB::raw('DATE(updated_at)'), [$request->from, $request->to]);
    //         $expenses = Expense::whereBetween(DB::raw('DATE(updated_at)'), [$request->from, $request->to])->sum('price');
    //     }
    //     if (isset($request->user_id))
    //         $invoices->where('user_id', $request->user_id);
    //     if (isset($request->shift_id)){
    //     $invoices->where('shift_id', $request->shift_id);
    //     $expenses = Expense::where('shift_id', $request->shift_id)->whereBetween(DB::raw('DATE(updated_at)'), [$request->from, $request->to])->sum('price');
    //     }
    //     // $invoices = $invoices->paginate(config('admin.pagination'));
    //     $invoices = $invoices->where('status', 2)->paginate();
    //     $sum = $invoices->sum('total_price');
    //     $count = $invoices->count();
    //     $shift = Shift::find($request->shift_id);
    //     return view('admin.invoices.index', compact('invoices', 'sum', 'users', 'count', 'expenses', 'shifts', 'shift'));
    // }
    public function index(Request $request)
    {
        $invoices = Order::with('user');
        $users = User::all();
        $shifts = Shift::take(3)->orderBy('id', 'desc')->get();
        $expenses = 0;

        // Apply filters based on request parameters
        if (isset($request->from) && isset($request->to)){
            $invoices = $invoices->whereBetween(DB::raw('DATE(updated_at)'), [$request->from, $request->to]);
            $expenses = Expense::whereBetween(DB::raw('DATE(updated_at)'), [$request->from, $request->to])->sum('price');
        }

        if (isset($request->user_id)) {
            $invoices->where('user_id', $request->user_id);
        }

        if (isset($request->shift_id)) {
            $invoices->where('shift_id', $request->shift_id);
            $expenses = Expense::where('shift_id', $request->shift_id)
                ->whereBetween(DB::raw('DATE(updated_at)'), [$request->from, $request->to])
                ->sum('price');
        }

        // Filter by status
        $invoices->where('status', 2);

        // Get total sum and count before pagination
        $sum = $invoices->sum('total_price');
        $count = $invoices->count();

        // Paginate after getting the total sum and count
        // $invoices = $invoices->paginate(config('admin.pagination'));
        if ($request->shift_id || $request->user_id || $request->from || $request->to){
            $invoices = $invoices->get();
        } else
        {
            $invoices = $invoices->paginate(config('admin.pagination'));
        }

        $shift = Shift::find($request->shift_id);

        return view('admin.invoices.index', compact('invoices', 'sum', 'users', 'count', 'expenses', 'shifts', 'shift'));
    }




// public function index(Request $request)
// {
//     // احصل على جميع المستخدمين
//     $users = User::all();

//     // ابدأ استعلام الفواتير مع جلب المستخدمين المرتبطين
//     $invoices = Order::with('user');

//     // تحقق من وجود تاريخ البدء وتاريخ الانتهاء في الطلب
//     if ($request->filled('from') && $request->filled('to')) {
//         // تحويل التواريخ إلى نهاية اليوم لضمان تضمين اليوم الكامل
//         $from = $request->from . ' 00:00:00';
//         $to = $request->to . ' 23:59:59';
//         $invoices = $invoices->whereBetween('updated_at', [$from, $to]);
//     }

//     // تحقق من وجود معرف المستخدم في الطلب
//     if ($request->filled('user_id')) {
//         $invoices = $invoices->where('user_id', $request->user_id);
//     }

//     // اجلب الفواتير المصفاة
//    return $invoices = $invoices->get();

//     // احسب مجموع الأسعار
//     $sum = $invoices->sum('total_price');
//         $count = $invoices->count();
//     // اعرض النتائج في العرض المناسب
//     return view('admin.invoices.index', compact('invoices', 'sum', 'users', 'count'));
// }


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
