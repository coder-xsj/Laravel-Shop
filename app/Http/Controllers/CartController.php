<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddCartRequest;
use App\Models\CartItem;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function add(AddCartRequest $request) {
        $user = $request->user();
        $skuId = $request->input('sku_id');
        $amount = $request->input('amount');

        // 判断商品是否已加入购物车
        if ($cart = $user->cartItems()->where('product_sku_id', $skuId)->first()) {
            // 已加入，则数量 + 1
            $cart->update([
                'amount' => $cart->amount + $amount,
            ]);
        } else {
            // 否则则就创建一个新的购物车记录
            $cart = new CartItem(['amount' => $amount]);
            // 没理解以下绑定
            $cart->user()->associate($user);
            $cart->productSku()->associate($skuId);
            $cart->save();
        }
        return [];
    }

}
