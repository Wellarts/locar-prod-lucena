<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContasReceberResource\Pages;
use App\Filament\Resources\ContasReceberResource\RelationManagers;
use App\Models\Cliente;
use App\Models\ContasReceber;
use App\Models\FluxoCaixa;
use Carbon\Carbon;
use Closure;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ContasReceberResource extends Resource
{
    protected static ?string $model = ContasReceber::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static ?string $title = 'Contas a Receber';

    protected static ?string $navigationLabel = 'Contas a Receber';

    protected static ?string $navigationGroup = 'Financeiro';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('cliente_id')
                    ->label('Cliente')
                    ->options(Cliente::all()->pluck('nome', 'id')->toArray())
                    ->required(),
                Forms\Components\TextInput::make('valor_total')
                    ->required(),    
                Forms\Components\TextInput::make('parcelas')
                    ->hiddenOn('edit')
                    ->reactive()
                    ->afterStateUpdated(function (Closure $get, Closure $set) {
                        if($get('parcelas') != 1)
                           {
                            $set('valor_parcela', (($get('valor_total') / $get('parcelas'))));
                            $set('status', 0);
                            $set('valor_recebido', 0);
                            $set('data_recebimento', null);
                            $set('data_vencimento',  Carbon::now()->addDays(30));
                           }
                        else
                            {
                                $set('valor_parcela', $get('valor_total'));
                                $set('status', 1);
                                $set('valor_recebido', $get('valor_total'));
                                $set('data_recebimento', Carbon::now());
                                $set('data_vencimento',  Carbon::now());  
                            }    
          
                    })
                    ->required(),
                Forms\Components\Select::make('formaPgmto')
                    ->default('2')
                    ->label('Forma de Pagamento')
                    ->required()
                    ->options([
                        1 => 'Dinheiro',
                        2 => 'Pix',
                        3 => 'Cartão',
                    ]),
                Forms\Components\TextInput::make('ordem_parcela')
                    ->label('Parcela Nº')
                    ->default('1')
                    ->disabled()
                    ->maxLength(10),
                Forms\Components\DatePicker::make('data_vencimento')
                    ->default(now())
                    ->required(),
                Forms\Components\DatePicker::make('data_recebimento')
                    ->default(now())
                    ->label("Data do Recebimento"),
                Forms\Components\Toggle::make('status')
                    ->default('true')
                    ->label('Recebido')
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(function (Closure $get, Closure $set) {
                                if($get('status') == 1)
                                    {
                                        $set('valor_recebido', $get('valor_parcela'));
                                        $set('data_recebimento', Carbon::now());

                                    }
                                else
                                    {

                                        $set('valor_recebido', 0);
                                        $set('data_recebimento', null);
                                    }
                                }
                    ),

                Forms\Components\TextInput::make('valor_parcela')
                      ->required(),
                Forms\Components\TextInput::make('valor_recebido'),
                Forms\Components\Textarea::make('obs'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('cliente.nome')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('ordem_parcela')
                    ->alignCenter()
                    ->label('Parcela Nº'),
                Tables\Columns\BadgeColumn::make('data_vencimento')
                    ->sortable()
                    ->alignCenter()
                    ->color('danger')
                    ->date(),
                Tables\Columns\BadgeColumn::make('valor_total')
                    ->alignCenter()
                    ->color('success')
                     ->money('BRL'),
                Tables\Columns\SelectColumn::make('formaPgmto')
                    ->Label('Forma de Pagamento')
                    ->options([
                        1 => 'Dinheiro',
                        2 => 'Pix',
                        3 => 'Cartão',
                    ])
                    ->disablePlaceholderSelection(),
                     
                     
                Tables\Columns\BadgeColumn::make('valor_parcela')
                    ->alignCenter()
                    ->color('danger')
                    ->money('BRL'),
                Tables\Columns\IconColumn::make('status')
                    ->label('Recebido')
                    ->boolean(),
                Tables\Columns\BadgeColumn::make('valor_recebido')
                    ->label('Valor Recebido')
                    ->alignCenter()
                    ->color('warning')
                    ->money('BRL'),
                Tables\Columns\BadgeColumn::make('data_recebimento')
                    ->alignCenter()
                    ->color('warning')
                    ->date(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime(),
            ])
            ->filters([
                Filter::make('Aberta')
                ->query(fn (Builder $query): Builder => $query->where('status', false)),
                 SelectFilter::make('cliente')->relationship('cliente', 'nome'),
                 Tables\Filters\Filter::make('data_vencimento')
                    ->form([
                        Forms\Components\DatePicker::make('vencimento_de')
                            ->label('Vencimento de:'),
                        Forms\Components\DatePicker::make('vencimento_ate')
                            ->label('Vencimento até:'),
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when($data['vencimento_de'],
                                fn($query) => $query->whereDate('data_vencimento', '>=', $data['vencimento_de']))
                            ->when($data['vencimento_ate'],
                                fn($query) => $query->whereDate('data_vencimento', '<=', $data['vencimento_ate']));
                    })
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                ->after(function ($data, $record) {

                    if($record->status = 1 and $data['formaPgmto'] == 1)
                    {
                        
                        $addFluxoCaixa = [
                            'valor' => ($record->valor_parcela),
                            'tipo'  => 'CREDITO',
                            'obs'   => 'Recebimento de conta',
                        ];

                        FluxoCaixa::create($addFluxoCaixa);
                    }
                }),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageContasRecebers::route('/'),
        ];
    }    
}
