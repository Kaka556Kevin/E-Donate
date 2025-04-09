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
use Filament\Forms\Components\TextInput\Mask;
use Filament\Tables\Columns\ImageColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\KelolaDonasiResource\Pages;
use App\Filament\Resources\KelolaDonasiResource\RelationManagers;

class KelolaDonasiResource extends Resource
{
    protected static ?string $model = KelolaDonasi::class;

    protected static ?string $navigationIcon = 'heroicon-o-squares-2x2';

    protected static ?string $pluralLabel = 'Kelola Donasi';
    protected static ?string $navigationLabel = 'Kelola Donasi';

    public static function getModelLabel(): string
    {
        return 'Donasi';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Kelola Donasi';
    }

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nama')
                    ->label('Nama Donasi')
                    ->required()
                    ->columnSpanFull(),

                Forms\Components\FileUpload::make('gambar')
                    ->label('Images')
                    ->required()
                    ->image()
                    ->columnSpanFull(),

                Forms\Components\Textarea::make('deskripsi')
                    ->label('Deskripsi')
                    ->required()
                    ->columnSpanFull(),

                Forms\Components\TextInput::make('target_terkumpul')
                    ->label('Target Terkumpul')
                    ->required()
                    ->numeric()
                    // ->extraAttributes(['id' => 'target-terkumpul'])
                    ->prefix('Rp.')
                    ->columnSpanFull(),
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
                TextColumn::make('target_terkumpul_formatted'),
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
