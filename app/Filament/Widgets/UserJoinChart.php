<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Filament\Widgets\ChartWidget;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Facades\Auth;

class UserJoinChart extends ChartWidget
{
    protected static ?string $pollingInterval = null;
    
    public function getHeading(): string|Htmlable|null
    {
        return __('widgets.chart.user.join_this_year');
    }

    public static function canView(): bool
    {
        return Auth::user()->isSuperAdmin();
    }

    protected function getData(): array
    {
        $users = User::all('id', 'name', 'created_at');
        $groupedUsers = $users->groupBy(function ($user) {
            return $user->created_at->format('m');
        });
        $monthlyCounts = [];
        foreach ($groupedUsers as $month => $usersInMonth) {
            $monthlyCounts[$month] = count($usersInMonth);
        }
        $monthsDataArray = array_pad([], 12, 0); // Initialize with 12 zeros
        foreach ($monthlyCounts as $month => $count) {
            $index = (int)$month - 1;
            $monthsDataArray[$index] = $count;
        }
        return [
            'datasets' => [
                [
                    'label' => 'User Created',
                    'data' => $monthsDataArray,
                ],
            ],
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
