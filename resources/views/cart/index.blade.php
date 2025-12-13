@extends('layouts.app')
@section('content')
<div class="container">
  <h1>Giỏ hàng</h1>

  @if($errors->has('cart'))
    <div class="alert alert-danger">{{ $errors->first('cart') }}</div>
  @endif
  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  @if(empty($cart['items']))
    <p>Giỏ hàng trống.</p>
  @else
    <form method="POST" action="{{ route('cart.update') }}">
      @csrf
      <table class="table">
        <thead>
          <tr><th>Sản phẩm</th><th>Giá</th><th>Số lượng</th><th></th></tr>
        </thead>
        <tbody>
          @foreach($cart['items'] as $row)
            <tr>
              <td>{{ $row['name'] }}</td>
              <td>{{ number_format($row['price']) }}</td>
              <td>
                <input type="number" min="1" name="qty[{{ $row['product_id'] }}]" value="{{ $row['qty'] }}">
              </td>
              <td>
                <form method="POST" action="{{ route('cart.remove', $row['product_id']) }}">
                  @csrf
                  <button class="btn btn-sm btn-danger">Xóa</button>
                </form>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
      <button class="btn btn-primary">Cập nhật</button>
    </form>

    <div class="mt-3">
      <a class="btn btn-success" href="{{ route('checkout.index') }}">Đi tới Checkout</a>
      <form class="d-inline" method="POST" action="{{ route('cart.clear') }}">
        @csrf
        <button class="btn btn-outline-danger">Xoá giỏ hàng</button>
      </form>
    </div>
  @endif
</div>
@endsection
