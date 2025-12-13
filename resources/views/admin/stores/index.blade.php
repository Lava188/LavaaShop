@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Danh sách Store</h1>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('admin.stores.create') }}" class="btn btn-primary mb-3">Tạo store mới</a>

    <table class="table">
        <thead>
        <tr>
            <th>ID</th>
            <th>Tên store</th>
            <th>Trạng thái</th>
            <th>Ngày tạo</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @foreach ($stores as $store)
            <tr>
                <td>{{ $store->id }}</td>
                <td>{{ $store->name }}</td>
                <td>{{ $store->status }}</td>
                <td>{{ $store->created_at }}</td>
                <td>
                    <a href="{{ route('admin.stores.edit', $store) }}" class="btn btn-sm btn-secondary">Sửa</a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    {{ $stores->links() }}
</div>
@endsection
