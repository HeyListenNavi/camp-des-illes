<?php

namespace App\Filament\Resources\CamperRegistrations\Widgets;

use App\Enums\RegistrationStatus;
use App\Models\CamperRegistration;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class RegistrationStatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $totalRegistrations = CamperRegistration::count();
        $confirmedCount = CamperRegistration::where('status', RegistrationStatus::Confirmed)->count();
        $pendingCount = CamperRegistration::where('status', RegistrationStatus::Pending)->count();
        $waitlistCount = CamperRegistration::whereIn('status', [RegistrationStatus::Waitlist, RegistrationStatus::Cancelled])->count();

        return [
            Stat::make('Total Registrations', (string) $totalRegistrations)
                ->description('All recorded session signups')
                ->descriptionIcon('heroicon-m-clipboard-document-check')
                ->color('primary'),

            Stat::make('Confirmed Registrations', (string) $confirmedCount)
                ->description('Confirmed & active spots')
                ->descriptionIcon('heroicon-m-check-badge')
                ->color('success'),

            Stat::make('Pending Applications', (string) $pendingCount)
                ->description('Awaiting confirmation / payment')
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning'),

            Stat::make('Waitlisted / Cancelled', (string) $waitlistCount)
                ->description('Queue and cancelled slots')
                ->descriptionIcon('heroicon-m-queue-list')
                ->color('gray'),
        ];
    }
}
