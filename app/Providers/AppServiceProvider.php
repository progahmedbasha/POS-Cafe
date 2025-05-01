<?php

namespace App\Providers;
use App\Models\Order;
use Spatie\Activitylog\Models\Activity;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

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
    }
}