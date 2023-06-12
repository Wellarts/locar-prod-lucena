<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AgendamentoResource\Pages;
use App\Filament\Resources\AgendamentoResource\RelationManagers;
use App\Models\Agendamento;
use App\Models\Cliente;
use App\Models\Veiculo;
use Closure;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Grid;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use GuzzleHttp\Client;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Nette\Utils\Callback;

class AgendamentoResource extends Resource
{
    protected static ?string $model = Agendamento::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
                    ->schema([
                        Fieldset::make('Dados do Agendamento')
                            ->schema([
                                Forms\Components\Select::make('cliente_id')
                                ->label('Cliente')
                                ->required()
                                ->options(Cliente::all()->pluck('nome', 'id')->toArray()),
                            Forms\Components\Select::make('veiculo_id')
                                ->label('Veículo')
                                ->required()
                                ->getSearchResultsUsing(fn (string $search) => Veiculo::where('modelo', 'placa', "%{$search}%")->limit(50)->pluck('modelo', 'id'))
                                ->getOptionLabelUsing(fn ($value): ?string => Veiculo::find($value)?->modelo),
                              //  ->options(Veiculo::all()->pluck('modelo', 'id')->toArray()),
                            Forms\Components\DatePicker::make('data_saida')
                                ->label('Data Saída')
                                ->reactive()
                                ->required(),
                            Forms\Components\TimePicker::make('hora_saida')
                                ->label('Hora Saída')
                                ->required(),
                            Forms\Components\DatePicker::make('data_retorno')
                                ->label('Data Retorno')
                                ->afterStateUpdated( function($state, Callback $set, Closure $get) {
                                        
                                })
                                ->required(),
                            Forms\Components\TimePicker::make('hora_retorno')
                                ->label('Hora Retorno')
                                ->required(),
                            ]),
                        Fieldset::make('Valores')
                            ->schema([    
                                Forms\Components\TextInput::make('qtd_diarias')
                                ->label('Qtd Diárias')
                                ->required(),
                                Forms\Components\TextInput::make('valor_desconto')
                                    ->label('Valor Desconto'),                                    
                                Forms\Components\TextInput::make('valor_total')
                                    
                                    ->label('valor Total')
                                    ->required(),    
                                Forms\Components\TextInput::make('valor_desconto')
                                    
                                    ->label('Valor Desconto')
                                    ->required(),
                                Forms\Components\TextInput::make('valor_pago')
                                    
                                    ->label('Valor Pago'),
                                Forms\Components\TextInput::make('valor_restante')
                                    
                                    ->label('Valor Restante')
                                    ->required(),
                                Forms\Components\Textarea::make('obs')
                                    ->label('Observações'),
                                Forms\Components\Toggle::make('status')
                                    ->label('Finalizar Locação'),
                                                                     
                            ]),        
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('cliente.nome')
                    ->label('Cliente'),
                Tables\Columns\TextColumn::make('veiculo.modelo')
                     ->label('Veículo'),
                Tables\Columns\TextColumn::make('data_saida')
                    ->label('Data Saída')
                    ->date(),
                Tables\Columns\TextColumn::make('hora_saida')
                    ->label('Hora Saída'),
                Tables\Columns\TextColumn::make('data_retorno')
                    ->label('Data Retorno')
                    ->date(),
                Tables\Columns\TextColumn::make('hora_retorno')
                    ->label('Hora Retorno'),
                Tables\Columns\TextColumn::make('qtd_diarias')
                    ->label('Qtd Diárias'),
                Tables\Columns\TextColumn::make('valor_total')
                    ->label('Valor Total')
                    ->money('BRL'),
                Tables\Columns\TextColumn::make('valor_desconto')
                    ->label('Valor Desconto')
                    ->money('BRL'),
                Tables\Columns\TextColumn::make('valor_pago')
                    ->label('Valor Pago')
                    ->money('BRL'),
                Tables\Columns\TextColumn::make('valor_restante')
                    ->label('Valor Restante')
                    ->money('BRL'),
                Tables\Columns\TextColumn::make('obs')
                    ->label('Observações'),
                Tables\Columns\IconColumn::make('status')
                    ->label('Status')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
    
    public static function getRelations(): array
    {
        return [
            //
        ];
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAgendamentos::route('/'),
            'create' => Pages\CreateAgendamento::route('/create'),
            'edit' => Pages\EditAgendamento::route('/{record}/edit'),
        ];
    }    
}
