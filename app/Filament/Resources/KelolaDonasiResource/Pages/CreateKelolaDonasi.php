<?php

namespace App\Filament\Resources\KelolaDonasiResource\Pages;

use App\Filament\Resources\KelolaDonasiResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateKelolaDonasi extends CreateRecord
{
    protected static string $resource = KelolaDonasiResource::class;
    public function getTitle(): string
{
    return 'Tambah Donasi Baru';
}
}
