<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DashboardResource\Pages;
use App\Filament\Resources\DashboardResource\RelationManagers;
use App\Models\Dashboard;
use App\Models\KelolaDonasi;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DashboardResource extends Resource
{
    protected static ?string $model = KelolaDonasi::class;

    protected static ?string $navigationIcon = 'heroicon-o-home';
    protected static ?string $pluralLabel = 'Dashboard';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('gambar')
                    ->sortable()->searchable()
                    ->label('Tanggal Donasi')
                    ->disk('public')
                    ->size(100)
                    ->url(fn($record) => asset('storage/' . $record->gambar)),
                TextColumn::make('nama')
                    ->sortable()->searchable()
                    ->label('ID'),
                TextColumn::make('deskripsi')
                    ->sortable()->searchable()
                    ->label('Nama'),
                TextColumn::make('target_terkumpul')
                    ->sortable()->searchable()
                    ->label('Jumlah Donasi'),
            ])
            ->filters([
                //
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDashboards::route('/'),
            'create' => Pages\CreateDashboard::route('/create'),
            'edit' => Pages\EditDashboard::route('/{record}/edit'),
        ];
    }
    public static function canCreate(): bool
    {
        return false;
    }
    public function getHeading(): string
    {
        return 'Donasi Terkini';
    }

    public static function getBreadcrumbs(): array
    {
        return [];
    }
}
