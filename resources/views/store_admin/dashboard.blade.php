@extends('layouts.app')
@section('content')
<div class="container">
  <h1>Store Admin - {{ $store->name }}</h1>
  <p>Sản phẩm: {{ $stats['products'] }} | Đơn: {{ $stats['orders_total'] }} | Pending: {{ $stats['orders_pending'] }}</p>

  <a class="btn btn-primary" href="{{ route('store.products.index') }}">Quản lý sản phẩm</a>
  <a class="btn btn-secondary" href="{{ route('store.orders.index') }}">Quản lý đơn</a>
</div>
@endsection
