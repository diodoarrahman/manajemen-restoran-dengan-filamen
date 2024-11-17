<?php

namespace App\Filament\Resources\PesanMejaResource\Pages;

use App\Filament\Resources\PesanMejaResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPesanMejas extends ListRecords
{
    protected static string $resource = PesanMejaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
