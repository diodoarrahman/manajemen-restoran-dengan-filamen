<?php

namespace App\Filament\Resources\PesanMenuResource\Pages;

use App\Filament\Resources\PesanMenuResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPesanMenus extends ListRecords
{
    protected static string $resource = PesanMenuResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
