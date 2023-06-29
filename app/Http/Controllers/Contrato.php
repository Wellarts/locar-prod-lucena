<?php

namespace App\Http\Controllers;

use App\Models\Locacao;
use Illuminate\Http\Request;
Use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class Contrato extends Controller
{
    public function print($id)
    {
        $locacao = Locacao::find($id);


        Carbon::setLocale('pt-BR');
        $dataAtual = Carbon::now();
        


        return pdf::loadView('pdf.contrato', compact(['locacao','dataAtual']))->stream();

       // return view('pdf.contrato', compact(['locacao']));
       

    }
}
