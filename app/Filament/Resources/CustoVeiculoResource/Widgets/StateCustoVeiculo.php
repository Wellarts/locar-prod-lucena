<?php

namespace App\Filament\Resources\CustoVeiculoResource\Widgets;

use App\Models\CustoVeiculo;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;
use Illuminate\Support\Facades\DB;

class StateCustoVeiculo extends BaseWidget
{

           

    protected function getCards(): array
    {
        $ano = date('Y');
        $mes = date('m');
        $dia = date('d');
       // dd($ano);
        return [
            Card::make('Custo com Veículos', number_format(CustoVeiculo::all()->sum('valor'),2, ",", "."))
                ->description('Todo Perído')
                ->descriptionIcon('heroicon-s-trending-up')
                ->color('success'),
            Card::make('Custo com Veículos', number_format(DB::table('custo_veiculos')->whereYear('data', $ano)->whereMonth('data', $mes)->sum('valor'),2, ",", "."))
                ->description('Este mês')
                ->descriptionIcon('heroicon-s-trending-up')
                ->color('success'),
            Card::make('Custo com Veículos', number_format(DB::table('custo_veiculos')->whereYear('data', $ano)->whereMonth('data', $mes)->whereDay('data', $dia)->sum('valor'),2, ",", "."))
                ->description('Hoje')
                ->descriptionIcon('heroicon-s-trending-up')
                ->color('success'),
        ];
    }
}
