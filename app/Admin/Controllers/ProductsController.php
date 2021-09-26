<?php

namespace App\Admin\Controllers;

use App\Models\Product;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class ProductsController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '商品';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Product());

        $grid->id('ID')->sortable();
        $grid->title('商品名称');
        $grid->on_sale('已上架')->display(function ($value) {
            return $value ? '是': '否';
        });
        $grid->price('价格');
        $grid->sold_count('销量');
        $grid->review_count('评论数');
        // 禁用批量删除按钮
        $grid->tools(function ($tools) {
            $tools->batch(function ($batch) {
                $batch->disableDelete();
            });
        });
        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(Product::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('title', __('Title'));
        $show->field('description', __('Description'));
        $show->field('image', __('Image'));
        $show->field('on_sale', __('On sale'));
        $show->field('rating', __('Rating'));
        $show->field('sold_count', __('Sold count'));
        $show->field('review_count', __('Review count'));
        $show->field('price', __('Price'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Product());

        $form->text('title', '商品名称')->rules('required');
        $form->image('image', '封面图片')->rules('required|image');

        $form->quill('description', '商品描述')->rules('required');
        $form->radio('on_sale', '是否在售')->options(['1' => '在售', '0'=> '下架'])->default('0');
        // 添加一对多关联模型
        // 第一个参数必须和主模型中定义此关联关系的方法同名，我们之前在 App\Models\Product 类中定义了 skus() 方法来关联 SKU
        $form->hasMany('skus', 'SKU 列表', function (Form\NestedForm $form) {
            $form->text('title', 'SKU 名称')->rules('required');
            $form->text('description', 'SKU 描述')->rules('required');
            $form->text('price', '单价')->rules('required|numeric|min:0.01');
            $form->text('stock', '剩余库存')->rules('required|integer|min:0');
        });
        // 定义 `保存` 事件回调
        // 保存商品之前拿到所有 SKU 中最低的价格作为商品的价格
        // collect() 函数是 Laravel 提供的一个辅助函数，可以快速创建一个 Collection 对象。在这里我们把用户提交上来的 SKU 数据放到 Collection 中
        // 利用 Collection 提供的 min() 方法求出所有 SKU 中最小的 price，后面的 ?: 0 则是保证当 SKU 数据为空时 price 字段被赋值 0
        $form->saving(function (Form $form) {
            $form->model()->price = collect($form->input('skus'))->where(Form::REMOVE_FLAG_NAME, 0)->min('price')? : 0;
        });
        return $form;
    }
}
