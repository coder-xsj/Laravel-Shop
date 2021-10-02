<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddCartRequest;
use App\Models\CartItem;
use App\Models\ProductSku;
use Illuminate\Http\Request;

class CartController extends Controller
{
    // 购物车列表
    public function index(Request $request) {
        // with(['productSku.product']) 方法用来预加载购物车里的商品和 SKU 信息
        //  Laravel 还支持通过 . 的方式加载多层级的关联关系，这里我们就通过 . 提前加载了与商品 SKU 关联的商品
        $cartItems = $request->user()->cartItems()->with(['productSku.product'])->get();
        // 使用最近用过的地址概率比较大
        $addresses = $request->user()->addresses()->orderBy('last_used_at', 'desc')->get();
        // dd($cartItems);
        return view('cart.index', ['cartItems' => $cartItems, 'addresses' => $addresses]);
    }

    /**
     * @param AddCartRequest $request
     * @return array
     * 添加购物车功能
     */
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
            // 简单理解就是把 $skuId 赋值给 $cart->product_sku_id 字段
            $cart->productSku()->associate($skuId);
            $cart->save();
        }
        return [];
    }
    // 删除购物车中商品
    public function remove(ProductSku $sku, Request $request) {
        $request->user()->cartItems()->where('product_sku_id', $sku->id)->delete();

        return [];
    }

}
