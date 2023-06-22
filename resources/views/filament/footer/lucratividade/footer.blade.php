<div class="grid grid-cols-6 border-2 text-lg">
  <div class="col-start-1 col-span-5 ">TOTAL</div>
  <div class="col-start-5 col-end-6  text-center"> R$ {{number_format(($this->getTableRecords()->sum('valor_total')),2, ",", ".")}}</div>
  

</div>
