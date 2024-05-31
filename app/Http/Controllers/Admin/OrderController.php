<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreOrderRequest;
use App\Models\Client;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderSale;
use App\Models\Product;
use App\Models\Service;
use DB;
use Illuminate\Http\Request;

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
    public function create()
    {
        $products = Product::all();
        $clients = Client::all();
        $tabels = Service::whereType(1)->get();
        $rooms = Service::whereType(2)->get();
        $active_tables = Order::whereType(1)->whereStatus(1)->get();
        $active_rooms = Order::whereType(2)->whereStatus(1)->get();
        $empty = Order::get();
        if ($empty->count() < 1)
        {
            $order_number = 1;
        }
        else {
            $order_number = Order::get()->last()->number + 1;
        }
        return view('admin.orders.create', compact('products', 'clients', 'tabels', 'rooms', 'active_tables', 'active_rooms', 'order_number'));
    }

    // public function store(Request $request)
    // {
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
    //                 $order->total_price = $request->total_price ?? $this->calculateTotalPrice($request->product_id);
    //                 $order->type = 1;
    //                 $order->status = 1;
    //                 $order->note = $request->note;
    //                 $order->save();

    //                 $this->saveOrderItems($request, $order->id);
    //             } else {
    //                 $order_exite->update(['note' => $request->note ]);
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
    //                 $order->type = 2;
    //                 $order->status = 1;
    //                 $order->note = $request->note;
    //                 $order->save();

    //                 if ($request->has('product_id')) {
    //                     $this->saveOrderItems($request, $order->id);
    //                 }
    //             } else {
    //                 if ($request->has('product_id')) {
    //                     $order_exite->update(['note' => $request->note ]);
    //                     $this->updateOrderItems($request, $order_exite);
    //                 }
    //             }
    //         } else {
    //             $products = OrderSale::where('order_number', $request->order_number)->delete();
    //             return redirect()->back()->with('error', 'خطـأ بتسجيل الأوردر برجـــاء تحديد الطلـب  ( طاولة أو روم) واختيار المنتجات');
    //         }

    //         $products = OrderSale::where('order_number', $request->order_number)->delete();

    //         DB::commit();
    //         return redirect()->back()->with('success', 'Added Successfully');
    //     } catch (Exception $e) {
    //         DB::rollBack();
    //         return redirect()->back()->with('error', 'Error occurred: ' . $e->getMessage());
    //     }
    // }
    public function store(Request $request)
    {
        // return $request;
        DB::beginTransaction();

        try {
            if ($request->table_id !== null && $request->has('product_id')) {
                $order_exite = Order::where('service_id', $request->table_id)->where('status', 1)->first();

                if ($order_exite == null) {
                    // Create new order if not found service
                    $order = new Order();
                    $order->number = $request->order_number;
                    $order->user_id = auth()->user()->id;
                    $order->client_id = $request->client_id;
                    $order->service_id = $request->table_id;
                    $order->discount = $request->discount;
                    $order->total_price = $this->calculateTotalPrice($request->product_id, $request->qty);
                    $order->type = 1;
                    $order->status = 1;
                    $order->note = $request->note;
                    $order->save();

                    $this->saveOrderItems($request, $order->id);
                } else {
                    $order_exite->update(['note' => $request->note]);
                    $this->updateOrderItems($request, $order_exite);
                }
            } elseif ($request->room_id !== null) {
                $order_exite = Order::where('service_id', $request->room_id)->where('status', 1)->first();

                if ($order_exite == null) {
                    // Create new order if not found service
                    $order = new Order();
                    $order->number = $request->order_number;
                    $order->user_id = auth()->user()->id;
                    $order->client_id = $request->client_id;
                    $order->service_id = $request->room_id;
                    $order->start_time = \Carbon\Carbon::now('Africa/Cairo');
                    $order->discount = $request->discount;
                    if($request->has('product_id'))
                    $order->total_price = $this->calculateTotalPrice($request->product_id, $request->qty);
                    $order->type = 2;
                    $order->status = 1;
                    $order->note = $request->note;
                    $order->save();

                    if ($request->has('product_id')) {
                        $this->saveOrderItems($request, $order->id);
                    }
                } else {
                    if ($request->has('product_id')) {
                        $order_exite->update(['note' => $request->note]);
                        $this->updateOrderItems($request, $order_exite);
                    }
                }
            } else {
                DB::table('order_sales')->truncate();
                return redirect()->back()->with('error', 'خطـأ بتسجيل الأوردر برجـــاء تحديد الطلـب  ( طاولة أو روم) واختيار المنتجات');
            }

            $products = OrderSale::where('order_number', $request->order_number)->delete();

            DB::commit();
            return redirect()->back()->with('success', 'Added Successfully');
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

// private function updateOrderItems($request, $order_exite)
// {
//     $countItems = count($request->product_id);
//     for ($i = 0; $i < $countItems; $i++) {
//         $prod = Product::find($request->product_id[$i]);
//         $order_exite->update(['total_price' => $order_exite->total_price + $prod->price]);

//         $orderItem = OrderItem::where('order_id', $order_exite->id)
//                               ->where('product_id', $request->product_id[$i])
//                               ->first();

//         if ($orderItem && $request->row_note == null) {
//             // Update the existing order item
//                 // dd($orderItem);
//             $orderItem->qty += $request->qty;
//             $orderItem->total_cost = $orderItem->qty * $prod->price;
//         //    $orderItem->note = $request->note;
//             $orderItem->save();
//         } else {
//                 // dd($request);
//             // Create a new order item
//             // $orderItem = OrderItem::create([
//             //     'order_id' => $order_exite->id,
//             //     'product_id' => $request->row_product_id[$i],
//             //     'qty' => $request->qty[$i] ?? 1,
//             //     'price' => $prod->price,
//             //     'total_cost' => $prod->price * ($request->qty ?? 1)
//             // ]);
//             if($request->row_note){
//             $orderItem = OrderItem::create([
//                 'order_id' => $order_exite->id,
//                 'product_id' => $request->product_id[$i],
//                 'qty' => $request->qty[$i] ?? 1,
//                 'price' => $prod->price,
//                 'total_cost' => $prod->price * ($request->qty[$i] ?? 1),
//                 'note' => $request->row_note[$i]
//             ]);
//             }else {
//                 $orderItem = OrderItem::create([
//                 'order_id' => $order_exite->id,
//                 'product_id' => $request->product_id[$i],
//                 'qty' => $request->qty[$i] ?? 1,
//                 'price' => $prod->price,
//                 'total_cost' => $prod->price * ($request->qty[$i] ?? 1),
//             ]);
//             }

//         }
//     }
// }
// private function updateOrderItems($request, $order_exite)
// {
//     $countItems = count($request->product_id);
//     for ($i = 0; $i < $countItems; $i++) {
//         $prod = Product::find($request->product_id[$i]);

//         $orderItem = OrderItem::where('order_id', $order_exite->id)
//                               ->where('product_id', $request->product_id[$i])
//                               ->first();

//         if ($orderItem && empty($request->row_note)) {
//             // Update the existing order item
//             $orderItem->qty += $request->qty[$i];
//             $orderItem->total_cost = $orderItem->qty * $prod->price;
//             $orderItem->save();
//         } else {
//             // Create a new order item
//             $orderItemData = [
//                 'order_id' => $order_exite->id,
//                 'product_id' => $request->product_id[$i],
//                 'qty' => $request->qty[$i] ?? 1,
//                 'price' => $prod->price,
//                 'total_cost' => $prod->price * ($request->qty[$i] ?? 1),
//             ];

//             if (!empty($request->row_note[$i])) {
//                 $orderItemData['note'] = $request->row_note[$i];
//             }

//             $orderItem = OrderItem::create($orderItemData);
//         }
//     }
//         // Update the order total price with just the product price
//         $order_exite->total_price += $request->total_price;
//         $order_exite->save();
// }
// private function updateOrderItems($request, $order_exite)
// {
//     $countItems = count($request->product_id);
//     $totalProductPrice = 0;

//     for ($i = 0; $i < $countItems; $i++) {
//         $prod = Product::find($request->product_id[$i]);

//         $orderItem = OrderItem::where('order_id', $order_exite->id)
//                               ->where('product_id', $request->product_id[$i])
//                               ->first();

//         if ($orderItem && empty($request->row_note)) {
//             // Update the existing order item
//             $orderItem->qty += $request->qty[$i];
//             $orderItem->total_cost = $orderItem->qty * $prod->price;
//             $orderItem->save();
//         } else {
//             // Create a new order item
//             $orderItemData = [
//                 'order_id' => $order_exite->id,
//                 'product_id' => $request->product_id[$i],
//                 'qty' => $request->qty[$i] ?? 1,
//                 'price' => $prod->price,
//                 'total_cost' => $prod->price * ($request->qty[$i] ?? 1),
//             ];

//             if (!empty($request->row_note[$i])) {
//                 $orderItemData['note'] = $request->row_note[$i];
//             }

//             $orderItem = OrderItem::create($orderItemData);
//         }

//         $totalProductPrice += $prod->price * ($request->qty[$i] ?? 1);
//     }

//     $order_exite->total_price += $totalProductPrice;

//     // if ($order_exite->end_time) {
//     //     // Calculate the play time price
//     //     $startTime = \Carbon\Carbon::parse($order_exite->start_time);
//     //     $endTime = \Carbon\Carbon::parse($order_exite->end_time);
//     //     $durationInSeconds = $startTime->diffInSeconds($endTime);
//     //     $pricePerHour = $order_exite->service->ps_price;
//     //     $totalPlayPrice = intval(($durationInSeconds / 3600) * $pricePerHour);

//     //     $order_exite->total_price += $totalPlayPrice;
//     // }

//     $order_exite->save();
// }
// private function updateOrderItems($request, $order_exite)
// {
//     $countItems = count($request->product_id);
//     $totalProductPrice = 0;

//     for ($i = 0; $i < $countItems; $i++) {
//         $prod = Product::find($request->product_id[$i]);

//         $orderItem = OrderItem::where('order_id', $order_exite->id)
//                               ->where('product_id', $request->product_id[$i])
//                               ->first();

//         if ($orderItem && empty($request->row_note)) {
//             // Update the existing order item
//             $orderItem->qty += $request->qty[$i];
//             $orderItem->total_cost = $orderItem->qty * $prod->price;
//             $orderItem->new_item_status = 0; // Update existing item status
//             $orderItem->save();
//         } else {


//     // First, set new_item_status to null for all items
//         $orderItems = OrderItem::where('order_id', $order_exite->id)
//                               ->where('product_id', $request->product_id[$i])
//                               ->get();
//     foreach($orderItems as $item){
//         if ($orderItem && $item->new_item_status == 1) {
//             $item->new_item_status = null;
//             $item->save();
//         }
//     }
//             // Create a new order item
//             $orderItemData = [
//                 'order_id' => $order_exite->id,
//                 'product_id' => $request->product_id[$i],
//                 'qty' => $request->qty[$i] ?? 1,
//                 'price' => $prod->price,
//                 'total_cost' => $prod->price * ($request->qty[$i] ?? 1),
//                 'new_item_status' => 1 // Set new item status to 1
//             ];

//             if (!empty($request->row_note[$i])) {
//                 $orderItemData['note'] = $request->row_note[$i];
//             }

//             $orderItem = OrderItem::create($orderItemData);
//         }

//         $totalProductPrice += $prod->price * ($request->qty[$i] ?? 1);
//     }

//     $order_exite->total_price += $totalProductPrice;
//     $order_exite->save();
// }
private function updateOrderItems($request, $order_exite)
{
    $countItems = count($request->product_id);
    $totalProductPrice = 0;

    for ($i = 0; $i < $countItems; $i++) {
        $prod = Product::find($request->product_id[$i]);

        // Check if the order item already exists
        $orderItem = OrderItem::where('order_id', $order_exite->id)
                              ->where('product_id', $request->product_id[$i])
                              ->first();

        if ($orderItem && empty($request->row_note[$i])) {
            // Update the existing order item
            $orderItem->qty += $request->qty[$i];
            $orderItem->total_cost = $orderItem->qty * $prod->price;
            $orderItem->new_item_status = 0; // Update existing item status
            $orderItem->save();
        } else {
            // Set new_item_status to null for all existing items with new_item_status = 1
            OrderItem::where('order_id', $order_exite->id)
                     ->where('new_item_status', 1)
                     ->update(['new_item_status' => null]);

            // Create a new order item
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
        }

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
    // public function store(Request $request)
    // {
    //     // $order_number = Order::get()->last()->number + 1;
    //     // return $request;
    //     if ($request->table_id !== null) {

    //         $order_exite = Order::where('service_id', $request->table_id)->where('status', 1)->first();
    //         if ($order_exite == null) 
    //         {

    //             // create new order if not found service 
    //             $order = new Order();
    //             $order->number = $request->order_number;
    //             $order->user_id = auth()->user()->id;
    //             $order->client_id = $request->client_id;
    //             $order->service_id = $request->table_id;
    //             $order->discount = $request->discount;
    //             if ($request->total_price !== null) {
    //                 $order->total_price = $request->total_price;
    //             } else {
    //                 $total = 0;
    //                 foreach ($request->row_product_id as $productId) {
    //                     $product = Product::find($productId);
    //                     if ($product) {
    //                         $total += $product->price;
    //                     }
    //                 }
    //                 $order->total_price = $total;
    //             }
    //             $order->type = 1;
    //             $order->status = 1;
    //             $order->save();
    //             // في حالة لو بيعمل ريكويست اكتر من منتج ومستخدم اجاكس ومش محدد كمية
    //             if ($request->total_price !== null) {
    //                 $countItems = count($request->product_id);
    //                 for ($i = 0; $i < $countItems; $i++) {
    //                     $prod = Product::find($request->product_id[$i]);
    //                     $order_items = new OrderItem();
    //                     $order_items->order_id = $order->id;
    //                     $order_items->product_id = $request->product_id[$i];
    //                     $order_items->price = $prod->price;
    //                     $order_items->qty = $request->qty[$i];
    //                     $order_items->total_cost = $prod->price * $request->qty[$i];
    //                     $order_items->save();
    //                 }
    //                 // في حالة لو بيعمل ريكويست اكتر من منتج من غير مايساخدم اجاكس ومش محدد كمية
    //             } else {
    //                 $countItems = count($request->row_product_id);
    //                 for ($i = 0; $i < $countItems; $i++) {
    //                     $prod = Product::find($request->row_product_id[$i]);
    //                     $order_items = new OrderItem();
    //                     $order_items->order_id = $order->id;
    //                     $order_items->product_id = $request->row_product_id[$i];
    //                     $order_items->price = $prod->price;
    //                     $order_items->qty = 1;
    //                     $order_items->total_cost = $prod->price * 1;
    //                     $order_items->save();
    //                 }
    //             }
    //         } else {
    //             // return $request;
    //              $countItems = count($request->row_product_id);
    //             for ($i = 0; $i < $countItems; $i++ ) {
    //                 $prod = Product::find($request->row_product_id[$i]);
    //                  $order_exite->update(['total_price' => $order_exite->total_price + $prod->price]);
                     
    //                 $orderItem = OrderItem::where('order_id', $order_exite->id)
    //                   ->where('product_id', $request->row_product_id[$i])
    //                   ->first();

    //                 if ($orderItem) {
    //                     // Update the existing order item
    //                     $orderItem->qty += $request->qty;
    //                     // $orderItem->price = $prod->price + 1;
    //                     $orderItem->total_cost = $orderItem->qty * $prod->price;
    //                     $orderItem->save();
    //                 } else {
    //                     // Create a new order item
    //                     $orderItem = OrderItem::create([
    //                         'order_id' => $order_exite->id,
    //                         'product_id' => $request->row_product_id[$i],
    //                         'qty' => $request->qty,
    //                         'price' => $prod->price + 1,
    //                         'total_cost' => $request->qty * $prod->price,
    //                     ]);
    //                 }

    //             }
    //             }
    //     }
    //     elseif ($request->room_id !== null){

            
    //         $order = new Order();
    //         $order->number = $request->order_number;
    //         $order->user_id = auth()->user()->id;
    //         $order->client_id = $request->client_id;
    //         $order->service_id = $request->room_id;
    //         $order->start_time = \Carbon\Carbon::now('Africa/Cairo');
    //         $order->discount = $request->discount;
    //         // $order->total_price = $request->total_price;
    //         $order->type = 2;
    //         $order->status = 1;
    //         $order->save();
    //         if ($request->product_id != null) {
    //             $countItems = count($request->product_id);
    //             for ($i = 0; $i < $countItems; $i++) {
    //                 $prod = Product::find($request->product_id[$i]);
    //                 $order_items = new OrderItem();
    //                 $order_items->order_id = $order->id;
    //                 $order_items->product_id = $request->product_id[$i];
    //                 $order_items->price = $prod->price;
    //                 if ($request->qty != null) {
    //                     $order_items->qty = $request->qty[$i];
    //                     $order_items->total_cost = $prod->price * $request->qty[$i];
    //                 } else {
    //                     $order_items->total_cost = $prod->price;
    //                 }
    //                 $order_items->save();
    //             }
    //         }
    //         elseif ($request->row_product_id != null) {
    //             $countItems = count($request->row_product_id);
    //             for ($i = 0; $i < $countItems; $i++) {
    //                 $prod = Product::find($request->row_product_id[$i]);
    //                 $order_items = new OrderItem();
    //                 $order_items->order_id = $order->id;
    //                 $order_items->product_id = $request->row_product_id[$i];
    //                 $order_items->price = $prod->price;
    //                 if ($request->qty != null) {
    //                     $order_items->qty = $request->qty[$i];
    //                     $order_items->total_cost = $prod->price * $request->qty[$i];
    //                 } else {
    //                     $order_items->total_cost = $prod->price;
    //                 }
    //                 $order_items->save();
    //             }
    //         }
    //     }
    //     else {
    //         $products = OrderSale::where('order_number', $request->order_number)->delete();
    //         return redirect()->back()->with('error', 'خطـأ بتسجيل الأوردر برجاء تحديد الطلب( طاولة أو روم)');
    //     }
    //     $products = OrderSale::where('order_number', $request->order_number)->delete();
    //     return redirect()->back()->with('success', 'Added Successfully');
    // }

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
    public function edit(Product $product)
    {
         return view('admin.products.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreProductRequest $request, Product $product)
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
        $order_room = Order::findOrFail($id);
        $endTime = now()->tz('Africa/Cairo');
        $order_room->update(['end_time' => $endTime]);

        // Calculate the play time price
        if ($order_room->start_time && $order_room->service->ps_price) {
            $startTime = \Carbon\Carbon::parse($order_room->start_time);
            $durationInSeconds = $startTime->diffInSeconds($endTime);
            $pricePerHour = $order_room->service->ps_price;
            $totalPlayPrice = intval(($durationInSeconds / 3600) * $pricePerHour);

            // Add the play time price to the total price
            $order_room->total_price += $totalPlayPrice;
            $order_room->save();
        }

        DB::commit();
        return redirect()->back()->with('success', 'Time Stopped Successfully');
    } catch (Exception $e) {
        DB::rollBack();
        return redirect()->back()->with('error', 'Error occurred: ' . $e->getMessage());
    }
}

    // public function closeTime($id)
    // {
    //     $order_room = Order::findOrFail($id);
    //     $order_room->update(['end_time' => now()->tz('Africa/Cairo')]);
    //     return redirect()->back()->with('success', 'Time Stopped Successfully');
    // }
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
        $startTime = \Carbon\Carbon::parse($order->start_time);
                $endTime = \Carbon\Carbon::parse($order->end_time);
                $durationInSeconds = $startTime->diffInSeconds($endTime);
                $price = $order->service->ps_price;
                $totalPrice = $durationInSeconds ? intval(($durationInSeconds / 3600) * $price) : 0;
        $total = $totalPrice + $order->orderItems->sum('total_cost');
        $order->update(['status' => 2 , 'total_price' => $total]);
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
        $orderItem->delete();
        // Check if the associated Order doesn't have any more OrderItems
        if ($orderItem->order->whereDoesntHave('orderItems')->where('type', 1)->exists()) {
            // Delete the Order
            $orderItem->order->delete();
        }
        // return ($origin_order);
        // if($origin_order->$orderItem->count() == 1){
        //     return 33;
        // }
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
}