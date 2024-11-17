<?php

namespace App\Filament\Resources\PesanMenuResource\Pages;

use App\Filament\Resources\PesanMenuResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPesanMenu extends EditRecord
{
    protected static string $resource = PesanMenuResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
