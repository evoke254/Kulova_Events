<?php

namespace App\Providers;

use App\Models\Election;
use Illuminate\Support\ServiceProvider;
use Filament\Support\Colors\Color;
use Filament\Support\Facades\FilamentColor;

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
           FilamentColor::register([
            'danger' => Color::Red,
            'gray' => Color::Zinc,
            'info' => Color::Blue,
            'primary' => Color::Amber,
            'success' => Color::Green,
            'fuchsia' => Color::Fuchsia,
            'violet' => Color::Violet,

            'warning' => Color::Amber,
        ]);

           $elections = Election::get();
           foreach ($elections as $election){
                $elec = $election->load('elective_positions');
                foreach ($elec->elective_positions as $pstn){
                        foreach ($pstn->candidates as $cdt){
                        $cdt->election_id = $election->id;
                  //      $cdt->save();
                        }
                }
           }
    }
}
