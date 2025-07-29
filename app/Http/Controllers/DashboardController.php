<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Client;
use App\Models\Order;
use App\Models\Category;
use App\Models\Product;

class DashboardController extends Controller
{
    public function index()
    {
        $users = User::where('type_id', 1)->count();
        $clints = Client::count();
        $products = Product::count();
        $orders = Order::count();
        $categories = Category::count();
        return view('admin.dashboard', compact('users', 'clints', 'products', 'orders', 'categories'));
    }
}
