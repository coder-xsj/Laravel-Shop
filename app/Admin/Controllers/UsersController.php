<?php

namespace App\Admin\Controllers;

use App\Models\User;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class UsersController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '用户';

    /**
     * Make a grid builder.
     * 决定列表页要展示哪些列
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new User());

        $grid->id('ID');
        $grid->name('用户名');
        $grid->email('邮箱');
        // 这个 display 怎么还有个回调
        // display() 方法接受一个匿名函数作为参数，在展示时会把对应字段值当成参数传给匿名函数，把匿名函数的返回值作为页面输出的内容
        $grid->email_verified_at('已验证邮箱')->display(function ($value) {
           return $value ? '是': '否';
        });
        $grid->created_at('注册时间');

        // 不在页面显示 `新建` 按钮
        $grid->disableCreateButton();
        // 不在页面显示 `编辑` 按钮
//        $grid->disableActions();
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
     * 展示用户详情页
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(User::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('name', __('Name'));
        $show->field('email', __('Email'));
        $show->field('email_verified_at', __('Email verified at'));
        $show->field('password', __('Password'));
        $show->field('remember_token', __('Remember token'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));

        return $show;
    }

    /**
     * Make a form builder.
     * 用于新建和编辑用户
     * @return Form
     *
     */
    protected function form()
    {
        $form = new Form(new User());

        $form->text('name', __('Name'));
        $form->email('email', __('Email'));
        $form->datetime('email_verified_at', __('Email verified at'))->default(date('Y-m-d H:i:s'));
        $form->password('password', __('Password'));
        $form->text('remember_token', __('Remember token'));

        return $form;
    }
}
