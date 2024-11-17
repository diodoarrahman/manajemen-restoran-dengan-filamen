<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PesanMejaResource\Pages;
use App\Models\Pemesanan;
use App\Models\Meja;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Barryvdh\DomPDF\Facade\Pdf;

class PesanMejaResource extends Resource
{
    protected static ?string $model = Pemesanan::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('meja_id')
                    ->label('Nomor Meja')
                    ->relationship('meja', 'nomor_meja')
                    ->reactive()
                    ->afterStateUpdated(fn (callable $set, $state) => 
                        $set('kapasitas_meja', Meja::find($state)?->kapasitas_meja ?? 'Tidak diketahui'))
                    ->required(),
                Forms\Components\TextInput::make('kapasitas_meja')
                    ->label('Kapasitas')
                    ->disabled(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('Nomor Pemesanan'),
                Tables\Columns\TextColumn::make('meja.nomor_meja')
                    ->label('Nomor Meja Terpesan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('total_harga')
                    ->label('Total Harga')
                    ->getStateUsing(fn($record) => 'Rp ' . number_format($record->total_harga, 0, ',', '.')),
                Tables\Columns\TextColumn::make('created_at'),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('selesai')
                    ->label('Selesai')
                    ->visible(fn ($record) => $record->status === Pemesanan::STATUS_BELUM_SELESAI)
                    ->action(function ($record) {
                        // Update status pemesanan menjadi selesai
                        $record->update(['status' => Pemesanan::STATUS_SELESAI]);
                        // Ubah status meja kembali menjadi tersedia
                        $record->meja()->update(['status' => 'tersedia']);
                    })
                    ->requiresConfirmation()
                    ->color('success'),
                Tables\Actions\Action::make('exportPdf')
                    ->label('Export PDF')
                    ->action(function ($record) {
                        // Generate PDF content
                        $pdf = Pdf::loadView('pdf.pemesanan-meja', ['record' => $record]);

                        // Download PDF
                        return response()->streamDownload(function () use ($pdf) {
                            echo $pdf->output();
                        }, 'pemesanan-meja-' . $record->id . '.pdf');
                    })
                    ->icon('heroicon-o-document')
                    ->requiresConfirmation()
                    ->color('primary'),
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
            'index' => Pages\ListPesanMejas::route('/'),
            'create' => Pages\CreatePesanMeja::route('/create'),
            'edit' => Pages\EditPesanMeja::route('/{record}/edit'),
        ];
    }
}
