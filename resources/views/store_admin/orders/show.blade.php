@extends('layouts.app')
@section('content')
<div class="container">
  <h1>Đơn #{{ $order->id }}</h1>
  @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif

  <p><b>Khách:</b> {{ $order->customer->email }}</p>
  <p><b>Địa chỉ:</b> {{ $order->address }}</p>

  <form method="POST" action="{{ route('store.orders.update', $order) }}">
    @csrf @method('PUT')
    <label class="form-label">Trạng thái</label>
    <select class="form-select" name="status">
      @foreach(['pending','confirmed','shipped','completed','cancelled'] as $st)
        <option value="{{ $st }}" @selected($order->status===$st)>{{ $st }}</option>
      @endforeach
    </select>
    <button class="btn btn-primary mt-2">Cập nhật</button>
  </form>

  <hr>
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
</div>
@endsection
