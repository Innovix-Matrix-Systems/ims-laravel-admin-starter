<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewUser extends ViewRecord
{
    protected static string $resource = UserResource::class;
    protected function getHeaderActions(): array
    {
        if($this->record->isSuperAdmin()) {
            return [
                Actions\EditAction::make(),
            ];
        }
        return [
            Actions\EditAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
