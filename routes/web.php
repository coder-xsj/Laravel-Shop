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
Route::get('products/{product}', 'ProductsController@show')->name('products.show')->where(['product' => '[0-9]+']);
# 测试支付路由
Route::get('alipay', function () {
    return app('alipay')->web([
        'out_trade_no' => time(),
        'total_amount' => 1,
        'subject' => '支付订单',
    ]);
});
#
Route::get('ts', 'DigitalChina@TS')->name('digital.ts');
Route::post('ts', 'DigitalChina@TS')->name('digital.ts');
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
    # 收藏商品方法
    Route::post('products/{product}/favorite', 'ProductsController@favor')->name('products.favor');
    # 取消收藏商品方法
    Route::delete('products/{product}/favorite', 'ProductsController@disfavor')->name('products.disfavor');
    # 收藏商品列表页面
    Route::get('products/favorites', 'ProductsController@favorites')->name('products.favorites');
    # 加入购物车方法
    Route::post('cart', 'CartController@add')->name('cart.add');
    # 购物车列表页面
    Route::get('cart', 'CartController@index')->name('cart.index');
    # 购物车商品删除
    Route::delete('cart/{sku}', 'CartController@remove')->name('cart.remove');
    # 订单创建方法
    Route::post('orders', 'OrdersController@store')->name('orders.store');
    # 订单列表页面
    Route::get('orders', 'OrdersController@index')->name('orders.index');
    # 订单详情页面
    Route::get('orders/{order}', 'OrdersController@show')->name('orders.show');
    #
    Route::get('payment/{order}/alipay', 'PaymentController@payByAlipay')->name('payment.alipay');

});





