<?php

namespace App\Providers;

use Carbon\Carbon;
use Filament\Facades\Filament;
use Filament\Navigation\NavigationItem;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        if ($this->app->environment('local')) {
            $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
            $this->app->register(TelescopeServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Filament::serving(function () {
        //     Filament::registerNavigationItems([
        //         NavigationItem::make('Profile Settings')
        //             ->url('/admin/users/settings')
        //             ->icon('heroicon-o-cog')
        //             ->activeIcon('heroicon-s-cog')
        //             ->group('Settings')
        //             ->sort(3),
        //     ]);
        // });
        // Filament::serving(function () {
        //     Config::set('app.locale', 'bn');
        //     Carbon::setLocale('bn');
        // });
    }
}
