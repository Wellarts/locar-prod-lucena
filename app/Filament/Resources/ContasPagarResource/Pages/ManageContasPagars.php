<?php

namespace App\Filament\Resources\ContasPagarResource\Pages;

use App\Filament\Resources\ContasPagarResource;
use App\Models\ContasPagar;
use App\Models\FluxoCaixa;
use Carbon\Carbon;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageContasPagars extends ManageRecords
{
    protected static string $resource = ContasPagarResource::class;

    protected static ?string $title = 'Contas a Pagar';

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make()
            ->after(function ($data, $record) {
                if($record->parcelas > 1)
                {
                    $valor_parcela = ($record->valor_total / $record->parcelas);
                    $vencimentos = Carbon::create($record->data_vencimento);
                    for($cont = 1; $cont < $data['parcelas']; $cont++)
                    {
                                        $dataVencimentos = $vencimentos->addDays(30);
                                        $parcelas = [
                                        'fornecedor_id' => $data['fornecedor_id'],
                                        'valor_total' => $data['valor_total'],
                                        'parcelas' => $data['parcelas'],
                                        'ordem_parcela' => $cont+1,
                                        'data_vencimento' => $dataVencimentos,
                                        'valor_pago' => 0.00,
                                        'status' => 0,
                                        'obs' => $data['obs'],
                                        'valor_parcela' => $valor_parcela,
                                        ];
                            ContasPagar::create($parcelas);
                    }

                }
                else
                { 
                    $addFluxoCaixa = [
                        'valor' => ($record->valor_total * -1),
                        'tipo'  => 'DEBITO',
                        'obs'   => 'Pagamento de Conta',
                    ];

                    FluxoCaixa::create($addFluxoCaixa); 
                }


            }
        ),
            
        ];
    }
}
