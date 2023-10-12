<?php

namespace App\Filament\Resources\RoleResource\Pages;

use App\Filament\Resources\RoleResource;
use App\Http\Traits\UserTrait;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Auth;

class EditRole extends EditRecord
{
    use UserTrait;
    protected static string $resource = RoleResource::class;

    protected function getHeaderActions(): array
    {
        //ignore the super admin role
        if($this->record->id == 1) {
            return [];
        }
        if(Auth::user()->hasRole($this->SUPER_ADMIN)) {
            return [
                Actions\DeleteAction::make(),
            ];
        }

        return [];

    }
}
