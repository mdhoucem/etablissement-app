<?php

namespace App\Filament\Resources\DemandeAssistanceResource\Pages;

use App\Filament\Resources\DemandeAssistanceResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDemandeAssistance extends EditRecord
{
    protected static string $resource = DemandeAssistanceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
