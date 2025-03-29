<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UangDonasiResource\Pages;
use App\Filament\Resources\UangDonasiResource\RelationManagers;
use App\Models\UangDonasi;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UangDonasiResource extends Resource
{
    protected static ?string $model = UangDonasi::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $pluralLabel = 'Uang Donasi';
    protected static ?string $navigationLabel = 'Uang Donasi';

    public static function getModelLabel(): string
    {
        return 'Uang Donasi';
    }


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListUangDonasi::route('/'),
            'create' => Pages\CreateUangDonasi::route('/create'),
            'edit' => Pages\EditUangDonasi::route('/{record}/edit'),
        ];
    }
}
