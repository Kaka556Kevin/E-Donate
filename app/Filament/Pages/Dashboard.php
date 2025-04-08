<?php

namespace App\Filament\Pages;

use App\Models\KelolaDonasi;
use Filament\Pages\Page;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;

class Dashboard extends Page implements Tables\Contracts\HasTable
{
    use Tables\Concerns\InteractsWithTable;

    protected static ?string $navigationIcon = 'heroicon-o-home';
    // protected static ?string $title = 'Donasi Terkini';
    protected static string $view = 'filament.pages.dashboard';

    public static function hasBreadcrumbs(): bool
    {
        return false;
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(KelolaDonasi::query())
            ->columns([
                ImageColumn::make('gambar')
                    ->label('Gambar')
                    ->disk('public')
                    ->size(80)
                    ->url(fn($record) => asset('storage/' . $record->gambar)),
                TextColumn::make('nama')
                    ->label('ID')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('deskripsi')
                    ->label('Nama')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('target_terkumpul')
                    ->label('Jumlah Donasi')
                    ->sortable()
                    ->searchable(),
            ]);
    }
}
