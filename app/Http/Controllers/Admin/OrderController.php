<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreOrderRequest;
use App\Models\Client;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderSale;
use App\Models\OrderTime;
use App\Models\Product;
use App\Models\Service;
use App\Models\Shift;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
// use Spatie\Activitylog\Models\Activity;
use App\Models\Activity;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Order::where('status', 2)->paginate(config('admin.pagination'));
        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    // public function create()
    // {
    //     $products = Product::all();
    //     $clients = Client::all();
    //     $tabels = Service::whereType(1)->get();
    //     $rooms = Service::whereType(2)->get();
    //     $active_tables = Order::whereType(1)->whereStatus(1)->get();
    //     $active_rooms = Order::whereType(2)->whereStatus(1)->get();
    //     $empty = Order::get();
    //     if ($empty->count() < 1)
    //     {
    //         $order_number = 1;
    //     }
    //     else {
    //         $order_number = Order::get()->last()->number + 1;
    //     }
    //     return view('admin.orders.create', compact('products', 'clients', 'tabels', 'rooms', 'active_tables', 'active_rooms', 'order_number'));
    // }
public function create()
{
    $products = Product::all();
    $clients = Client::all();
    $tabels = Service::whereType(1)->get();
    $rooms = Service::whereType(2)->get();
    $services = Service::all();
    // $active_tables = Order::whereType(1)->whereStatus(1)->get();
    $active_tables = Order::with('service')->whereType(1)->whereStatus(1)->get()->sortBy(function ($order) {
        return $order->service->name ?? '';
    });
    $active_rooms = Order::whereType(2)->whereStatus(1)->get()->sortBy(function ($order) {
        return $order->service->name ?? '';
    });
    $empty = Order::get();

    if ($empty->count() < 1) {
        $order_number = 1;
    } else {
        $order_number = Order::withTrashed()->get()->last()->number + 1;
    }

    // Check if there's an order to print
    if (session()->has('print_order_id')) {
        $orderId = session('print_order_id');
        $is_new_order = session('is_new_order', true); // default to true if not set
        session()->forget(['print_order_id', 'is_new_order']);

        if ($is_new_order) {
            return $this->printTableCaptinOrder($orderId);
        } else {
            return $this->printTableCaptinOrderNewItems($orderId);
        }
    }

    return view('admin.orders.create', compact('products', 'clients', 'tabels', 'rooms', 'services', 'active_tables', 'active_rooms', 'order_number'));
}



    // public function store(Request $request)
    // {
    //     // return $request;
    //     DB::beginTransaction();

    //     try {
    //         if ($request->table_id !== null && $request->has('product_id')) {
    //             $order_exite = Order::where('service_id', $request->table_id)->where('status', 1)->first();

    //             if ($order_exite == null) {
    //                 // Create new order if not found service
    //                 $order = new Order();
    //                 $order->number = $request->order_number;
    //                 $order->user_id = auth()->user()->id;
    //                 $order->client_id = $request->client_id;
    //                 $order->service_id = $request->table_id;
    //                 $order->discount = $request->discount;
    //                 $order->total_price = $this->calculateTotalPrice($request->product_id, $request->qty);
    //                 $order->type = 1;
    //                 $order->status = 1;
    //                 $order->note = $request->note;
    //                 $order->save();

    //                 $this->saveOrderItems($request, $order->id);
    //             } else {
    //                 $order_exite->update(['note' => $request->note]);
    //                 $this->updateOrderItems($request, $order_exite);
    //             }
    //         } elseif ($request->room_id !== null) {
    //             $order_exite = Order::where('service_id', $request->room_id)->where('status', 1)->first();

    //             if ($order_exite == null) {
    //                 // Create new order if not found service
    //                 $order = new Order();
    //                 $order->number = $request->order_number;
    //                 $order->user_id = auth()->user()->id;
    //                 $order->client_id = $request->client_id;
    //                 $order->service_id = $request->room_id;
    //                 $order->start_time = \Carbon\Carbon::now('Africa/Cairo');
    //                 $order->discount = $request->discount;
    //                 if($request->has('product_id'))
    //                 $order->total_price = $this->calculateTotalPrice($request->product_id, $request->qty);
    //                 $order->type = 2;
    //                 $order->status = 1;
    //                 $order->note = $request->note;
    //                 $order->save();

    //                 if ($request->has('product_id')) {
    //                     $this->saveOrderItems($request, $order->id);
    //                 }
    //             } else {
    //                 if ($request->has('product_id')) {
    //                     $order_exite->update(['note' => $request->note]);
    //                     $this->updateOrderItems($request, $order_exite);
    //                 }
    //             }
    //         } else {
    //             DB::table('order_sales')->truncate();
    //             return redirect()->back()->with('error', 'خطـأ بتسجيل الأوردر برجـــاء تحديد الطلـب  ( طاولة أو روم) واختيار المنتجات');
    //         }

    //         $products = OrderSale::where('order_number', $request->order_number)->delete();

    //         DB::commit();
    //          // Store order ID in session for printing
    //     session(['print_order_id' => $order->id]);

    //     // Redirect to the create route
    //     return redirect()->route('orders.create')->with('success', 'Added Successfully');
    //     } catch (Exception $e) {
    //         DB::rollBack();
    //         return redirect()->back()->with('error', 'Error occurred: ' . $e->getMessage());
    //     }
    // }
public function store(Request $request)
{
    // return $request;
    $isActiveShift = Shift::where('status', 1)->first();
    if($isActiveShift == null)
    {
        return redirect()->back()->with('error', 'برجاء فتح وردية جديده');
    }

    DB::beginTransaction();

    try {
        if ($request->table_id !== null && $request->has('product_id')) {
            $order_exite = Order::where('service_id', $request->table_id)->where('status', 1)->first();

            if ($order_exite == null) {
                // Create new order if not found service
                $order = new Order();
                $order->number = $request->order_number;
                $order->user_id = auth()->user()->id;
                $order->shift_id = auth()->user()->getUserShift()->id;
                $order->client_id = $request->client_id;
                $order->service_id = $request->table_id;
                $order->discount = $request->discount;
                // $order->total_price = $this->calculateTotalPrice($request->product_id, $request->qty);
                $order->type = 1;
                $order->status = 1;
                $order->note = $request->note;
                $order->save();

                $this->saveOrderItems($request, $order->id);
                // start new save sum
                $order_total_items = $order->orderItems->sum('total_cost');
                $order->update(['total_price' => $order_total_items]);
                // end new save sum
                    if (!$request->has('add_water')) {
                        // Set session variables for new order
                        session(['print_order_id' => $order->id, 'is_new_order' => true]);
                    }
            } else {
                $order_exite->update(['note' => $request->note]);
                $this->updateOrderItems($request, $order_exite);

                    if (!$request->has('add_water')) {
                        // Set session variables for existing order with new items
                        session(['print_order_id' => $order_exite->id, 'is_new_order' => false]);
                    }
            }
        } elseif ($request->room_id !== null) {
            $order_exite = Order::where('service_id', $request->room_id)->where('status', 1)->first();

            if ($order_exite == null) {
                // Create new order if not found service
                $order = new Order();
                $order->number = $request->order_number;
                $order->user_id = auth()->user()->id;
                $order->shift_id = auth()->user()->getUserShift()->id;
                $order->client_id = $request->client_id;
                $order->service_id = $request->room_id;
                // $order->start_time = \Carbon\Carbon::now('Africa/Cairo');
                $order->discount = $request->discount;
                // if($request->has('product_id'))
                    // $order->total_price = $this->calculateTotalPrice($request->product_id, $request->qty);
                $order->type = 2;
                $order->status = 1;
                $order->note = $request->note;
                $order->save();

                //save ordertimes
                $order_time = OrderTime::create(['order_id' => $order->id, 'start_time' => \Carbon\Carbon::now('Africa/Cairo')]);

                if ($request->has('product_id')) {
                    $this->saveOrderItems($request, $order->id);
                }
                // start new save sum
                if($request->has('product_id')){
                    $order_total_items = $order->orderItems->sum('total_cost');
                    $order->update(['total_price' => $order_total_items]);
                }
                // end new save sum
                    if (!$request->has('add_water')) {
                        // Set session variables for new order
                        session(['print_order_id' => $order->id, 'is_new_order' => true]);
                    }
            } else {
                if ($request->has('product_id')) {
                    $order_exite->update(['note' => $request->note]);
                    $this->updateOrderItems($request, $order_exite);

                        if (!$request->has('add_water')) {
                            // Set session variables for existing order with new items
                            session(['print_order_id' => $order_exite->id, 'is_new_order' => false]);
                        }
                }
            }
        } else {
            DB::table('order_sales')->truncate();
            return redirect()->back()->with('error', 'خطـأ بتسجيل الأوردر برجـــاء تحديد الطلـب  ( طاولة أو روم) واختيار المنتجات');
        }

        $products = OrderSale::where('order_number', $request->order_number)->delete();

        DB::commit();
        return redirect()->route('orders.create'); // Redirect to create route
    } catch (Exception $e) {
        DB::rollBack();
        return redirect()->back()->with('error', 'Error occurred: ' . $e->getMessage());
    }
}





private function saveOrderItems($request, $orderId)
{
        // dd($request);
        if($request->row_product_id != null)
        {
            $product_id = $request->row_product_id;
        } else {
            $product_id = $request->product_id;
        }
    $countItems = count($product_id);
    for ($i = 0; $i < $countItems; $i++) {
        $prod = Product::find($product_id[$i]);
        $orderItem = new OrderItem();
        $orderItem->order_id = $orderId;
        $orderItem->product_id = $product_id[$i];
        $orderItem->price = $prod->price;
        $orderItem->qty = $request->qty[$i] ?? 1;
        $orderItem->total_cost = $prod->price * ($request->qty[$i] ?? 1);
        if($request->row_note)
        $orderItem->note = $request->row_note[$i];
        $orderItem->save();
    }
}

private function updateOrderItems($request, $order_exite)
{
    $countItems = count($request->product_id);
    $totalProductPrice = 0;

    // Set new_item_status to null for all existing items with new_item_status = 1
    OrderItem::where('order_id', $order_exite->id)
             ->where('new_item_status', 1)
             ->update(['new_item_status' => null]);

    for ($i = 0; $i < $countItems; $i++) {
        $prod = Product::find($request->product_id[$i]);

        // Always create a new order item
        $orderItemData = [
            'order_id' => $order_exite->id,
            'product_id' => $request->product_id[$i],
            'qty' => $request->qty[$i] ?? 1,
            'price' => $prod->price,
            'total_cost' => $prod->price * ($request->qty[$i] ?? 1),
            'new_item_status' => 1 // Set new item status to 1
        ];

        if (!empty($request->row_note[$i])) {
            $orderItemData['note'] = $request->row_note[$i];
        }

        OrderItem::create($orderItemData);

        $totalProductPrice += $prod->price * ($request->qty[$i] ?? 1);
    }

    $order_exite->total_price += $totalProductPrice;
    $order_exite->save();
}






private function calculateTotalPrice($product_ids, $quantities)
{
    $total = 0;
    for ($i = 0; $i < count($product_ids); $i++) {
        $product = Product::find($product_ids[$i]);
        $total += $product->price * ($quantities[$i] ?? 1);
    }
    return $total;
}




    /**
     * Store a newly created resource in storage.
     */


    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        return view('admin.orders.show', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
         return view('admin.products.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        // $order->delete();
        return redirect()->route('orders.index')->with('success', 'Deleted Successfully');
    }

    public function closeTime($id)
    {
        DB::beginTransaction();

        try {
            $order_room = OrderTime::where('order_id', $id)->first();
            $endTime = now()->tz('Africa/Cairo');
            $order_room->update(['end_time' => $endTime]);

            // Calculate the play time price
            if ($order_room->start_time && $order_room->order->service->ps_price) {
                $startTime = \Carbon\Carbon::parse($order_room->start_time);
                 $durationInSeconds = $startTime->diffInSeconds($endTime);
                 $durationInHours = $durationInSeconds / 3600;
                $pricePerHour = $order_room->order->service->ps_price;

                // $totalPlayPrice = intval(($durationInSeconds / 3600) * $pricePerHour);

                $totalPlayPrice = $durationInHours * $pricePerHour;

                // Add the play time price to the total price
                $order_room->total_price = $totalPlayPrice;
                $order_room->save();

                $order = Order::where('id', $order_room->order_id)->first();
                    $order->total_price += $totalPlayPrice;
                    $order->save();
            }

            DB::commit();
            return redirect()->back()->with('success', 'Time Stopped Successfully');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Error occurred while closing time for order ID ' . $id . ': ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error occurred: ' . $e->getMessage());
        }
    }
    public function fetchBlock(Request $request)
    {
        $empty = Order::get();
        if ($empty->count() < 1)
        {
            $order_number = 1;
        }
        else {
            $order_number = Order::get()->last()->number + 1;
        }
        $countItems = count($request->row_product_id);
        for ($i = 0; $i < $countItems; $i++) {
            $product = OrderSale::where('product_id', $request->row_product_id[$i])
                                ->where('order_number', $order_number)
                                ->first();

            // if ($product) {
            //     // If the product already exists, update its quantity and total cost
            //     $prod = Product::find($request->row_product_id[$i]);
            //     $product->qty += $request->qty; // Increment the quantity
            //     $product->total_cost += $prod->price * $request->qty[$i]; // Update total cost
            //     $product->save();
            // } else {
                // If the product doesn't exist, create a new record
                $prod = Product::find($request->row_product_id[$i]);
                $product = new OrderSale();
                $product->order_number = $order_number;
                $product->product_id = $request->row_product_id[$i];
                $product->price = $prod->price;
                $product->qty = $request->qty ?? 1;
                $product->total_cost = $prod->price * $product->qty;
                $product->save();
            // }
        }
        $products = OrderSale::all();
        $html = view('admin.orders.add-block-fetch', compact('products'))->render();
        return response()->json(['status' => true, 'result' => $html]);
    }
    public function printTable($id)
    {
        $order = Order::with('orderItems')->findOrFail($id);
        $order->update(['status' => 2]);
        return view('admin.orders.print', compact('order'));
    }
    public function printTableReceipt($id)
    {
        $order = Order::with('orderItems')->findOrFail($id);
        $order->update(['is_printed' => 1]);
        return view('admin.orders.print', compact('order'));
    }
    public function printTableCaptinOrder($id)
    {
        $order = Order::with('orderItems')->findOrFail($id);
        $items_order_note = '';
        return view('admin.orders.print-captin-order', compact('order', 'items_order_note'));
    }
    // to print new items captin order
    public function printTableCaptinOrderNewItems($id)
    {
        $order = Order::with(['orderItems' => function ($query) {
            $query->where('new_item_status', 1);
        }])->findOrFail($id);
        $items_order_note = 'منتجات جديده لأوردر قديم';
        return view('admin.orders.print-captin-order', compact('order', 'items_order_note'));
    }
    public function printRoom($id)
    {
        $order = Order::with('orderItems')->findOrFail($id);
        $startTime = \Carbon\Carbon::parse($order->orderTimes[0]->start_time);
        $endTime = \Carbon\Carbon::parse($order->orderTimes[0]->end_time);
                $durationInSeconds = $startTime->diffInSeconds($endTime);
                $price = $order->service->ps_price;
                $totalPrice = $durationInSeconds ? intval(($durationInSeconds / 3600) * $price) : 0;
        $total = $totalPrice + $order->orderItems->sum('total_cost');
        $order->update(['status' => 2 , 'total_price' => $total]);
        return view('admin.orders.print', compact('order'));
    }
    public function printRoomReciept($id)
    {
        $order = Order::with('orderItems')->findOrFail($id);
        $order->update(['is_printed' => 1]);
        $startTime = \Carbon\Carbon::parse($order->orderTimes[0]->start_time);
        $endTime = \Carbon\Carbon::parse($order->orderTimes[0]->end_time);
        $durationInSeconds = $startTime->diffInSeconds($endTime);
        $price = $order->service->ps_price;
        $totalPrice = $durationInSeconds ? intval(($durationInSeconds / 3600) * $price) : 0;
        $total = $totalPrice + $order->orderItems->sum('total_cost');
        return view('admin.orders.print', compact('order'));
    }
    public function updateQtyAjax (Request $request)
    {
        $new_qty = $request->qty;
        $product = OrderSale::where('id', $request->product_id)->first();
        $old_qty = $product->qty;
        $product->update(['qty' => $new_qty, 'total_cost' => $new_qty * $product->price]);
        $total_price_item = $request->qty * $request->price;
        return response()->json(['status' => true, 'total_price_item' => $total_price_item]);
    }
    public function saleAjaxDestroy (Request $request)
    {
        $id = $request->id_product;
        $row = OrderSale::where('id', $id)->first();
        $price = $row->qty * $row->price;
        $row->delete();
        return response()->json([
            'success' => 'Record deleted successfully!',
            'price' => $price,
        ]);
    }
    public function ItemAjaxDestroy(Request $request)
    {
        $orderItem = OrderItem::find($request->item_id);
        $origin_order = $orderItem->order;

        // Recalculate total price after removing the item
        // $orderItem->delete();
        OrderItem::where('id', $request->item_id)->delete();

        $totalPrice = $origin_order->orderItems->sum('total_cost');
        $origin_order->update(['total_price' => $totalPrice]);

        // Check if the associated Order doesn't have any more OrderItems
        if ($origin_order->orderItems->isEmpty() && $origin_order->type == 1) {
            // Delete the Order
            $origin_order->delete();
        }

        return response()->json([
            'success' => 'Record deleted successfully!',
        ]);
    }

    public function updateNoteAjax(Request $request)
    {
        $orderItem = OrderSale::where('id', $request->product_id)->first();
        if ($orderItem) {
            $orderItem->note = $request->note;
            $orderItem->save();
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false], 404);
    }
    public function changeTable(Order $order, Request $request)
    {
        $service = Service::find($request->table_id);
        if($service->type == 2){
            $order->update(['service_id'=> $request->table_id,'type' => $service->type]);
            $order->orderTimes()->create(['order_id' => $order->id, 'start_time' => \Carbon\Carbon::now('Africa/Cairo')]);
        } else {
            $order->update(['service_id'=> $request->table_id,'type' => $service->type]);
        }
        return redirect()->back()->with('success', 'Updated Successfully');
    }
    public function changeRoom(Order $order, Request $request)
    {
        // return $order;
        $service = Service::find($request->table_id);

        if ($order->type == 2 && $order->orderTimes[0]->end_time == null) {
            $this->closeTime($order->id);
            $order->update(['service_id'=> $request->table_id,'type' => $service->type]);
        } else {
            $order->update(['service_id'=> $request->table_id,'type' => $service->type]);
        }
        return redirect()->back()->with('success', 'Updated Successfully');
    }
    public function editStartTime($id, Request $request)
    {
        $order_time = OrderTime::where('order_id', $id)->first();
        // Get the original start_time from the database
        $existingStartTime = Carbon::parse($order_time->start_time);
        // Extract the date part and apply the new time from the request
        $newStartTime = $existingStartTime->setTimeFromTimeString($request->start_time);
        // Update the record with the new time (keeping the original date)
        $order_time->update(['start_time' => $newStartTime]);
        return redirect()->back()->with('success', 'Updated Successfully');
    }

    public function ordersLogs(Request $request)
{
    $orders = Order::withTrashed();

    if ($request->filled('shift_id')) {
        $orders->where('shift_id', $request->shift_id);
    }

    if ($request->filled('number')) {
        $orders->where('number', $request->number);
    }
    // Check if we need to include trashed orders
    if ($request->has('trashed') && $request->trashed == '1') {
        $orders->onlyTrashed();  // Filter to show only trashed orders
    }

    // Assign paginated result
    $orders = $orders->paginate(config('admin.pagination'));

    $shifts = Shift::where('status', 1)->orderBy('id', 'desc')->get();

    return view('admin.orders.logs.index', compact('orders', 'shifts'));
}

    public function orderLogShow($id)
    {
        
        $logs = Activity::where('subject_type', Order::class)
               ->where('subject_id', $id)
               ->get();
        return view('admin.orders.logs.show', compact('logs'));
    }
}