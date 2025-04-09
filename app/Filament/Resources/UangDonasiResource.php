<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use App\Models\UangDonasi;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use App\Exports\UangDonasiExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\UangDonasiResource\Pages;
use App\Filament\Resources\UangDonasiResource\RelationManagers;

class UangDonasiResource extends Resource
{
    protected static ?string $model = UangDonasi::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $pluralLabel = 'Uang Donasi';
    protected static ?string $navigationLabel = 'Uang Donasi';


    public static function getPluralModelLabel(): string
    {
        return 'Catatan Keuangan';
    }

    public static function getModelLabel(): string
    {
        return 'Catatan';
    }


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nama_donasi')
                    ->label('Nama Donasi')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),

                Forms\Components\TextInput::make('uang_masuk')
                    ->label('Uang Masuk')
                    ->numeric()
                    ->prefix('Rp')
                    ->required()
                    ->columnSpanFull(),

                Forms\Components\TextInput::make('uang_keluar')
                    ->label('Uang Keluar')
                    ->numeric()
                    ->prefix('Rp')
                    ->required()
                    ->columnSpanFull(),

                Forms\Components\TextInput::make('saldo')
                    ->label('Sisa Saldo')
                    ->numeric()
                    ->prefix('Rp')
                    ->disabled()
                    ->dehydrated(false)
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama_donasi')
                    ->label('Nama Donasi')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('uang_masuk_formatted')
                    ->label('Uang Masuk')
                    ->sortable(),

                Tables\Columns\TextColumn::make('uang_keluar_formatted')
                    ->label('Uang Keluar')
                    ->sortable(),

                Tables\Columns\TextColumn::make('saldo_formatted')
                    ->label('Sisa Saldo')
                    ->sortable(),
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
            ])
            ->headerActions([
                Tables\Actions\Action::make('export')
                    ->label('Export to Excel')
                    ->icon('heroicon-o-folder-arrow-down')
                    ->color('success')
                    ->extraAttributes(['style' => 'float: center; margin-right: 10px;'])
                    ->action(function () {
                        return response()->download(
                            Excel::download(new UangDonasiExport, 'uang_donasi.xlsx')->getFile(),
                            'uang_donasi.xlsx'
                        );
                    }),
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
