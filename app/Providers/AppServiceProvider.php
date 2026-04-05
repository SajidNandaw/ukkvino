<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

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
    View::composer('*', function ($view) {

        $totalCart = 0;

        if (Auth::check()) {
            $totalCart = DB::table('keranjang')
                ->where('user_id', Auth::id())
                ->count();
        }

        $view->with('totalCart', $totalCart);
    });
}
    }

