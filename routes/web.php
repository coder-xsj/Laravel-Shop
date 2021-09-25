<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'PagesController@root')->name('root');

# 启用邮箱验证路由
Auth::routes(['verify' => true]);


# auth 中间件代表需要登录，verified中间件代表需要经过邮箱验证
Route::group(['middleware' => ['auth', 'verified']], function () {
    # 地址列表页面
    Route::get('user_addresses', 'UserAddressesController@index')->name('user_addresses.index');
    # 创建以及修改地址页面
    Route::get('user_addresses/create', 'UserAddressesController@create')->name('user_addresses.create');
    # 创建地址方法
    Route::post('user_addresses', 'UserAddressesController@store')->name('user_addresses.store');
    # 修改地址页面
    Route::get('user_addresses/{userAddress}', 'UserAddressesController@edit')->name('user_addresses.edit');
    # 修改地址方法
    Route::put('user_addresses/{userAddress}', 'UserAddressesController@update')->name('user_addresses.update');
});





