<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Exports\UsersExport;
use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\ListRecords;
use Maatwebsite\Excel\Facades\Excel;

class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            $this->getExportAction(),
            Actions\CreateAction::make(),
        ];
    }

    private function getExportAction()
    {
        return Action::make('export')
        ->label(__('resources.user.export.all'))
        ->icon('heroicon-o-arrow-down-on-square-stack')
        ->action('exportAllUsers')
        ->color('success');
    }

    public function exportAllUsers()
    {
        return Excel::download(new UsersExport, 'users.csv');
    }

}
