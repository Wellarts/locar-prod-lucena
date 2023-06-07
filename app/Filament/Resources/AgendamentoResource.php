<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AgendamentoResource\Pages;
use App\Filament\Resources\AgendamentoResource\RelationManagers;
use App\Models\Agendamento;
use App\Models\Cliente;
use App\Models\Veiculo;
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
                                    ->options(Veiculo::all()->pluck('modelo', 'id')->toArray()),
                                Forms\Components\DatePicker::make('data_saida')
                                    ->required(),
                                Forms\Components\TextInput::make('hora_saida')
                                    ->required(),
                                Forms\Components\DatePicker::make('data_retorno')
                                    ->required(),
                                Forms\Components\TextInput::make('hora_retorno')
                                    ->required(),
                            ]),
                        Fieldset::make('Valores')
                            ->schema([    

                                Forms\Components\TextInput::make('qtd_diarias')
                                    ->required(),
                                Forms\Components\TextInput::make('valor_total')
                                    ->required(),
                                Forms\Components\TextInput::make('valor_desconto')
                                    ->required(),
                                Forms\Components\TextInput::make('valor_pago')
                                    ->required(),
                                Forms\Components\TextInput::make('valor_restante')
                                    ->required(),
                                Forms\Components\Textarea::make('obs')
                                    ->required(),
                                Forms\Components\Toggle::make('status')
                                    ->required(),
                            ]),        
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('cliente_id'),
                Tables\Columns\TextColumn::make('veiculo_id'),
                Tables\Columns\TextColumn::make('data_saida')
                    ->date(),
                Tables\Columns\TextColumn::make('hora_saida'),
                Tables\Columns\TextColumn::make('data_retorno')
                    ->date(),
                Tables\Columns\TextColumn::make('hora_retorno'),
                Tables\Columns\TextColumn::make('qtd_diarias'),
                Tables\Columns\TextColumn::make('valor_total'),
                Tables\Columns\TextColumn::make('valor_desconto'),
                Tables\Columns\TextColumn::make('valor_pago'),
                Tables\Columns\TextColumn::make('valor_restante'),
                Tables\Columns\TextColumn::make('obs'),
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
            'index' => Pages\ListAgendamentos::route('/'),
            'create' => Pages\CreateAgendamento::route('/create'),
            'edit' => Pages\EditAgendamento::route('/{record}/edit'),
        ];
    }    
}
