<?php

use Illuminate\Routing\Router;

Admin::routes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
    'as'            => config('admin.route.prefix') . '.',
], function (Router $router) {
    # 后台
    $router->get('/', 'HomeController@index');
    # 用户管理页面
    $router->get('users', 'UsersController@index');
    # 商品管理页面
    $router->get('products', 'ProductsController@index');
    # 创建商品页面
    $router->get('products/create', 'ProductsController@create');
    # 创建商品方法
    $router->post('products', 'ProductsController@store');
    # 编辑商品页面
    $router->get('products/{id}/edit', 'ProductsController@edit');
    # 编辑商品方法
    $router->put('products/{id}', 'ProductsController@update');
});
