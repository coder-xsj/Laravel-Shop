@extends('layouts.app')
@section('title', '我的收藏')

@section('content')
  <div class="row">
    <div class="col-lg-10 offset-lg-1">
      <div class="card">
        <div class="card-header">我的收藏</div>
        <div class="card-body">
          <div class="row products-list">
            @foreach($favorites as $favorite)
              <div class="col-3 product-item">
                <div class="product-content">
                  <div class="top">
                    <div class="img">
                      <a href="{{ route('products.show', ['product' => $favorite->id]) }}">
                        <img src="{{ $favorite->image_url }}" alt="">
                      </a>
                    </div>
                    <div class="price"><b>￥</b>{{ $favorite->price }}</div>
                    <a href="{{ route('products.show', ['product' => $favorite->id]) }}">{{ $favorite->title }}</a>
                  </div>
                  <div class="bottom">
                    <div class="sold_count">销量 <span>{{ $favorite->sold_count }}笔</span></div>
                    <div class="review_count">评价 <span>{{ $favorite->review_count }}</span></div>
                  </div>
                </div>
              </div>
            @endforeach
          </div>
          <div class="float-right">{{ $favorites->render() }}</div>
        </div>
      </div>
    </div>
  </div>
@endsection
