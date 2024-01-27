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


route::group(['middleware' => ['check', 'chnageLang']], function () {

    route::middleware(['auth.guard:admin'])->group(function () {
        route::post('mainCategories', 'MainCategoryController@show');
        route::post('getCategory', 'MainCategoryController@getCategoryById');
        route::post('changeActivtion', 'MainCategoryController@changeActivtion');
    });
    route::namespace('AdminAuth')->prefix('auth/admin')->group(function () {
        Route::post('login', 'AuthController@login');
        route::post('logout', 'AuthController@logout')->middleware('auth.guard:admin');
    });

    // route::group(['prefix'=>'vendor',])


    route::group(['prefix' => 'vendor', 'namespace' => 'Vendor'], function () {
        route::post('login', 'AuthController@login');
        route::middleware('auth.guard:vendor')->group(function () {
            route::post('logout','AuthController@logout');
            route::post('profile', 'AuthController@getProfile');
            route::post('getAllVendors', 'AuthController@getAllVendors');
            route::post('getVendor', 'AuthController@getVendor');
        });
    });
});
