<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class OfertaCreditoTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_validacao_cpf(): void
    {
        $response = $this->postJson('api/v1/getOfertas');
        $response->assertStatus(422);
    }

    public function test_oferta_empty_response(): void
    {
        $response = $this->postJson('api/v1/getOfertas',['cpf'=>'11111111112']);
        $response->assertStatus(404);
    }
    public function test_oferta_response(): void
    {
        $response = $this->postJson('api/v1/getOfertas',['cpf'=>'11111111111']);
        $response->assertStatus(200);
    }
    public function test_cache_instituicoes_store(): void
    {
        $response = $this->postJson('api/v1/getOfertas',['cpf'=>'11111111111']);
        $response = $this->postJson('api/v1/getOfertas',['cpf'=>'11111111111']);
        $response->assertStatus(200);
    } 

}
