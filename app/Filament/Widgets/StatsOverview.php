<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected static ?string $pollingInterval = null;
    
    protected function getStats(): array
    {
        $users = User::with('roles')->get(['id','is_active']);
        $totalCount = $users->count();
        $totalAdmins = $users->filter(function ($user) {
            return $user->roles->contains('name', 'Admin');
        })->count();
        $totalActiveUsers = $users->filter(function ($user) {
            return $user->is_active;
        })->count();
        return [
            Stat::make(__('widgets.stat.total_user'), $totalCount),
            Stat::make(__('widgets.stat.total_admin'), $totalAdmins),
            Stat::make(__('widgets.stat.total_active_user'), $totalActiveUsers),
        ];
    }
}
