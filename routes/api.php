<?php

use App\Http\Controllers\API\HelloTeamController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
// you should request the route http://127.0.0.1:8000/api/user here

Route::apiResource('helloteam', HelloTeamController::class)
    ->middleware(['verifyDeveloperUser', 'auth:sanctum']);
    //order matters here!
