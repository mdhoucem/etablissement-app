<?php

namespace App\Filament\Resources\GalerieMediaResource\Pages;

use App\Filament\Resources\GalerieMediaResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListGalerieMedia extends ListRecords
{
    protected static string $resource = GalerieMediaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
