<?php

use App\Http\Controllers\YoutubeRequestController;
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

Route::get('/request', [YoutubeRequestController::class, 'index']);
Route::post('/request',[YoutubeRequestController::class, 'store']);
Route::put('/request/{youtube_url}', [YoutubeRequestController::class, 'update']);
