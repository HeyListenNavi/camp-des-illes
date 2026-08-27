<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\CamperRegistrations\CamperRegistrationResource;
use App\Filament\Resources\CampEvents\CampEventResource;
use App\Filament\Resources\GroupEvents\GroupEventResource;
use Filament\Widgets\Widget;

class WelcomeBannerWidget extends Widget
{
    protected string $view = 'filament.widgets.welcome-banner-widget';

    protected int|string|array $columnSpan = 'full';

    protected static ?int $sort = 1;

    public function getQuickLinks(): array
    {
        return [
            [
                'label' => '+ New Camper Registration',
                'url' => CamperRegistrationResource::getUrl('create'),
                'icon' => 'heroicon-o-user-plus',
            ],
            [
                'label' => '+ New Camp Event',
                'url' => CampEventResource::getUrl('create'),
                'icon' => 'heroicon-o-calendar',
            ],
            [
                'label' => '+ Book Group Retreat',
                'url' => GroupEventResource::getUrl('create'),
                'icon' => 'heroicon-o-user-group',
            ],
        ];
    }
}
