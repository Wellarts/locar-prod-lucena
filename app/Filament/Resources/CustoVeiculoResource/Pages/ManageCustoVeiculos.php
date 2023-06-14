<?php

namespace App\Filament\Resources\CustoVeiculoResource\Pages;

use App\Filament\Resources\CustoVeiculoResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageCustoVeiculos extends ManageRecords
{
    protected static string $resource = CustoVeiculoResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
