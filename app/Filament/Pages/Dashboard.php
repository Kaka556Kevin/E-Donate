<?php

namespace App\Filament\Pages;

use App\Models\FormDonasi;
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
            ->query(FormDonasi::query())
            ->columns([
                TextColumn::make('created_at')
                    ->label('Tanggal Donasi')
                    ->date('M d Y')
                    ->sortable(),
                TextColumn::make('nama')
                    ->label('Nama')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('nominal')
                    ->label('Nominal')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('kontak')
                    ->label('Kontak')
                    ->sortable()
                    ->searchable(),
            ]);
    }
}
