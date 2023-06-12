<?php

namespace App\Filament\Resources\LocacaoResource\Pages;

use App\Filament\Resources\LocacaoResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListLocacaos extends ListRecords
{
    protected static string $resource = LocacaoResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
