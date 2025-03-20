<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Faker\Provider\Image;
use Filament\Tables\Table;
use App\Models\KelolaDonasi;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\KelolaDonasiResource\Pages;
use App\Filament\Resources\KelolaDonasiResource\RelationManagers;

class KelolaDonasiResource extends Resource
{
    protected static ?string $model = KelolaDonasi::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                Forms\Components\FileUpload::make('gambar')
                    ->image() // Hanya menerima gambar
                    ->directory('donasi')
                    ->required(),

                Forms\Components\TextInput::make('nama')
                    ->required()
                    ->maxLength(255),

                Forms\Components\Textarea::make('deskripsi')
                    ->required(),

                Forms\Components\TextInput::make('target_terkumpul')
                    ->numeric()
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('gambar')
                    ->disk('public')
                    ->size(100)
                    ->url(fn($record) => asset('storage/' . $record->gambar)),
                TextColumn::make('nama'),
                TextColumn::make('deskripsi'),
                TextColumn::make('target_terkumpul'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListKelolaDonasis::route('/'),
            'create' => Pages\CreateKelolaDonasi::route('/create'),
            'edit' => Pages\EditKelolaDonasi::route('/{record}/edit'),
        ];
    }
}
