<?php

namespace App\Filament\Widgets;

use App\Enums\PaymentStatus;
use App\Models\CamperRegistration;
use App\Models\CampEvent;
use App\Models\GroupEvent;
use App\Models\Payment;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class CampStatsOverview extends BaseWidget
{
    protected static ?int $sort = 2;

    protected function getStats(): array
    {
        $totalRegistrations = CamperRegistration::count();
        $activeCampEventsCount = CampEvent::where('is_active', true)->count();
        $upcomingGroupEventsCount = GroupEvent::where('start_date', '>=', now())->count();

        $totalPaid = Payment::where('status', PaymentStatus::Paid)->sum('amount');
        $totalPending = Payment::where('status', PaymentStatus::Pending)->sum('amount');

        return [
            Stat::make('Total Registered Campers', $totalRegistrations)
                ->description($activeCampEventsCount.' Active Camp Events')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('primary'),

            Stat::make('Upcoming & Active Events', $activeCampEventsCount + $upcomingGroupEventsCount)
                ->description($upcomingGroupEventsCount.' Guest Group Retreats')
                ->descriptionIcon('heroicon-m-calendar-days')
                ->color('success'),

            Stat::make('Payments Collected', '$'.number_format($totalPaid, 2))
                ->description('Pending: $'.number_format($totalPending, 2))
                ->descriptionIcon('heroicon-m-currency-dollar')
                ->color('warning'),
        ];
    }
}
