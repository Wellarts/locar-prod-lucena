<?php

namespace App\Filament\Resources\LocacaoResource\Pages;

use App\Filament\Resources\LocacaoResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditLocacao extends EditRecord
{
    protected static string $resource = LocacaoResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
