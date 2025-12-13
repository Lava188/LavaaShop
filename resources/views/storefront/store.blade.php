@extends('layouts.app')
@section('content')
<div class="container">
  <h1>{{ $store->name }}</h1>
  <p>{{ $store->description }}</p>

  <a href="{{ route('cart.index') }}" class="btn btn-outline-secondary mb-3">Giỏ hàng</a>

  <div class="row">
    @foreach($products as $p)
      <div class="col-md-3 mb-3">
        <div class="card p-3">
          <h5>{{ $p->name }}</h5>
          <div>Giá: {{ number_format($p->price) }}</div>
          <a class="btn btn-sm btn-link" href="{{ route('products.show', $p) }}">Chi tiết</a>
          @auth
            <form method="POST" action="{{ route('cart.add', $p) }}">
              @csrf
              <button class="btn btn-sm btn-primary">Thêm vào giỏ</button>
            </form>
          @else
            <small>Đăng nhập để mua</small>
          @endauth
        </div>
      </div>
    @endforeach
  </div>

  {{ $products->links() }}
</div>
@endsection
