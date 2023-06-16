<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CustoVeiculoResource\Pages;
use App\Filament\Resources\CustoVeiculoResource\RelationManagers;
use App\Models\CustoVeiculo;
use App\Models\Fornecedor;
use App\Models\Veiculo;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Stevebauman\Purify\Facades\Purify;

class CustoVeiculoResource extends Resource
{
    protected static ?string $model = CustoVeiculo::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                    Forms\Components\Select::make('fornecedor_id')
                        ->label('Fornecedor')
                        ->required()
                        ->options(Fornecedor::all()->pluck('nome', 'id')->toArray()),
                    Forms\Components\Select::make('veiculo_id')
                        ->label('Veículo')
                        ->required()
                        ->allowHtml()
                        ->searchable()
                        ->getSearchResultsUsing(function (string $search) {
                            $veiculos = Veiculo::where('modelo', 'like', "%{$search}%")->limit(50)->get();
                    
                            return $veiculos->mapWithKeys(function ($veiculos) {
                                return [$veiculos->getKey() => static::getCleanOptionString($veiculos)];
                                })->toArray();
                        })
                    ->getOptionLabelUsing(function ($value): string {
                        $veiculo = Veiculo::find($value);
                    
                        return static::getCleanOptionString($veiculo);
                    }),
                Forms\Components\TextInput::make('km_atual')
                    ->label('Km Atual')
                    ->required(),
                Forms\Components\DatePicker::make('data')
                    ->default(now())
                    ->required(),
                Forms\Components\Textarea::make('descricao')
                    ->label('Descrição do Serviço/Peça')
                    ->required(),
                Forms\Components\TextInput::make('valor')
                    ->label('Valor Total')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('fornecedor.nome'),
                Tables\Columns\TextColumn::make('veiculo.modelo')
                    ->label('Veículo'),
                Tables\Columns\TextColumn::make('veiculo.placa')
                    ->label('Placa'),
                Tables\Columns\TextColumn::make('km_atual')
                    ->label('Km Atual'),
                Tables\Columns\TextColumn::make('data')
                    ->date(),
                Tables\Columns\TextColumn::make('descricao')
                    ->label('Descrição'),
                Tables\Columns\TextColumn::make('valor')
                    ->money('BRL')
                    ->label('Valor Total'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime(),
            ])
            ->filters([
                SelectFilter::make('veiculo')->relationship('veiculo', 'placa'),
               
                SelectFilter::make('fornecedor')->relationship('fornecedor', 'nome'),
              
                Tables\Filters\Filter::make('data')
                    ->form([
                        Forms\Components\DatePicker::make('data_de')
                            ->label('De:'),
                        Forms\Components\DatePicker::make('data_ate')
                            ->label('Até:'),
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when($data['data_de'],
                                fn($query) => $query->whereDate('data', '>=', $data['data_de']))
                            ->when($data['data_ate'],
                                fn($query) => $query->whereDate('data', '<=', $data['data_ate']));
                    })
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->modalHeading('Editar Custo Veículo'),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageCustoVeiculos::route('/'),
        ];
    } 
    
    public static function getCleanOptionString(Veiculo $veiculo): string
    {
        return Purify::clean(
                view('filament.componentes.modelo-placa')
                    ->with('modelo', $veiculo?->modelo)
                    ->with('placa', $veiculo?->placa)
                    ->render()
        );
    }
}
