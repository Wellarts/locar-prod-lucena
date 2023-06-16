<?php

namespace App\Filament\Resources\LocacaoResource\RelationManagers;

use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OcorrenciaLocacaoRelationManager extends RelationManager
{
    protected static string $relationship = 'ocorrenciaLocacao';

    protected static ?string $recordTitleAttribute = 'locacao_id';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\DatePicker::make('data')
                    ->label('Data da Ocorrência')
                    ->required(),
                Forms\Components\TextInput::make('valor')
                    ->required(),
                Forms\Components\Textarea::make('descricao')
                    ->required()
                    ->label('Descrição')
                    ->columnSpanFull(),
                Forms\Components\Toggle::make('status')
                    ->columnSpanFull()
                    ->label('Pago'),
                    
                  
                
                
                    
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('data')
                    ->label('Data da Ocorrência'),
                Tables\Columns\TextColumn::make('valor')
                    ->money('BRL')
                    ->label('Valor'),
                Tables\Columns\TextColumn::make('descricao')
                    ->label('Descrição'),
                Tables\Columns\ToggleColumn::make('status')
                    ->label('Pago'),
                


            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }    
}
