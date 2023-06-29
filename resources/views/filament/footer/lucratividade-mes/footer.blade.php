<div class="grid grid-cols-7 border-2 text-lg">
  <div class="col-start-1 col-span-5">TOTAL</div>
  <div class="col-start-2 col-end-3  text-center"> {{($this->getTableRecords()->sum('qtd_diaria'))}}</div>
  <div class="col-start-4 col-end-5  text-left"> R$ {{number_format(($this->getTableRecords()->sum('valor_diaria')),2, ",", ".")}}</div>
</div>
