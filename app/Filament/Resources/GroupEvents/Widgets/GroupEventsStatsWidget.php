<?php

namespace App\Filament\Resources\GroupEvents\Widgets;

use App\Enums\GroupEventStatus;
use App\Models\GroupEvent;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class GroupEventsStatsWidget extends BaseWidget
{
    protected function getStats(): array
    {
        $totalEvents = GroupEvent::count();
        $confirmedBookings = GroupEvent::where('status', GroupEventStatus::Confirmed)->count();
        $pendingInquiries = GroupEvent::whereIn('status', [
            GroupEventStatus::InquiryReceived,
            GroupEventStatus::ApplicationSent,
            GroupEventStatus::WaitingForDocuments,
            GroupEventStatus::DepositPending,
        ])->count();
        $totalGuests = (int) GroupEvent::sum('expected_attendees');

        return [
            Stat::make('Total Group Inquiries', (string) $totalEvents)
                ->description('Group retreat requests')
                ->descriptionIcon('heroicon-m-building-office-2')
                ->color('primary'),

            Stat::make('Confirmed Bookings', (string) $confirmedBookings)
                ->description('Approved retreat sessions')
                ->descriptionIcon('heroicon-m-check-badge')
                ->color('success'),

            Stat::make('Pending Inquiries', (string) $pendingInquiries)
                ->description('Inquiries in review / deposit pending')
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning'),

            Stat::make('Total Expected Guests', number_format($totalGuests))
                ->description('Cumulative retreat attendees')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('info'),
        ];
    }
}
