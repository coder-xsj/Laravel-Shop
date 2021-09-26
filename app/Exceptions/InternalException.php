<?php

namespace App\Exceptions;

use App\Http\Requests\Request;
use Exception;
use Throwable;

class InternalException extends Exception
{
    protected $msgForUser;
    public function __construct(string $message, string $msgForUser = "系统内部错误" , int $code = 500, Throwable $previous = null) {
        parent::__construct($message, $code, $previous);
        // 不管发生 数据库连接失败等错误，都反馈给用户 `系统内部错误` 无需告知细节
        $this->msgForUser = $msgForUser;
    }

    public function render(Request $request) {
        if ($request->expectsJson()) {
            return response()->json(['msg' => $this->msgForUser], $this->code);
        }
        return view('pages.error', ['msg' => $this->msgForUser]);
    }
}
