<?php

use App\Http\Controllers\Api\V1\OfertasController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

request()->headers->set('Accept', 'application/json');

Route::prefix('v1')->group(function () {
    Route::post('/getOfertas', [OfertasController::class, 'getOfertas']);
});
