<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OfertaCredito extends Model
{
    protected $table = null;
    protected $fillable = ['QntParcelaMin','QntParcelaMax','valorMin','valorMax','jurosMes'];
    public function getMenorParcela()
    {
        $parcela = ($this->valorMax * $this->jurosMes) / (1 - pow(1 + $this->jurosMes, -$this->QntParcelaMax));   
        $this->valor_parcela = $parcela;
        $this->valor_total = floatval(number_format($parcela * $this->QntParcelaMax,2,'.',''));
    }

}
