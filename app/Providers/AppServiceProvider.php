<?php

namespace App\Providers;
use App\Models\Order;
use App\Models\Shift;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Spatie\Activitylog\Models\Activity;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrap();

        // Order::deleting(function ($order) {
        //     activity('orders')
        //         ->performedOn($order)
        //         ->causedBy(auth()->user())
        //         ->withProperties([
        //             'id' => $order->id,
        //             'number' => $order->number,
        //             'user_id' => $order->user_id,
        //         ])
        //         ->log('تم حذف الطلب');
        // });
        View::composer(['admin.layouts.sidebar'], function($view) {
            $isActiveShift = Shift::where('status', 1)->first();
            $view->with('isActiveShift', $isActiveShift);
        });
    }
}