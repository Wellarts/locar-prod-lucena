<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustoVeiculo extends Model
{
    use HasFactory;

    protected $fillable = [

        'fornecedor_id',
        'veiculo_id',
        'km_atual',
        'data',
        'descricao',
        'valor',
           
    ];

    public function Veiculo()
    {
        return $this->belongsTo(Veiculo::class);
    }

    public function Fornecedor()
    {
     return $this->belongsTo(Fornecedor::class);
    }

}
