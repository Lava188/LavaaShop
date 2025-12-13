@extends('layouts.app')
@section('content')
<div class="container">
  <h1>Đơn hàng - {{ $store->name }}</h1>
  <table class="table">
    <thead><tr><th>#</th><th>Khách</th><th>Tổng</th><th>Status</th><th></th></tr></thead>
    <tbody>
      @foreach($orders as $o)
        <tr>
          <td>{{ $o->id }}</td>
          <td>{{ $o->customer->email }}</td>
          <td>{{ number_format($o->total_amount) }}</td>
          <td>{{ $o->status }}</td>
          <td><a href="{{ route('store.orders.show', $o) }}">Chi tiết</a></td>
        </tr>
      @endforeach
    </tbody>
  </table>
  {{ $orders->links() }}
</div>
@endsection
