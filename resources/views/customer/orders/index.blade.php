@extends('layouts.app')
@section('content')
<div class="container">
  <h1>Đơn hàng của tôi</h1>

  <table class="table">
    <thead><tr><th>#</th><th>Shop</th><th>Tổng</th><th>Trạng thái</th><th></th></tr></thead>
    <tbody>
      @foreach($orders as $o)
        <tr>
          <td>{{ $o->id }}</td>
          <td>{{ $o->store->name }}</td>
          <td>{{ number_format($o->total_amount) }}</td>
          <td>{{ $o->status }}</td>
          <td><a href="{{ route('customer.orders.show', $o) }}">Chi tiết</a></td>
        </tr>
      @endforeach
    </tbody>
  </table>

  {{ $orders->links() }}
</div>
@endsection
