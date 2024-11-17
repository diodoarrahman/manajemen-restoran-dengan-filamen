<?php

namespace App\Filament\Resources\MejaResource\Pages;

use App\Filament\Resources\MejaResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Filament\Forms;
use App\Models\Meja;

class CreateMeja extends CreateRecord
{
    protected static string $resource = MejaResource::class;

    public $kapasitasMeja = ''; // Property untuk kapasitas meja

    protected function getFormSchema(): array
    {
        return [
            Forms\Components\Select::make('meja_id')
                ->label('Nomor Meja')
                ->options(Meja::all()->pluck('nomor_meja', 'id'))
                ->reactive()
                ->afterStateUpdated(fn ($state) => $this->updateKapasitas($state)),
            Forms\Components\TextInput::make('kapasitasMeja')
                ->label('Kapasitas')
                ->disabled(),
        ];
    }

    public function updateKapasitas($mejaId)
    {
        $this->kapasitasMeja = Meja::find($mejaId)?->kapasitas ?? 'Tidak diketahui';
    }
}
