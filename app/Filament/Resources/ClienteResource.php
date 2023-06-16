<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ClienteResource\Pages;
use App\Filament\Resources\ClienteResource\RelationManagers;
use App\Models\Cliente;
use App\Models\Estado;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Columns\ImageColumn;

class ClienteResource extends Resource
{
    protected static ?string $model = Cliente::class;

    protected static ?string $navigationGroup = 'Cadastros';

    protected static ?string $navigationIcon = 'heroicon-s-user-add';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nome')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('cpf_cnpj')
                    ->label('CPF/CNPJ'),
                Forms\Components\Textarea::make('endereco')
                    ->label('Endereço'),
                Forms\Components\Select::make('estado_id')
                    ->label('Estado')
                    ->required()
                    ->options(Estado::all()->pluck('nome', 'id')->toArray())
                    ->reactive(),
                Forms\Components\Select::make('cidade_id')
                    ->label('Cidade')
                    ->required()
                    ->options(function (callable $get) {
                        $estado = Estado::find($get('estado_id'));
                        if(!$estado) {
                            return Estado::all()->pluck('nome', 'id');
                        }
                        return $estado->cidade->pluck('nome','id');
                    })
                    ->reactive(),
                Forms\Components\TextInput::make('telefone_1')
                    ->label('Telefone 1')
                    ->tel()
                    ->maxLength(255),
                Forms\Components\TextInput::make('telefone_2')
                    ->label('Telefone 2')
                    ->tel()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->maxLength(255),
                Forms\Components\TextInput::make('rede_social')
                    ->label('Rede Social')
                    ->maxLength(255),
                Forms\Components\TextInput::make('cnh')
                    ->label('CNH')
                    ->maxLength(255),
                Forms\Components\DatePicker::make('validade_cnh')
                    ->label('Validade CNH'),
                 Forms\Components\TextInput::make('rg')
                    ->label('RG')
                    ->maxLength(255),
                Forms\Components\TextInput::make('exp_rg')
                    ->label('EXP. RG')
                    ->maxLength(255),
                FileUpload::make('img_cnh')
                    ->label('Foto CNH'),
                    
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nome'),
                Tables\Columns\TextColumn::make('cpf_cnpj')
                    ->label('CPF/CNPJ'),
                Tables\Columns\TextColumn::make('endereco')
                    ->label('Endereço'),
                Tables\Columns\TextColumn::make('cidade.nome')
                    ->label('Cidade'),
                Tables\Columns\TextColumn::make('estado.nome')
                    ->label('Estado'),
                Tables\Columns\TextColumn::make('telefone_1')
                    ->label('Telefone 1'),
                Tables\Columns\TextColumn::make('telefone_2')
                    ->label('Telefone 2'),
                Tables\Columns\TextColumn::make('email'),
                Tables\Columns\TextColumn::make('rede_social')
                    ->label('Rede Social'),
                Tables\Columns\TextColumn::make('cnh')
                    ->label('CNH'),
                Tables\Columns\TextColumn::make('validade_cnh')
                    ->label('Validade CNH'),
                Tables\Columns\TextColumn::make('rg')
                    ->label('RG'),
                Tables\Columns\TextColumn::make('exp_rg')
                    ->label('Orgão Exp.'),
                ImageColumn::make('img_cnh')
                    ->label('Foto CNH'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->modalHeading('Editar Cliente'),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageClientes::route('/'),
        ];
    }    
}
