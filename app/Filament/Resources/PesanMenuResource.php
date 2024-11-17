<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PesanMenuResource\Pages;
use App\Filament\Resources\PesanMenuResource\RelationManagers;
use App\Models\Meja;
use App\Models\PemesananMenu;
use App\Models\PesanMenu;
use Filament\Forms;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Barryvdh\DomPDF\Facade\Pdf;

class PesanMenuResource extends Resource
{
    protected static ?string $model = PemesananMenu::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('pemesanan_id')
                ->label('Nomor Pemesanan')
                ->relationship('pemesanan', 'id')
                ->reactive()
                ->afterStateUpdated(fn (callable $set, $state) => 
                    $set('meja_id', Meja::find($state)?-> nomor_meja ?? 'Tidak diketahui'))
                ->required(),
                
                Forms\Components\TextInput::make('meja_id')
                ->label('Nomor Meja')
                ->disabled(), // Tidak bisa diedit, hanya tampilan
                
                    Forms\Components\Select::make('menu_id')
        ->label('Menu')
        ->relationship('menu', 'nama_menu')
        ->required()
        ->reactive()
        ->afterStateUpdated(function ($state, callable $set, $get) {
            // Dapatkan harga dari menu yang dipilih dan kalikan dengan jumlah yang ada
            $menu = \App\Models\Menu::find($state);
            $hargaPerItem = $menu ? $menu->harga : 0;
            $jumlah = $get('jumlah') ?? 1; // Pastikan jumlah ada atau default ke 1
            $set('harga', $hargaPerItem * $jumlah); // Set harga total item
        }),

    Forms\Components\TextInput::make('jumlah')
        ->label('Jumlah')
        ->numeric()
        ->required()
        ->reactive()
        ->afterStateUpdated(function (callable $set, $state, $get) {
            // Set ulang harga saat jumlah diubah
            $menu = \App\Models\Menu::find($get('menu_id'));
            $hargaPerItem = $menu ? $menu->harga : 0;
            $set('harga', $hargaPerItem * $state); // Hitung total harga item
        }),

    Forms\Components\TextInput::make('harga')
        ->label('Harga Total')
        ->numeric()
        ->disabled() // Hanya tampilan, tidak bisa diedit langsung
        ->required(),

            ]);

    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('pemesanan_id')
                ->label('Nomor Pemesanan'),
                Tables\Columns\TextColumn::make('menu.nama_menu')
                ->label('Menu Terpesan'),
                Tables\Columns\TextColumn::make('jumlah')    
                ->label('Jumlah Menu Terpesan')
                ->numeric(),
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
            'index' => Pages\ListPesanMenus::route('/'),
            'create' => Pages\CreatePesanMenu::route('/create'),
            'edit' => Pages\EditPesanMenu::route('/{record}/edit'),
        ];
    }
}
