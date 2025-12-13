@extends('layouts.app')
@section('content')
<div class="container">
  <h1>Tạo sản phẩm</h1>

  <form method="POST" action="{{ route('store.products.store') }}">
    @csrf
    <div class="mb-3">
      <label class="form-label">Tên</label>
      <input class="form-control" name="name" value="{{ old('name') }}" required>
      @error('name') <div class="text-danger">{{ $message }}</div> @enderror
    </div>

    <div class="mb-3">
      <label class="form-label">Mô tả</label>
      <textarea class="form-control" name="description">{{ old('description') }}</textarea>
    </div>

    <div class="mb-3">
      <label class="form-label">Giá</label>
      <input type="number" step="0.01" class="form-control" name="price" value="{{ old('price', 0) }}" required>
      @error('price') <div class="text-danger">{{ $message }}</div> @enderror
    </div>

    <div class="mb-3">
      <label class="form-label">Trạng thái</label>
      <select class="form-select" name="status">
        <option value="active">active</option>
        <option value="inactive">inactive</option>
      </select>
    </div>

    <button class="btn btn-primary">Lưu</button>
  </form>
</div>
@endsection
