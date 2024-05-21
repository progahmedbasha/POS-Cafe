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
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Order::paginate(config('admin.pagination'));
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

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // $order_number = Order::get()->last()->number + 1;
        // return $request;
        if($request->table_id !== null) {
            $order = new Order();
            $order->number = $request->order_number;
            $order->user_id = auth()->user()->id;
            $order->client_id = $request->client_id;
            $order->service_id = $request->table_id;
            $order->discount = $request->discount;
            if ($request->total_price !== null) {
                $order->total_price = $request->total_price;
            } else {
                $total = 0;
                foreach ($request->row_product_id as $productId) {
                    $product = Product::find($productId);
                    if ($product) {
                        $total += $product->price;
                    }
                }
                $order->total_price = $total;
            }

            $order->type = 1;
            $order->status = 1;
            $order->save();
            // في حالة لو بيعمل ريكويست اكتر من منتج ومستخدم اجاكس ومش محدد كمية
            if ($request->total_price !== null) {
                $countItems = count($request->product_id);
                for ($i = 0; $i < $countItems; $i++) {
                    $prod = Product::find($request->product_id[$i]);
                    $order_items = new OrderItem();
                    $order_items->order_id = $order->id;
                    $order_items->product_id = $request->product_id[$i];
                    $order_items->price = $prod->price;
                    $order_items->qty = $request->qty[$i];
                    $order_items->total_cost = $prod->price * $request->qty[$i];
                    $order_items->save();
                }
            // في حالة لو بيعمل ريكويست اكتر من منتج من غير مايساخدم اجاكس ومش محدد كمية
            } else {
                $countItems = count($request->row_product_id );
                for ($i = 0; $i < $countItems; $i++) {
                    $prod = Product::find($request->row_product_id [$i]);
                    $order_items = new OrderItem();
                    $order_items->order_id = $order->id;
                    $order_items->product_id  = $request->row_product_id [$i];
                    $order_items->price = $prod->price;
                    $order_items->qty = 1;
                    $order_items->total_cost = $prod->price * 1;
                    $order_items->save();
                }
            }
        }
        elseif ($request->room_id !== null){
            $order = new Order();
            $order->number = $request->order_number;
            $order->user_id = auth()->user()->id;
            $order->client_id = $request->client_id;
            $order->service_id = $request->room_id;
            $order->start_time = \Carbon\Carbon::now('Africa/Cairo');
            $order->discount = $request->discount;
            // $order->total_price = $request->total_price;
            $order->type = 2;
            $order->status = 1;
            $order->save();
            if ($request->product_id != null) {
                $countItems = count($request->product_id);
                for ($i = 0; $i < $countItems; $i++) {
                    $prod = Product::find($request->product_id[$i]);
                    $order_items = new OrderItem();
                    $order_items->order_id = $order->id;
                    $order_items->product_id = $request->product_id[$i];
                    $order_items->price = $prod->price;
                    if ($request->qty != null) {
                        $order_items->qty = $request->qty[$i];
                        $order_items->total_cost = $prod->price * $request->qty[$i];
                    } else {
                        $order_items->total_cost = $prod->price;
                    }
                    $order_items->save();
                }
            }
            elseif ($request->row_product_id != null) {
                $countItems = count($request->row_product_id);
                for ($i = 0; $i < $countItems; $i++) {
                    $prod = Product::find($request->row_product_id[$i]);
                    $order_items = new OrderItem();
                    $order_items->order_id = $order->id;
                    $order_items->product_id = $request->row_product_id[$i];
                    $order_items->price = $prod->price;
                    if ($request->qty != null) {
                        $order_items->qty = $request->qty[$i];
                        $order_items->total_cost = $prod->price * $request->qty[$i];
                    } else {
                        $order_items->total_cost = $prod->price;
                    }
                    $order_items->save();
                }
            }
        }
        else {
            $products = OrderSale::where('order_number', $request->order_number)->delete();
            return redirect()->back()->with('error', 'خطـأ بتسجيل الأوردر برجاء تحديد الطلب( طاولة أو روم)');
        }
        $products = OrderSale::where('order_number', $request->order_number)->delete();
        return redirect()->back()->with('success', 'Added Successfully');
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
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('groups.index')->with('success', 'Deleted Successfully');
    }

    public function closeTime($id)
    {
        $order_room = Order::findOrFail($id);
        $order_room->update(['end_time' => now()->tz('Africa/Cairo')]);
        return redirect()->back()->with('success', 'Time Stopped Successfully');
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

            if ($product) {
                // If the product already exists, update its quantity and total cost
                $prod = Product::find($request->row_product_id[$i]);
                $product->qty += $request->qty; // Increment the quantity
                $product->total_cost += $prod->price * $request->qty[$i]; // Update total cost
                $product->save();
            } else {
                // If the product doesn't exist, create a new record
                $prod = Product::find($request->row_product_id[$i]);
                $product = new OrderSale();
                $product->order_number = $order_number;
                $product->product_id = $request->row_product_id[$i];
                $product->price = $prod->price;
                $product->qty = $request->qty ?? 1;
                $product->total_cost = $prod->price * $product->qty;
                $product->save();
            }
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
        $product->update(['qty' => $new_qty]);
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
}