<?php

namespace App\Livewire;

use App\Models\Event;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Livewire\Component;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Infolists\Concerns\InteractsWithInfolists;
use Filament\Infolists\Contracts\HasInfolists;

class ViewEvent extends Component implements HasForms, HasInfolists
{
    use InteractsWithInfolists;
    use InteractsWithForms;

    public Event $event;

    public function eventInfolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->record($this->event)
            ->schema([
                Section::make('Speakers')
                    ->description('Event speakers: Engage with knowledgeable individuals sharing insights and expertise at events. ')
                    ->schema([
                        RepeatableEntry::make('speakers')
                            ->label(false)
                            ->schema([
                                ImageEntry::make('image')->width(100)->height(100)->circular()->label(false),
                                TextEntry::make('speaker')->label('Name'),
                                TextEntry::make('topic')->columns(2),
                            ])
                            ->columns(4)
                    ]),

                Section::make('Exhibitors')
                    ->description('Event exhibitors: Explore and connect with companies showcasing their products and services at events ')
                    ->schema([
                        RepeatableEntry::make('exhibitors')
                            ->label(false)
                            ->schema([
                                ImageEntry::make('image')->width(100)->height(100)->circular()->label(false),
                                TextEntry::make('exhibitor')->label('Name'),
                                TextEntry::make('topic')->label(false)->columns(2),
                            ])
                            ->columns(4)
                    ]),
                Section::make('Sponsors')
                    ->description('Event sponsors: These are our supporters and patrons backing and contributing to event success. ')
                    ->schema([
                        RepeatableEntry::make('sponsors')
                            ->label(false)
                            ->schema([
                                ImageEntry::make('image')->width(100)->height(100)->circular()->label(false),
                                TextEntry::make('sponsor')->label('Name'),
                                TextEntry::make('topic')->label(false)->columns(2),
                            ])
                            ->columns(4)
                    ])
            ]);
    }
    public function render()
    {
        return view('livewire.view-event');
    }
}
