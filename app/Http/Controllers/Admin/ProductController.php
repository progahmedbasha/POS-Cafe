<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreProductRequest;
use App\Models\Category;
use App\Models\Product;
use App\Models\OrderItem;
use App\Models\Shift;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // جلب التصنيفات
        $categories = Category::get();

        // جلب المنتجات مع البحث
        $products = Product::query();

        // التحقق من وجود بحث وتطبيقه
        if ($request->filled('search')) {
            $products->where('name', 'like', '%' . $request->search . '%');
        }

        // التحقق من وجود معرف التصنيف وتطبيقه
        if ($request->filled('category_id')) {
            $products->where('category_id', $request->category_id);
        }

        // تطبيق التصفيح
        $products = $products->paginate(config('admin.pagination'));

        // عرض النتائج في العرض المناسب
        return view('admin.products.index', compact('products', 'categories'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        $product = new Product();
        $product->name = $request->name;
        $product->price = $request->price;
        if (request()->photo) {
            $product->photo = $this->saveImage($request->photo, $product->image);
        }
        $product->category_id = $request->category_id;
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
    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreProductRequest $request, Product $product)
    {
        $product->name = $request->name;
        $product->price = $request->price;
        if (request()->photo) {
            $product->photo = $this->saveImage($request->photo, $product->image);
        }
        $product->category_id = $request->category_id;
        $product->save();
        return redirect()->route('products.index')->with('success', 'Updated Successfully');
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
    public function SodaMenuIndex()
    {
        $products = Product::where('category_id', 1)->get();
        return view('website.soda-menu', compact('products'));
    }
    public function productReports(Request $request)
    {
        $query = Product::query();
        $shifts = Shift::take(3)->orderBy('id', 'desc')->get(); // Fetch shifts for dropdown

        // Handle date filters
        $from = $to = null; // Initialize date range
        if ($request->has('from') && $request->has('to') && !empty($request->from) && !empty($request->to)) {
            $from = Carbon::parse($request->input('from'))->startOfDay();
            $to = Carbon::parse($request->input('to'))->endOfDay();

            $query->whereHas('orderItems', function ($q) use ($from, $to) {
                $q->whereBetween('created_at', [$from, $to]);
            });
        }

        // Handle product search
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->input('search') . '%');
        }

        // Filter products by shift
        if ($request->has('shift_id') && !empty($request->shift_id)) {
            $shiftId = $request->input('shift_id');

            $query->whereHas('orderItems.order', function ($q) use ($shiftId) {
                $q->where('shift_id', $shiftId);
            });
        }

        // Fetch products with pagination
        $products = $query->with(['orderItems.order'])->get();

        // Calculate totals for each product
        foreach ($products as $product) {
            $product->totalQty_shift = 0;
            $product->totalCost_shift = 0;

            // Sum `qty` and `total_cost` for each product based on the shift and date range
            $product->totalQty_shift = OrderItem::where('product_id', $product->id)
                ->whereHas('order', function ($q) use ($request) {
                    if ($request->has('shift_id') && !empty($request->shift_id)) {
                        $q->where('shift_id', $request->shift_id);
                    }
                })
                ->when($from && $to, function ($q) use ($from, $to) {
                    $q->whereBetween('created_at', [$from, $to]);
                })
                ->sum('qty');

            $product->totalCost_shift = OrderItem::where('product_id', $product->id)
                ->whereHas('order', function ($q) use ($request) {
                    if ($request->has('shift_id') && !empty($request->shift_id)) {
                        $q->where('shift_id', $request->shift_id);
                    }
                })
                ->when($from && $to, function ($q) use ($from, $to) {
                    $q->whereBetween('created_at', [$from, $to]);
                })
                ->sum('total_cost');
        }

        // Return data to the view
        return view('admin.products.reports', compact('products', 'shifts'));
    }
}