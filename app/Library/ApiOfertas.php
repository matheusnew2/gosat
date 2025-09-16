<?php
namespace App\Library;
use App\Collections\OfertasCreditoCollection;
use App\Models\Instituicoes;
use App\Models\OfertaCredito;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;

class ApiOfertas 
{
    private $url;
    public function __construct()
    {
        $this->url = env('GOSAT_API_BASE_URL');
    }
    public function getOfertaCredito($cpf)
    {
        $ofertas = [];
        $instituicoes = $this->getInstituicoes($cpf);
        if(!empty($instituicoes) && is_array($instituicoes))
        {
            foreach($instituicoes as $instituicao)
            {
                $ofertas = array_merge($this->getOfertas($instituicao,$cpf),$ofertas);
            }
            return new OfertasCreditoCollection($ofertas);
        }
        return [];         
    }


    private function getInstituicoes($cpf)
    {
        if(cache("instituicoes{$cpf}"))
            return cache("instituicoes{$cpf}");

        $responseData = $this->apiRequest(['cpf' => $cpf],'credito');
        if($responseData && !empty($responseData->instituicoes))
        {
            $this->storeCache("instituicoes{$cpf}",$responseData->instituicoes);
            return $responseData->instituicoes;
        }
        return false;
    }

    private function storeCache($key,$value)
    {
        cache([$key => $value],7200);
    }
    private function getOfertas($instituicao,$cpf)
    {
        if(cache("ofertas{$cpf}-{$instituicao->id}"))
            return cache("ofertas{$cpf}-{$instituicao->id}");

        $ofertas = [] ;
        $instituicaoData = [
            'cpf' => $cpf,
            'instituicao_id' => $instituicao->id,
        ];
        if(!empty($instituicao->modalidades) && is_array($instituicao->modalidades))
        {
            foreach($instituicao->modalidades as $modalidade)
            {
                $oferta = $this->getOferta($instituicaoData,  $modalidade);
                if($oferta)
                {
                    $ofertas[] = $this->fillOferta($oferta, $instituicao, $modalidade);
                }
            }
        }
        if($ofertas)
        {
            $this->storeCache("ofertas{$cpf}-{$instituicao->id}",$ofertas);
            return $ofertas;
        }
        return false;
    } 
    private function fillOferta($oferta, $instituicao,$modalidade)
    {
        $oferta->instituicao_id = $instituicao->id;
        $oferta->instituicao_nome = $instituicao->nome;
        $oferta->modalidade = $modalidade->nome;
        return $oferta;
    }
    private function getOferta($instituicaoData, $modalidade)
    {
        $instituicaoData['codModalidade'] = $modalidade->cod;
        $oferta =  $this->apiRequest($instituicaoData,'oferta');
        if($oferta)
        {
            $oferta = new OfertaCredito((array) $oferta);
            $oferta->getMenorParcela();
            return $oferta;
        }
        return false;
    }
    private function apiRequest($data,$endpoint)
    {
        $response = Http::post("{$this->url}/{$endpoint}", $data);
        if($response->status() == 200)
        {
            $responseData = json_decode($response->body());
            if($responseData)
                return $responseData;
            
        }
        if($response->status() > 499)
        {
            throw new ConnectionException();
        }
            
        return [];
    }
}