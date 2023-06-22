<?php

namespace App\Filament\Resources\LocacaoResource\Pages;

use App\Filament\Resources\LocacaoResource;
use App\Models\Veiculo;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditLocacao extends EditRecord
{
    protected static string $resource = LocacaoResource::class;

    protected static ?string $title = 'Editar Locação';


    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
           
            
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
           $veiculo = Veiculo::find($data['veiculo_id']);
           $veiculo->km_atual = $data['km_retorno'];
           $veiculo->save();

           return $data;
    }
}
