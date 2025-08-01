<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ShiftController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\InvoiceController;
use App\Http\Controllers\Admin\ClientController;
use App\Http\Controllers\Admin\RoomController;
use App\Http\Controllers\Admin\TableController;
use App\Http\Controllers\Admin\ExpensesController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\SettingController;
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
            Route::get('print_table_reciept/{id}', [OrderController::class, 'printTableReceipt'])->name('print_table_reciept');
            Route::get('print_table_captin_order/{id}', [OrderController::class, 'printTableCaptinOrder'])->name('print_table_captin_order');
            // Route::get('print_table_captin_order/{id}', [OrderController::class, 'printTableCaptinOrder'])->name('print_table_captin_order');
            Route::get('print_table_captin_order_new_items/{id}', [OrderController::class, 'printTableCaptinOrderNewItems'])->name('print_table_captin_order_new_items');
            Route::get('print_room/{id}', [OrderController::class, 'printRoom'])->name('print_room');
            Route::get('print_room_reciept/{id}', [OrderController::class, 'printRoomReciept'])->name('print_room_reciept');
            Route::post('update_qty_ajax', [OrderController::class, 'updateQtyAjax'])->name('update_qty_ajax');
            Route::post('/update-note-ajax', [OrderController::class, 'updateNoteAjax'])->name('update_note_ajax');
            Route::delete('sale_ajax_destroy', [OrderController::class, 'saleAjaxDestroy'])->name('sale_ajax_destroy');
            Route::delete('item_ajax_destroy', [OrderController::class, 'ItemAjaxDestroy'])->name('item_ajax_destroy');
            Route::resource('invoices', InvoiceController::class);
            Route::resource('clients', ClientController::class);
            Route::resource('rooms', RoomController::class);
            Route::resource('tables', TableController::class);
            Route::resource('expenses', ExpensesController::class);
            Route::patch('change_table/{order}', [OrderController::class, 'changeTable'])->name('change_table');
            Route::patch('change_room/{order}', [OrderController::class, 'changeRoom'])->name('change_room');
            Route::resource('shifts', ShiftController::class);
            Route::get('active-shift', [ShiftController::class, 'getActiveShift'])->name('active-shift');
            Route::post('close-shift', [ShiftController::class, 'closeShift'])->name('close-shift');
            Route::post('edit_start_time/{id}', [OrderController::class, 'editStartTime'])->name('edit_start_time');
            Route::get('product-reports', [ProductController::class, 'productReports'])->name('product-reports');
            Route::get('orders_logs', [OrderController::class, 'ordersLogs'])->name('orders_logs');
            Route::get('order_log_show/{id}', [OrderController::class, 'orderLogShow'])->name('order_log_show');
            Route::get('/settings', [SettingController::class, 'index'])->name('settings');
            Route::post('/settings', [SettingController::class, 'update'])->name('settings.update');
    }
);
    // Route::get('/', function(){
    //     return view('website.index');
    // })->name('website');
    Route::get('landing' , [HomeController::class, 'website'])->name('website');
    Route::get('menu' , [ProductController::class, 'menu'])->name('menu');
    Route::get('soda-menu', [ProductController::class, 'SodaMenuIndex'])->name('soda-menu');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');