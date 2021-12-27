<?php

namespace App\Providers;

use App\Models\BranchTable;
use App\Models\Order;
use App\Models\OrderedItem;
use App\Observers\OrderedItemObserver;
use App\Observers\OrderObserver;
use App\Observers\TableObserver;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
        Schema::defaultStringLength(191);
        foreach (glob(app_path().'/Helpers/*.php') as $filename)
        {
            require_once($filename);
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        BranchTable::observe(TableObserver::class);
        OrderedItem::observe(OrderedItemObserver::class);
        Order::observe(OrderObserver::class);
    }
}
