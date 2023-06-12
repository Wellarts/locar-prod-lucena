<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LocacaoResource\Pages;
use App\Filament\Resources\LocacaoResource\RelationManagers;
use App\Models\Cliente;
use App\Models\Locacao;
use App\Models\Veiculo;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Fieldset;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class LocacaoResource extends Resource
{
    protected static ?string $model = Locacao::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
                    ->schema([
                        Fieldset::make('Dados da Locação')
                            ->schema([
                                Forms\Components\Select::make('cliente_id')
                                    ->label('Cliente')
                                    ->required()
                                    ->options(Cliente::all()->pluck('nome', 'id')->toArray()),
                                Forms\Components\Select::make('veiculo_id')
                                    ->label('Veículo')
                                    ->required()
                                    ->options(Veiculo::all()->pluck('modelo', 'id')->toArray()),
                                Forms\Components\TextInput::make('km_saida')
                                    ->label('Km Saída')
                                    ->required(),
                                Forms\Components\DatePicker::make('data_saida')
                                    ->label('Data Saída')
                                    ->required(),
                                Forms\Components\TimePicker::make('hora_saida')
                                    ->label('Hora Saída')
                                    ->required(),
                                Forms\Components\DatePicker::make('data_retorno')
                                    ->label('Data Retorno')
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
                                    ->label('Valor Desconto')
                                    ->required(),
                                Forms\Components\TextInput::make('valor_total')
                                    ->label('Valor Total')
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
                Tables\Columns\TextColumn::make('cliente_id')
                    ->label('Cliente'),
                Tables\Columns\TextColumn::make('veiculo_id')
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
                Tables\Columns\TextColumn::make('valor_desconto')
                    ->money('BRL')
                    ->label('Valor Desconto'),
                Tables\Columns\TextColumn::make('valor_total')
                    ->money('BRL')
                    ->label('Valor Total'),
                Tables\Columns\TextColumn::make('obs')
                    ->label('Observações'),
                Tables\Columns\IconColumn::make('status')
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
            'index' => Pages\ListLocacaos::route('/'),
            'create' => Pages\CreateLocacao::route('/create'),
            'edit' => Pages\EditLocacao::route('/{record}/edit'),
        ];
    }    
}
