<?php

namespace App\Http\Controllers;

use App\Models\Product;

class DashboardController extends Controller
{
    public function index()
    {
        $students = 1;
        $groups = 1;
        $levels = Product::count();
        $courses = 1;
        $classes = 1;
        return view('admin.dashboard', compact('students', 'groups', 'levels', 'courses', 'classes'));
    }
}
