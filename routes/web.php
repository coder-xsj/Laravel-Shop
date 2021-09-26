<?php

use Illuminate\Support\Facades\Route;
//use Illuminate\Auth;
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



# 启用邮箱验证路由
Auth::routes(['verify' => true]);
# 访客可访问
# 首页直接跳转到商品页面
Route::redirect('/', '/products')->name('root');
# 商品列表页面
Route::get('products', 'ProductsController@index')->name('products.index');
# 商品详情页面
Route::get('products/{product}', 'ProductsController@show')->name('products.show');

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
    # 删除地址方法
    Route::delete('user_addresses/{userAddress}', 'UserAddressesController@destroy')->name('user_addresses.destroy');



});





