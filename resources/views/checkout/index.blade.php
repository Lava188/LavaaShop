@extends('layouts.app')
@section('content')
<div class="container">
  <h1>Checkout - {{ $store->name }}</h1>

  <form method="POST" action="{{ route('checkout.store') }}">
    @csrf
    <div class="mb-3">
      <label class="form-label">Địa chỉ giao hàng</label>
      <textarea class="form-control" name="address" required>{{ old('address') }}</textarea>
      @error('address') <div class="text-danger">{{ $message }}</div> @enderror
    </div>
    <button class="btn btn-primary">Đặt hàng</button>
  </form>
</div>
@endsection
