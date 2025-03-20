<?php

namespace App\Filament\Resources\UangDonasiResource\Pages;

use App\Filament\Resources\UangDonasiResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditUangDonasi extends EditRecord
{
    protected static string $resource = UangDonasiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
