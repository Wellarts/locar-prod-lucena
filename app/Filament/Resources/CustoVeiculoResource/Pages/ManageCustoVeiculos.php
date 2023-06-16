<?php

namespace App\Filament\Resources\CustoVeiculoResource\Pages;

use App\Filament\Resources\CustoVeiculoResource;
use App\Filament\Resources\CustoVeiculoResource\Widgets\StateCustoVeiculo;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ManageRecords;
use Illuminate\Support\Str;

class ManageCustoVeiculos extends ManageRecords
{
    protected static string $resource = CustoVeiculoResource::class;

       
    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
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
