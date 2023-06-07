<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Veiculo extends Model
{
    use HasFactory;
   
    protected $fillable = [
        'marca_id',
        'modelo',
        'ano',
        'placa',
        'cor',
        'km_atual',
        'valor_diaria',10,2,
        'prox_troca_oleo',
        'prox_troca_filtro',
        'aviso_troca_oleo',
        'aviso_troca_filtro',
        'prox_troca_correia',
        'prox_troca_pastilha',
        'aviso_troca_correia',
        'aviso_troca_pastilha',
        'chassi',
        'data_compra',
        'status',
    ];

    public function Marca()
    {
        return $this->belongsTo(Marca::class);
    }

    public function Agendamento()
    {
        return $this->hasMany(Agendamento::class);
    }
}
