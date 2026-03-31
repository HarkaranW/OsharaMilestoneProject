<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\SupportMessage;

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
        View::composer('admin.partials.topbar', function ($view) {
            $supportNotifications = SupportMessage::query()
                ->latest()
                ->take(5)
                ->get();

            $unreadSupportCount = SupportMessage::query()
                ->whereIn('status', ['new'])
                ->count();

            $view->with([
                'supportNotifications' => $supportNotifications,
                'unreadSupportCount' => $unreadSupportCount,
            ]);
        });
    }
}
