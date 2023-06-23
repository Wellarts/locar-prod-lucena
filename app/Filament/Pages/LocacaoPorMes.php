<?php

namespace App\Filament\Pages;

use App\Models\Locacao;
use Filament\Pages\Page;
use Illuminate\Database\Eloquent\Builder;

class LocacaoPorMes extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.locacao-por-mes';

    protected static ?string $navigationGroup = 'Consultas';


    public function mount()
    {
        $qtdRegistos = Locacao::all();
        //dd($qtdRegistos);

        foreach($qtdRegistos as $qtdRegisto){
                
        }
    }

    protected function getTableQuery(): Builder|String
    {


        return Locacao::query()->where('status', 1);

    }


}
