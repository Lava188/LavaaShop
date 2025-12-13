@extends('layouts.app')
@section('content')
<div class="container">
  <h1>Đơn #{{ $order->id }}</h1>
  <p><b>Shop:</b> {{ $order->store->name }}</p>
  <p><b>Trạng thái:</b> {{ $order->status }}</p>
  <p><b>Địa chỉ:</b> {{ $order->address }}</p>

  <table class="table">
    <thead><tr><th>Sản phẩm</th><th>SL</th><th>Giá</th></tr></thead>
    <tbody>
      @foreach($order->items as $it)
        <tr>
          <td>{{ $it->product->name }}</td>
          <td>{{ $it->quantity }}</td>
          <td>{{ number_format($it->unit_price) }}</td>
        </tr>
      @endforeach
    </tbody>
  </table>

  <p><b>Tổng:</b> {{ number_format($order->total_amount) }}</p>
</div>
@endsection
