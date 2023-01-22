<?php

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

// Route::get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get("get-users","UserController@getUser")->middleware(['verify.validApi']);
Route::post("user-wallet-id","UserController@GetWallet_info")->middleware(['verify.validApi']);
Route::post("user-wallet-register","UserController@create")->middleware(['verify.validApi']);
Route::post("user-balance","UserController@GetTotalBalance")->middleware(['verify.validApi']);
Route::post("user-transactions","UserController@GetTransactions")->middleware(['verify.validApi']);
Route::post("user-deposit","UserController@UserDeposit");