<?php

namespace App\Http\Requests;

use App\Models\ProductSku;
use Illuminate\Foundation\Http\FormRequest;

class AddCartRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'sku_id' => [
                'required',
                // 闭包接受 3 个参数，分别是参数名、参数值和错误回调
                function ($attribute, $value, $fail) {
                    if (!$sku = ProductSku::find($value)) {
                        return $fail('商品不存在');
                    }
                    if (!$sku->product->on_sale) {
                        return $fail('商品未上架');
                    }
                    if ($sku->stock === 0) {
                        return $fail('该商品库存不足');
                    }
                },
            ],
            'amount' => ['required', 'integer', 'min:1'],
        ];
    }

    public function attributes() {
        return [
            'amount' => '商品数量',
        ];
    }

    public function messages() {
        return [
            'sku_id.required' => '请选择商品',
        ];
    }

}
