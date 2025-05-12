<?php

namespace App\Filament\Pages;

use App\Models\FormDonasi;
use Filament\Pages\Page;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\BulkAction;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class Dashboard extends Page implements Tables\Contracts\HasTable
{
    use Tables\Concerns\InteractsWithTable;

    protected static ?string $navigationIcon = 'heroicon-o-home';
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
                    ->searchable()
                    ->prefix('Rp ')
                    ->formatStateUsing(fn($state) => number_format($state, 0, ',', '.')),
                TextColumn::make('kontak')
                    ->label('Kontak')
                    ->sortable()
                    ->searchable(),
            ])
            ->actions([
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                \Filament\Tables\Actions\BulkActionGroup::make([
                    \Filament\Tables\Actions\BulkAction::make('delete')
                        ->label('Hapus Terpilih')
                        ->color('danger')
                        ->icon('heroicon-m-trash')
                        ->action(fn(Collection $records) => $records->each->delete())
                        ->requiresConfirmation(),
                ])->label('Delete All'),
            ]);
    }
}
