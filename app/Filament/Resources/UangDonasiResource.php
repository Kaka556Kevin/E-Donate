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
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
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
                Select::make('kelola_donasi_id')
                    ->label('Program Donasi')
                    ->options(\App\Models\KelolaDonasi::pluck('nama', 'id'))
                    ->required()
                    ->searchable()
                    ->live()
                    ->columnSpanFull()
                    ->afterStateUpdated(function (?string $state, callable $set) {
                        if ($state) {
                            $kelolaDonasi = \App\Models\KelolaDonasi::find($state);
                            if ($kelolaDonasi) {
                                $set('uang_masuk', $kelolaDonasi->donasi_terkumpul ?? 0);
                                // $set('nama_donasi', $kelolaDonasi->nama ?? '');
                            }
                        }
                    }),

                TextInput::make('nama_donasi')
                    ->label('Penerima Sumbangan')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull()
                    ->placeholder('Yayasan Dalit Mayaan'),

                Hidden::make('uang_masuk')
                    ->live()
                    ->afterStateUpdated(fn($state, callable $set, $get) => $set('saldo', $state - $get('uang_keluar'))),

                TextInput::make('uang_keluar')
                    ->label('Uang Keluar')
                    ->numeric()
                    ->prefix('Rp')
                    ->required()
                    ->afterStateUpdated(fn($state, callable $set, $get) => $set('saldo', $get('uang_masuk') - $state))
                    ->columnSpanFull(),

                TextInput::make('saldo')
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
                Tables\Columns\TextColumn::make('kelolaDonasi.nama')
                    ->label('Program Donasi')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('uang_masuk_formatted')
                    ->label('Uang Masuk')
                    ->sortable(),

                Tables\Columns\TextColumn::make('nama_donasi')
                    ->label('Penerima Sumbangan')
                    ->searchable()
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
                ])->label('Hapus Semua'),
            ])
            ->headerActions([
                Tables\Actions\Action::make('export')
                    ->label('Export ke Excel')
                    ->icon('heroicon-o-folder-arrow-down')
                    ->color('success')
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
