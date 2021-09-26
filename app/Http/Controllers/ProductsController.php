<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public function index(Request $request){
        // 创建一个查询构造器
        $builder = Product::query()->where('on_sale', true);
        if ($search = $request->input('search', '')) {
            $like = '%' . $search . '%';
            // 模糊搜索商品标题、商品详情、SKU 标题、SKU 描述
            $builder->where(function ($query) use ($like) {
               $query->where('title', 'like', $like)
                    ->orWhere('description', 'like', $like)
                    ->orWhereHas('skus', function ($query) use ($like) {
                       $query->where('title', 'like', $like)
                            ->orWhere('description', 'like', $like);
                    });
            });
        }

        // 是否有提交 order 参数， 如果有就赋值给 $order 变量
        if ($order = $request->input('order'. '')) {
            // 是否已 _asc 或者 _desc 结尾
            if (preg_match('/^(.+)_(asc|desc)$/', $order, $m)) {
                // 如果字符串的开头是这 3 个字符串之一，说明是合法的排序值
                if (in_array($m[1], ['price', 'sold_count', 'rating'])) {
                    // 构造排序参数
                    $builder->orderBy($m[1], $m[2]);
                }
            }
        }


        $products = $builder->paginate(16);
        return view('products.index', [
            'products' => $products,
            // 搜索和排序参数
            'filters' => [
                'search' => $search,
                'order' => $order,
            ],
        ]);
    }
}
