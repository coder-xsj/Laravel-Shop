<?php

namespace App\Http\Controllers;

use http\Exception\InvalidArgumentException;
use Illuminate\Http\Request;
use App\Models\Order;

class PaymentController extends Controller
{
    /*
     * 支付宝支付
     */
    public function payByAlipay(Order $order, Request $request) {
        // 判断订单是否属于当前用户
        $this->authorize('own', $order);
        // 订单以支付或者已关闭
        if ($order->paid_at || $order->closed) {
            throw new InvalidArgumentException('订单状态不正确');
        }

        return app('alipay')->web([
            'out_trade_no' => $order->no,
            'total_amount' => $order->total_amount, // 订单金额，单位元，支持小数点后两位
            'subject' => '支付 Laravel Shop 的订单' . $order->no,
        ]);
    }
}
