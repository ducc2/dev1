<?php

use Illuminate\Http\Request;

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('signup', 'AuthController@signup');
Route::post('login', 'AuthController@login');
Route::get('auth/user', 'AuthController@user');



#* Cho
#* Coin Json-RPC Controller Routers 
#* ctr = Controller
#* @param $method,$param
#* @return $data 
Route::get('v1/api/rpc/{method?}/{param?}','RpcController@index');


// Route::middleware('jwt.auth')->get('auth/user', 'AuthController@user');
// Route::middleware('jwt.auth')->get('auth/logout', 'AuthController@logout'); 
Route::middleware('jwt.refresh')->get('/token/refresh', 'AuthController@refresh'); //토큰 재발행 


// Route::group(['middleware' => 'jwt.auth'], function(){
//     Route::post('auth/user', 'AuthController@user');
// });
