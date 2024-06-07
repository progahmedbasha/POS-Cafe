<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreProductRequest;
use App\Models\Category;
use App\Models\Product;
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
}