<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserAddressRequest;
use App\Models\UserAddress;
use Illuminate\Http\Request;

class UserAddressesController extends Controller
{
    public function index(Request $request)
    {
        return view('user_addresses.index', [
            // 这里得细琢磨一下
           'addresses' => $request->user()->addresses,
        ]);
    }

    public function create(Request $request)
    {
        return view('user_addresses.create_and_edit', [
            'address' => new UserAddress()
        ]);
    }

    public function store(UserAddressRequest $request)
    {
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

    public function edit(UserAddress $userAddress)
    {
        return view('user_addresses.create_and_edit', ['address' => $userAddress]);
    }

    /**
     * @param UserAddress $userAddress
     * @param UserAddressRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UserAddress $userAddress, UserAddressRequest $request)
    {
        $userAddress->update($request->only([
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

    /**
     * @param UserAddress $userAddress
     * @return \Illuminate\Http\RedirectResponse
     * @function 删除地址
     */
    public function destroy(UserAddress $userAddress)
    {
        $userAddress->delete();
        // return redirect()->route('user_addresses.index');
        // 因为改为 sweetalert ajax 删除了，所以这里返回空数组，不然会异常 405 (Method Not Allowed)
        return [];
    }
}
