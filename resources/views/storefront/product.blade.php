@extends('layouts.app')
@section('content')
<div class="container">
  <h1>{{ $product->name }}</h1>
  <p>Shop: <a href="{{ route('stores.show', $product->store) }}">{{ $product->store->name }}</a></p>
  <p>{{ $product->description }}</p>
  <p><b>Giá:</b> {{ number_format($product->price) }}</p>

  @auth
    <form method="POST" action="{{ route('cart.add', $product) }}">
      @csrf
      <button class="btn btn-primary">Thêm vào giỏ</button>
    </form>
  @endauth
</div>
@endsection
