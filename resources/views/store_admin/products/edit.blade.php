@extends('layouts.app')
@section('content')
<div class="container">
  <h1>Sửa sản phẩm #{{ $product->id }}</h1>

  <form method="POST" action="{{ route('store.products.update', $product) }}">
    @csrf @method('PUT')

    <div class="mb-3">
      <label class="form-label">Tên</label>
      <input class="form-control" name="name" value="{{ old('name', $product->name) }}" required>
      @error('name') <div class="text-danger">{{ $message }}</div> @enderror
    </div>

    <div class="mb-3">
      <label class="form-label">Mô tả</label>
      <textarea class="form-control" name="description">{{ old('description', $product->description) }}</textarea>
    </div>

    <div class="mb-3">
      <label class="form-label">Giá</label>
      <input type="number" step="0.01" class="form-control" name="price" value="{{ old('price', $product->price) }}" required>
      @error('price') <div class="text-danger">{{ $message }}</div> @enderror
    </div>

    <div class="mb-3">
      <label class="form-label">Trạng thái</label>
      <select class="form-select" name="status">
        <option value="active" @selected($product->status==='active')>active</option>
        <option value="inactive" @selected($product->status==='inactive')>inactive</option>
      </select>
    </div>

    <button class="btn btn-primary">Cập nhật</button>
  </form>
</div>
@endsection
