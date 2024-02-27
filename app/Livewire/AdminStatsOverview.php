<?php

namespace App\Livewire;

use App\Models\Event;
use App\Models\Organization;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class AdminStatsOverview extends BaseWidget
{
    protected function getStats(): array
    {

        $sms_bal = $this->getSmsBal();
        $organizations = Organization::all()->skip(1)->count();
        $events = Event::get()->count();

        if (Auth::user()->role_id > 3){
            $org = Organization::find(Auth::user()->organization_id);
            if ($org){
                $events = $org->events()->count();
                $elections = $org->elections()->count();
            } else {
                $events = 'No Events';
                $elections = '--';
            }
            return [
                Stat::make('Total Events', $events),
                Stat::make('All Elections', $organizations),
            ];
        } else {
            return [
                Stat::make('Total Events', $events),
                Stat::make('Organizations', $organizations),
                Stat::make('SMS Balance', $sms_bal),
            ];
        }
    }

    protected function getSmsBal()
    {
        $params = [
            'user' => 'TEXT40',
            'pwd' => '6yb64be1'
        ];

        $response = Http::get('https://mshastra.com/balance.aspx', $params);
        return $response->body();
    }
}
