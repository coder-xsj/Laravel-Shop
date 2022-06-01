<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddCartRequest;
use App\Models\CartItem;
use App\Models\ProductSku;
use Illuminate\Http\Request;
use App\Services\CartService;

class CartController extends Controller
{
    protected $cartService;

    // 利用 Laravel 的自动解析功能注入 CartService 类
    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    // 购物车列表
    public function index(Request $request)
    {
        // with(['productSku.product']) 方法用来预加载购物车里的商品和 SKU 信息
        //  Laravel 还支持通过 . 的方式加载多层级的关联关系，这里我们就通过 . 提前加载了与商品 SKU 关联的商品
        $cartItems = $this->cartService->get();
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
    public function add(AddCartRequest $request)
    {
        $skuId = $request->input('sku_id');
        $amount = $request->input('amount');

        $this->cartService->add($skuId, $amount);

        return [];
    }
    // 删除购物车中商品
    public function remove(ProductSku $sku, Request $request)
    {
        $this->cartService->remove($sku->id);

        return [];
    }
}
