<?php

namespace App\Filament\Resources\FluxoCaixaResource\Pages;

use App\Filament\Resources\FluxoCaixaResource;
use App\Filament\Widgets\FluxoCaixaStats;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageFluxoCaixas extends ManageRecords
{
    protected static string $resource = FluxoCaixaResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Lançar Conta'),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            FluxoCaixaStats::class,
        ];
    }
}
