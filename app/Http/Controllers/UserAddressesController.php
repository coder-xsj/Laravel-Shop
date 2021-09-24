<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserAddressRequest;
use App\Models\UserAddress;
use Illuminate\Http\Request;


class UserAddressesController extends Controller
{
    //
    public function index(Request $request) {
        return view('user_addresses.index', [
           'addresses' => $request->user()->addresses,
        ]);
    }

    public function create(Request $request) {
        return view('user_addresses.create_and_edit', [
            'address' => new UserAddress()
        ]);
    }

    public function store(UserAddressRequest $request) {
        // 会自动调用 UserAddressRequest 中 rules 方法
        // $request->user() 获取当前登录的用户
        // user()->addresses() 获取当前用户与地址的关联关系
        // addresses()->create() 在关联关系里创建一个新的记录。
        // $request->only() 通过白名单的方式从用户提交的数据里获取我们所需要的数据。
        $request->user()->addresses()->create($request->only([
            'province',
            'city',
            'district',
            'address',
            'zip',
            'contact_name',
            'contact_phone',
        ]));
        return redirect()->route('user_addresses.index');
    }
}
