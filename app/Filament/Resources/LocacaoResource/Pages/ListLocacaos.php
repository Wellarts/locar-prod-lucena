<?php

namespace App\Filament\Resources\LocacaoResource\Pages;

use App\Filament\Resources\LocacaoResource;
use App\Filament\Resources\LocacaoResource\Widgets\StateLocacao;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListLocacaos extends ListRecords
{
    protected static string $resource = LocacaoResource::class;

    protected static ?string $title = 'Locações';

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Criar Locação'),
        ];
    }

    protected function getHeaderWidgets(): array
    {
         /** @var \App\Models\User */
      //   $authUser =  auth()->user();

      //   if($authUser->hasRole('Administrador'))
      //   {
            return [
                StateLocacao::class

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
