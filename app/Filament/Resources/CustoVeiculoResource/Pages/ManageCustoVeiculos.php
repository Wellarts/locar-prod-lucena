<?php

namespace App\Filament\Resources\CustoVeiculoResource\Pages;

use App\Filament\Resources\CustoVeiculoResource;
use App\Filament\Resources\CustoVeiculoResource\Widgets\StateCustoVeiculo;
use App\Models\Veiculo;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ManageRecords;
use Illuminate\Support\Str;

class ManageCustoVeiculos extends ManageRecords
{
    protected static string $resource = CustoVeiculoResource::class;

    protected static ?string $title = 'Custos dos Veículos';

       
    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Criar um Custo')
                ->before(function ($data)
                    {
                        $veiculo = Veiculo::find($data['veiculo_id']);
                        $veiculo->km_atual = $data['km_atual'];
                        $veiculo->save();


                }),

        ];
    }

    protected function getHeaderWidgets(): array
    {
         /** @var \App\Models\User */
      //   $authUser =  auth()->user();

      //   if($authUser->hasRole('Administrador'))
      //   {
            return [
                StateCustoVeiculo::class

            ];
      //   }
     //    else
     //   {
     //       return [
//
     //       ];
      //  }
    }

    

}
