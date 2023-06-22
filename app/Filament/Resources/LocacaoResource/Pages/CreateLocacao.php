<?php

namespace App\Filament\Resources\LocacaoResource\Pages;

use App\Filament\Resources\LocacaoResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateLocacao extends CreateRecord
{

    protected static ?string $title = 'Criar Locação';

    protected static string $resource = LocacaoResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
