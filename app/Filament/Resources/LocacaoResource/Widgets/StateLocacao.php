<?php

namespace App\Filament\Resources\LocacaoResource\Widgets;

use App\Models\Locacao;
use App\Models\Temp_lucratividade;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;
use Illuminate\Support\Facades\DB;

class StateLocacao extends BaseWidget
{
    protected function getCards(): array
    {
        $ano = date('Y');
        $mes = date('m');
        $dia = date('d');
       // dd($ano);
        return [
            Card::make('Total de Locações', number_format(Temp_lucratividade::all()->sum('valor_diaria'),2, ",", "."))
                ->description('Todo Perído')
                ->descriptionIcon('heroicon-s-trending-up')
                ->color('success'),
            Card::make('Total de Locações', number_format(DB::table('temp_lucratividades')->whereYear('data_saida', $ano)->whereMonth('data_saida', $mes)->sum('valor_diaria'),2, ",", "."))
                ->description('Este mês')
                ->descriptionIcon('heroicon-s-trending-up')
                ->color('success'),
            Card::make('Total de Locações', number_format(DB::table('temp_lucratividades')->whereYear('data_saida', $ano)->whereMonth('data_saida', $mes)->whereDay('data_saida', $dia)->sum('valor_diaria'),2, ",", "."))
                ->description('Hoje')
                ->descriptionIcon('heroicon-s-trending-up')
                ->color('success'),
        ];
    }
}
