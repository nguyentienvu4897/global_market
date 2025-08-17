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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/sync-user-account', 'Common\UserController@syncUserAccount')->middleware('verifySyncUserToken');

// API Lấy sản phẩm
Route::post('/v1/get-products', 'Api\ProductController@getProducts')->middleware('checkApiKey');

// API Đăng ký
Route::post('/v1/account/register', 'Api\AccountController@apiRegister')->middleware('checkApiKey');
// API Đăng nhập
Route::post('/v1/account/login', 'Api\AccountController@apiLogin')->middleware('checkApiKey');


Route::middleware(['checkApiKey', 'auth:api'])->group(function () {
    // API Logout
    Route::get('/v1/account/logout', 'Api\AccountController@apiLogout');

    // API Lấy thông tin tài khoản
    Route::get('/v1/account/info', 'Api\AccountController@apiInfo');

    // API Lấy số tiền chờ quyết toán
    Route::get('/v1/waiting-revenue-amount', 'Api\AccountController@apiWaitingRevenueAmount');
});
