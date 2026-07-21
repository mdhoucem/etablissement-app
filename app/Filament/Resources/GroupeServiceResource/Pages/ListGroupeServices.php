<?php

namespace App\Filament\Resources\GroupeServiceResource\Pages;

use App\Filament\Resources\GroupeServiceResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListGroupeServices extends ListRecords
{
    protected static string $resource = GroupeServiceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
