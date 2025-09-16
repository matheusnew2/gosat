<?php

namespace Tests\Unit;

use App\Models\OfertaCredito;
use PHPUnit\Framework\TestCase;

class OfertaCreditoTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_parcelaCalculo(): void
    {
        $ofertaCredito = new OfertaCredito([
            'QntParcelaMin' => 12,
            'QntParcelaMax' => 48,
            'valorMin' => 3000,
            'valorMax' => 8000,
            'jurosMes' => 0.0495,
        ]);
        $ofertaCredito->getMenorParcela();
        if(!empty($ofertaCredito->valor_parcela))
        {
            $this->assertTrue(number_format($ofertaCredito->valor_parcela,2) == 439.2);
        }
        else
        {
            $this->assertTrue(false);
        }
        
    }
}
