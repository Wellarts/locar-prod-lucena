<?php

namespace App\Filament\Pages;

use App\Models\Locacao;
use App\Models\Veiculo;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Pages\Page;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\View\View;

class Lucratividade extends Page implements HasTable, HasForms
{

    use InteractsWithTable, InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.lucratividade';

    protected static ?string $navigationGroup = 'Consultas';

    protected function getTableQuery(): Builder|String
    {


                     return Locacao::query()->where('status', 1);

    }

    protected function getTableColumns(): array
    {

                return [
                        Tables\Columns\TextColumn::make('id')
                                ->alignCenter()
                                ->label('Locação'),
                            Tables\Columns\TextColumn::make('cliente.nome')
                                ->sortable()
                                ->searchable(),
                                Tables\Columns\TextColumn::make('veiculo.modelo')
                                ->sortable()
                                ->searchable()
                                ->label('Veículo'),
                            Tables\Columns\TextColumn::make('veiculo.placa')
                                ->searchable()
                                 ->label('Placa'),
                            Tables\Columns\TextColumn::make('data_saida')
                                ->label('Data Saída')
                                ->date('d/m/Y')
                                ->sortable()
                                ->alignCenter(),
                            Tables\Columns\TextColumn::make('data_retorno')
                                ->label('Data Retorno')
                                ->date('d/m/Y')
                                ->sortable()
                                ->alignCenter(),
                            Tables\Columns\TextColumn::make('qtd_diarias')
                                ->alignCenter()
                                ->label('Qtd Diárias'),
                            Tables\Columns\TextColumn::make('valor_total_desconto')
                                ->money('BRL')
                                ->label('Valor Total'),
                      

                        ];

    }

    protected function getTableFilters(): array
    {
       return [
        SelectFilter::make('cliente')->relationship('cliente', 'nome'),
         SelectFilter::make('veiculo')->relationship('veiculo', 'placa'),
         Tables\Filters\Filter::make('datas')
            ->form([
                DatePicker::make('data_saida_de')
                    ->label('Saída de:'),
                DatePicker::make('data_retorno_ate')
                    ->label('Retorno até:'),
            ])
            ->query(function ($query, array $data) {
                return $query
                    ->when($data['data_saida_de'],
                        fn($query) => $query->whereDate('data_saida', '>=', $data['data_saida_de']))
                    ->when($data['data_retorno_ate'],
                        fn($query) => $query->whereDate('data_retorno', '<=', $data['data_retorno_ate']));
           })

       ];


    }

    protected function getFooter(): View
    {

            return view('filament/footer/lucratividade/footer');
    }

}
