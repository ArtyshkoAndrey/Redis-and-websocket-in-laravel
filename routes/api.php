<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TestController;

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

Route::middleware('auth:sanctum')
  ->get('/user', function (Request $request) {
    return $request->user();
  });
Route::get('redis-get', [TestController::class, 'get']);
Route::put('redis-put', [TestController::class, 'put']);
Route::post('create-job', [TestController::class, 'createJob']);
Route::post('creat-test-message', [TestController::class, 'createTestMessage']);
Route::post('new-message', [TestController::class, 'newMessage']);
