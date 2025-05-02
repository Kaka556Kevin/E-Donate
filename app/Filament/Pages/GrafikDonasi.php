<?php

namespace App\Filament\Pages;

use App\Models\KelolaDonasi;
use Filament\Pages\Page;
use Filament\Tables\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;

class GrafikDonasi extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';
    protected static string $view = 'filament.pages.grafik-donasi';

    protected static ?string $title = 'Grafik Donasi';

    public function getChartData(): array
    {
        // Ambil data untuk grafik
        $data = KelolaDonasi::all(['nama', 'donasi_terkumpul']);

        return [
            'labels' => $data->pluck('nama')->toArray(),
            'values' => $data->pluck('donasi_terkumpul')->map(fn($v) => (int)$v)->toArray(),
        ];
    }
}
