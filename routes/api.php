<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ImmeubleController;
use App\Http\Controllers\AppartementController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\VisiteController;
use App\Http\Controllers\PromesseVenteController;
use App\Http\Controllers\DesistementController;
use App\Http\Controllers\PayementController;
use App\Http\Controllers\AvocatController;
use App\Http\Controllers\SignatureController;
use App\Http\Controllers\ContratVenteDefinitifController;
use App\Http\Controllers\ProcesVerbalController;
use App\Http\Controllers\UserController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResources(['immeubles'=>ImmeubleController::class]);
Route::GET('immeublesNumb',[ImmeubleController::class,'immeubleCount'])->name('immeubles.count');
Route::apiResources(['appartements'=>AppartementController::class]);
Route::apiResources(['clients'=>ClientController::class]);
Route::apiResources(['visites'=>VisiteController::class]);
Route::apiResources(['promesseVentes'=>PromesseVenteController::class]);
Route::apiResources(['desistements'=>DesistementController::class]);
Route::apiResources(['payements'=>PayementController::class]);
Route::apiResources(['avocats'=>AvocatController::class]);
Route::apiResources(['signatures'=>SignatureController::class]);
Route::apiResources(['contratVenteDefinitifs'=>ContratVenteDefinitifController::class]);
Route::apiResources(['procesVerbals'=>ProcesVerbalController::class]);
Route::apiResources(['users'=>UserController::class]);
