<?php

namespace App\Filament\Pages;

use App\Models\Veiculo;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Widgets\AccountWidget;

class Dashbord extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.dashbord';

    public function mount(): void 
    {
        $veiculos = Veiculo::all();

        foreach($veiculos as $veiculo){
            if($veiculo->km_atual >= $veiculo->aviso_troca_oleo){
                Notification::make()
                ->title('ATENÇÃO: Veículos com troca de óleo próxima')
                ->body('Veiculo: '.$veiculo->modelo.' Placa: '.$veiculo->placa) 
                ->warning()
                ->persistent() 
                ->send();
            }
        }
    } 

    protected function getHeaderWidgets(): array
    {

        

        return [
            AccountWidget::class,
            
        ];
    }


}
