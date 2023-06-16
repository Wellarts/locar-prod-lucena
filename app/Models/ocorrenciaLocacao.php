<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ocorrenciaLocacao extends Model
{
    use HasFactory;

    protected $fillable = [

       'locacao_id',
        'data',
        'descricao',
        'valor',10,2,
        'status',
           
    ];

    public function Locacao()
    {
        return $this->belongsTo(Locacao::class);
    }
}
