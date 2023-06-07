<?php

namespace App\Filament\Resources\MarcaResource\Pages;

use App\Filament\Resources\MarcaResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageMarcas extends ManageRecords
{
    protected static string $resource = MarcaResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
