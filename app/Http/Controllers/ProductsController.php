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
            // 传入 匿名函数
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
            // preg_match 的用法，第三个参数可以传入未定义的变量，正则匹配成功之后将其赋值为匹配结果
            if (preg_match('/^(.+)_(asc|desc)$/', $order, $m)) {
                // 如果字符串的开头是这 3 个字符串之一，说明是合法的排序值
                // 可根据前端 select option.value 改变
                if (in_array($m[1], ['price', 'sold_count', 'rating'])) {
                    // 构造排序参数
                    // dd($m);
                    // 例如： 价格从高到底
                    // array:3 [▼
                    //  0 => "price_desc"
                    //  1 => "price"
                    //  2 => "desc"
                    //]
                    $builder->orderBy($m[1], $m[2]);
                }
            }
        }
        $products = $builder->paginate(16);
//        dd($products);

        return view('products.index', [
            'products' => $products,
            // 搜索和排序参数
            'filters' => [
                'search' => $search,
                'order' => $order,
            ],
        ]);
    }

    /**
     * @param Product $product
     * @param Request $request
     * 商品详情页
     */
    public function show(Product $product, Request $request) {
        if (!$product->on_sale) {
            throw new \Exception('商品未上架');
        }

        return view('products.show', ['product' => $product]);
    }
}
