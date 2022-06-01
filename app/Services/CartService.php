<?php

namespace App\Services;

use Auth;
use App\Models\CartItem;

class CartService
{
    public function get()
    {
        return Auth::user()->CartItems()->with(['productSku.product'])->get();
    }

    public function add($skuId, $amount)
    {
        // 因只有登录用户才可用操作购物车，所以直接使用 Auth::user() 获取用户
        $user = Auth::user();
        //  // 判断商品是否已加入购物车
        if ($item = $user->cartItems()->where('product_sku_id', $skuId)->first()) {
            // 如果存在则直接叠加商品数量
            $item->update([
                'amount' => $item->amount + $amount,
            ]);
        } else {
            // 否则创建一个新的购物车
            $item = new CartItem(['amount' => $amount]);
            $item->user()->associate($user);
            // 简单理解就是把 $skuId 赋值给 $cart->product_sku_id 字段
            $item->productSku()->associate($skuId);
            $item->save();
        }

        return $item;
    }

    public function remove($skuIds)
    {
        // 可以传单个 ID，也可以传 ID 数组
        if (!is_array($skuIds)) {
            $skuIds = array($skuIds);
        }

        Auth::user()->cartItems()->whereIn('product_sku_id', $skuIds)->delete();
    }
}
