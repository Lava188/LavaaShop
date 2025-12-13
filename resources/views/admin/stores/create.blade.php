@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Tạo store mới</h1>

    <form action="{{ route('admin.stores.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">Tên store</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}">
            @error('name')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Mô tả</label>
            <textarea class="form-control" id="description" name="description">{{ old('description') }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Lưu</button>
    </form>
</div>
@endsection
