<?php

namespace App\Filament\Resources\KelolaDonasiResource\Pages;

use App\Filament\Resources\KelolaDonasiResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListKelolaDonasis extends ListRecords
{
    protected static string $resource = KelolaDonasiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
