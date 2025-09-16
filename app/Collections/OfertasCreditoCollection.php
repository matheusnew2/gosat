<?php 
namespace App\Collections;

use Illuminate\Database\Eloquent\Collection;

class OfertasCreditoCollection extends Collection
{
    public function orderOferta($order = null)
    {
        $orders = $this->sortBy('valor_parcela');
        return $orders;
    }
}