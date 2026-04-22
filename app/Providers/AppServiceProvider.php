<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Post;
use App\Models\User;

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
        // 👇 GLOBAL DATA CHO ADMIN LAYOUT
        View::composer('layouts.admin', function ($view) {

            $view->with([
                'totalPosts' => Post::count(),
                'todayPosts' => Post::whereDate('created_at', today())->count(),
                'totalUsers' => User::where('role', 'user')->count(),
                'totalViews' => Post::sum('views'),
            ]);

        });
    }
}
