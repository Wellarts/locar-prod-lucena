<?php

namespace App\Filament\Widgets;

use App\Models\Locacao;
use App\Models\Temp_lucratividade;
use Filament\Widgets\LineChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class LocacoesMes extends LineChartWidget
{
    protected static ?string $heading = 'Chart';

    

    protected function getHeading(): string
    {
        return 'Locações Mensal';
    }

    protected function getData(): array
    {
        $data = Trend::model(Temp_lucratividade::class)
        ->dateColumn('data_saida')
        ->between(
            start: now()->startOfYear(),
            end: now()->endOfYear(),
        )
        ->perMonth()
        ->sum('valor_diaria');

        return [
            'datasets' => [
                [
                    'label' => 'Locações Mensal',
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
                ],
            ],
            'labels' => $data->map(fn (TrendValue $value) => $value->date),
        ];
    }
}
