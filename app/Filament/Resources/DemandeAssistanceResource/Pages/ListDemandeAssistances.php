<?php

namespace App\Filament\Resources\DemandeAssistanceResource\Pages;

use App\Filament\Resources\DemandeAssistanceResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDemandeAssistances extends ListRecords
{
    protected static string $resource = DemandeAssistanceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
