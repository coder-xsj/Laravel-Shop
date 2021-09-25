@extends('layouts.app')
@section('title', '收货地址列表')

@section('content')
  <div class="row">
    <div class="col-md-10 offset-md-1">
      <div class="card panel-default">
        <div class="card-header">
          收货地址列表
          <a href="{{ route('user_addresses.create') }}" class="float-right">新增收货地址</a>
        </div>
        <div class="card-body">
          <table class="table table-bordered table-striped">
            <thead>
            <tr>
              <th>收货人</th>
              <th>地址</th>
              <th>邮编</th>
              <th>电话</th>
              <th>操作</th>
            </tr>
            </thead>
            <tbody>
            @foreach($addresses as $address)
              <tr>
                <td>{{ $address->contact_name }}</td>
                <td>{{ $address->full_address }}</td>
                <td>{{ $address->zip }}</td>
                <td>{{ $address->contact_phone }}</td>
                <td>
                  <a href="{{ route('user_addresses.edit', ['userAddress' => $address->id]) }}" class="btn btn-primary">修改</a>
{{--                  <form action="{{ route('user_addresses.destroy', ['userAddress' => $address->id]) }}" method="post" style="display: inline-block">--}}
{{--                    {{ csrf_field() }}--}}
{{--                    {{ @method_field('DELETE') }}--}}
                    <button class="btn btn-danger btn-del-address" type="button" data-id="{{ $address->id }}">删除</button>
{{--                  </form>--}}
                </td>
              </tr>
            @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  @section('scriptsAlertJs')
    <script>
     $(function () {
        $('.btn-del-address').click(function () {
          // data-id 拿到 --- 不理解
          var id = $(this).data('id')
          // 调用 sweetalert
          swal({
            title: '确定要删除该地址吗？',
            icon: 'warning',
            buttons: ['取消', '确定'],
            dangerMode: true,
          })
            // 用户点击按钮后会触发这个回调函数
          .then(function (willDelete) {
            if (!willDelete) {
              return;
            }
            // 调用删除接口，用 id 来拼接出请求的 url
            axios.delete('/user_addresses/' + id)
              .then(function () {
                location.reload();
              })
          });
        });
     });
    </script>
  @endsection
@endsection
