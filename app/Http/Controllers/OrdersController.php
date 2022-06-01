<?php

namespace App\Http\Controllers;

use App\Exceptions\InvalidRequestException;
use App\Http\Requests\OrderRequest;
use App\Http\Requests\Request;
use App\Models\ProductSku;
use App\Models\UserAddress;
use App\Models\Order;
use Carbon\Carbon;
use App\Jobs\CloseOrder;
use App\Services\CartService;
use App\Services\OrderService;


class OrdersController extends Controller
{
    public function index(Request $request)
    {
        $orders = Order::query()
            // with 方法加载，防止 n + 1
            ->with(['items.product', 'items.productSku'])
            ->where('user_id', $request->user()->id)
            ->paginate();

//        dd($orders);
        return view('orders.index', ['orders' => $orders]);
    }

    public function store(OrderRequest $request, OrderService $orderService)
    {
        $user = $request->user();
        $address = UserAddress::find($request->input('address_id'));

        return $orderService->store($user, $address, $request->input('remark'), $request->input('items'));
    }

    public function show(Order $order, Request $request)
    {
        $this->authorize('own', $order);
        // load 方法延迟预加载
        return view('orders.show', ['order' => $order->load(['items.productSku', 'items.product'])]);
    }
}
