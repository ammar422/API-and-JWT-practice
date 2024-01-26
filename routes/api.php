<?php

use GuzzleHttp\Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


route::group(['middleware' => [ 'check', 'chnageLang']], function () {

    route::namespace('AdminAuth')->prefix('auth/admin')->group(function () {
        Route::post('login', 'AuthController@login');
        Route::post('logout', 'AuthController@logout');
        Route::post('refresh', 'AuthController@refresh');
        Route::post('me', 'AuthController@me');
    });


    route::middleware(['checkAdminToken:admin'])->group(function () {
        route::post('mainCategories', 'MainCategoryController@show');
        route::post('getCategory', 'MainCategoryController@getCategoryById');
        route::post('changeActivtion', 'MainCategoryController@changeActivtion');
    });
});
route::get('tst','AdminAuth\AuthController@test')->middleware('api');