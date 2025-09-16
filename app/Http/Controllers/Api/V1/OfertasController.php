<?php

namespace App\Http\Controllers\Api\V1;
use App\Http\Controllers\Controller;
use App\Http\Requests\GetOfertasRequest;
use App\Http\Resources\OfertaCreditoResource;
use Illuminate\Http\Client\ConnectionException;
use App\Library\ApiOfertas;
use Exception;
class OfertasController extends Controller
{
    public function getOfertas(GetOfertasRequest $request)
    {
        try
        {
            $apiOfertas = new ApiOfertas();
            $ofertas = $apiOfertas->getOfertaCredito($request->cpf);
            if($ofertas)
            {
                $ofertas = $ofertas->orderOferta();
                return response( ['ofertas'=> OfertaCreditoResource::collection($ofertas->slice(0,3))]);
            }
            return response([
                'message'=>'Not Found',
                'code' => 404
            ],404);
        }
        catch(ConnectionException $e)
        {
            return response([
                'message'=>'Bad Gateway',
                'code' => 502
            ],502);
        }
        catch(Exception $e)
        {
            return response([
                'message'=>'Internal Server Error',
                'code' => 500
            ],500);
        }
  
    }
}