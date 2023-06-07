<?php

namespace App\Models;

use GuzzleHttp\Client;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agendamento extends Model
{
    use HasFactory;

    protected $fillable = [

       
        'cliente_id',
        'veiculo_id',
        'data_saida',
        'hora_saida',
        'data_retorno',
        'hora_retorno',
        'qtd_diarias',
        'valor_total',
        'valor_desconto',
        'valor_pago',
        'valor_restante',
        'obs',
        'status',
    ];

    public function Cliente()
    {
        return $this->belongsTo(Client::class);
    }

    public function Veiculo()
    {
        return $this->belongsTo(Veiculo::class);
    }
}
