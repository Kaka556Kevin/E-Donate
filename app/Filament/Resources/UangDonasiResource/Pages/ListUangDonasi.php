<?php

namespace App\Filament\Resources\UangDonasiResource\Pages;

use App\Filament\Resources\UangDonasiResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListUangDonasi extends ListRecords
{
    protected static string $resource = UangDonasiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
