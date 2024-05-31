<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\InvoiceController;
use App\Http\Controllers\Admin\RoomController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::group(
    [
        'prefix' => 'admin',
        'middleware' => [ 'auth:sanctum' ,'Admin'],
    ],
    function () {
            Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
            Route::resource('products', ProductController::class);
            Route::resource('orders', OrderController::class);
            Route::post('add_row', [OrderController::class, 'fetchBlock'])->name('add_row');
            Route::get('close_time/{id}', [OrderController::class, 'closeTime'])->name('close_time');
            Route::get('print_table/{id}', [OrderController::class, 'printTable'])->name('print_table');
            Route::get('print_table_captin_order/{id}', [OrderController::class, 'printTableCaptinOrder'])->name('print_table_captin_order');
            // Route::get('print_table_captin_order/{id}', [OrderController::class, 'printTableCaptinOrder'])->name('print_table_captin_order');
            Route::get('print_table_captin_order_new_items/{id}', [OrderController::class, 'printTableCaptinOrderNewItems'])->name('print_table_captin_order_new_items');
            Route::get('print_room/{id}', [OrderController::class, 'printRoom'])->name('print_room');
            Route::post('update_qty_ajax', [OrderController::class, 'updateQtyAjax'])->name('update_qty_ajax');
            Route::post('/update-note-ajax', [OrderController::class, 'updateNoteAjax'])->name('update_note_ajax');
            Route::delete('sale_ajax_destroy', [OrderController::class, 'saleAjaxDestroy'])->name('sale_ajax_destroy');
            Route::delete('item_ajax_destroy', [OrderController::class, 'ItemAjaxDestroy'])->name('item_ajax_destroy');
            Route::resource('invoices', InvoiceController::class);
            Route::resource('rooms', RoomController::class);
    }
);
Route::get('/', function(){
        return view('website.index');
    })->name('website');
    Route::get('menu' , [ProductController::class, 'menu'])->name('menu');
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');