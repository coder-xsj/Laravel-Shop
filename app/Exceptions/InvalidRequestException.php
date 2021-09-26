<?php

namespace App\Exceptions;

use Illuminate\Http\Request;
use Exception;
use Throwable;

class InvalidRequestException extends Exception
{
    //
    public function __construct(string $message = "", int $code = 400, Throwable $previous = null) {
        parent::__construct($message, $code, $previous);
    }
    // render() 方法，异常被触发时系统自动调用
    public function render(Request $request) {
        // 判断是否是 ajax 请求
        if ($request->expectsJson()) {
            // 返回 json 格式的数据
            return response()->json(['msg' => $this->message], $this->code);
        }

        return view('pages.error', ['msg' => $this->message]);
    }
}
