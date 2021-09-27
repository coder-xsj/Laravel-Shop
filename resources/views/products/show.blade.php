@extends('layouts.app')
@section('title', $product->title)

@section('content')
  <div class="row">
    <div class="col-lg-10 offset-lg-1">
      <div class="card">
        <div class="card-body product-info">
          <div class="row">
            <div class="col-5">
              <img class="cover" src="{{ $product->image_url }}" alt="">
            </div>
            <div class="col-7">
              <div class="title">{{ $product->title }}</div>
              <div class="price"><label>价格</label><em>￥</em><span>{{ $product->price }}</span></div>
              <div class="sales_and_reviews">
                <div class="sold_count">累计销量 <span class="count">{{ $product->sold_count }}</span></div>
                <div class="review_count">累计评价 <span class="count">{{ $product->review_count }}</span></div>
                <div class="rating" title="评分 {{ $product->rating }}">评分 <span class="count">{{ str_repeat('★', floor($product->rating)) }}{{ str_repeat('☆', 5 - floor($product->rating)) }}</span></div>
              </div>
              <div class="skus">
                <label>选择</label>
                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                  @foreach($product->skus as $sku)
                    <label
                      class="btn sku-btn"
                      data-price="{{ $sku->price }}"
                      data-stock="{{ $sku->stock }}"
                      data-toggle="tooltip"
                      title="{{ $sku->description }}"
                      data-placement="bottom"
                    >
                      <input type="radio" name="skus" autocomplete="off" value="{{ $sku->id }}"> {{ $sku->title }}
                    </label>
                  @endforeach
                </div>
              </div>
              <div class="cart_amount"><label>数量</label><input type="text" class="form-control form-control-sm" value="1"><span>件</span><span class="stock"></span></div>
              <div class="buttons">
                @if($favored)
                  <button class="btn btn-success btn-disfavor">取消收藏</button>
                @else
                  <button class="btn btn-success btn-favor">❤ 收藏</button>
                @endif
                  <button class="btn btn-primary btn-add-to-cart">加入购物车</button>
              </div>
            </div>
          </div>
          <div class="product-detail">
            <ul class="nav nav-tabs" role="tablist">
              <li class="nav-item">
                <a class="nav-link active" href="#product-detail-tab" aria-controls="product-detail-tab" role="tab" data-toggle="tab" aria-selected="true">商品详情</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#product-reviews-tab" aria-controls="product-reviews-tab" role="tab" data-toggle="tab" aria-selected="false">用户评价</a>
              </li>
            </ul>
            <div class="tab-content">
              <div role="tabpanel" class="tab-pane active" id="product-detail-tab">
                {!! $product->description !!}
              </div>
              <div role="tabpanel" class="tab-pane" id="product-reviews-tab">
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  @section('scriptsAlertJs')
    <script>
      $(function () {
        $('[data-toggle="tooltip"]').tooltip({trigger: 'hover'});  // 启用 Bootstrap 的工具提示
        $('.sku-btn').click(function () {
          $('.product-info .price span').text($(this).data('price'));
          $('.product-info .stock').text('库存' + $(this).data('stock') + '件');
        });

        // 监听收藏按钮的 click 事件
        $('.btn-favor').click(function () {
          // 发起一个 post ajax 请求，url 为 后端 route() 生成
          axios.post('{{ route('products.favor', ['product' => $product->id]) }}')
            .then(function () {  // 请求成功回调
              swal('操作成功', '', 'success')
                .then(function () {
                  location.reload();
              });
            }, function (error) {  // 请求失败回调
              // 401 代表未登录
              if (error.response && error.response.status === 401) {
                swal('请先登录', '', 'error').then(function () {
                  // 跳转到 登录 界面
                  // 此处埋坑
                  // 可以判断未登录，可以存储到 Cookies，登录后购物车、收藏 Cookies 转移到数据库呗
                  window.location = '{{ route('login') }}';
                });
              } else if (error.response && (error.response.data.msg || error.response.data.message)) {
                // 其他有 msg 或者 message 字段的情况， 将 msg 提示给用户
                swal(error.response.data.msg ? error.response.data.msg : error.response.data.message, '', 'error');
              } else {
                // 系统挂了
                swal('系统挂了', '', 'error');
              }
            });
        });

        // 监听取消收藏按钮的 click 事件
        $('.btn-disfavor').click(function () {
          axios.delete('{{ route('products.disfavor', ['product' => $product->id]) }}')
            .then(function () {
              swal('操作成功', '', 'success')
                .then(function () {
                  location.reload();
                });
            });
        });

        // 监听 加入购物车 按钮的 click 事件
        $('.btn-add-to-cart').click(function () {
          axios.post('{{ route('cart.add') }}', {
            sku_id: $('label.active input[name=skus]').val(),
            amount: $('.cart_amount input').val(),
          })
            .then(function () {
              swal('成功加入购物车', '', 'success')
                .then(function () {
                  location.href = '{{ route('cart.index') }}';
                });
            }, function (error) {
              if (error.response && error.response.status === 401) {
                swal('请先登录', '', 'error').then(function () {
                  // 跳转到 登录 界面
                  // 此处埋坑
                  // 可以判断未登录，可以存储到 Cookies，登录后购物车、收藏 Cookies 转移到数据库呗
                  window.location = '{{ route('login') }}';
                });
                // http 状态码为 422 代表用户输入校验失败
              } else if (error.response.status === 422) {
                // 这下面是干啥
                var html = '<div>';
                _.each(error.response.data.errors, function (errors) {
                  _.each(errors, function (error) {
                    html += error+'<br>';
                  })
                });
                html += '</div>';
                swal({content: $(html)[0], icon: 'error'});
              } else if (error.response.status  === 403) {
                  swal('请先验证邮箱', '', 'error');
              }  else {
                // 系统挂了
                swal('系统挂了', '', 'error');
              }
            });
        });
      });
    </script>
  @endsection
@endsection
