@extends('layouts.app')
@section('content')
<div class="container">
  <h1>Sản phẩm - {{ $store->name }}</h1>
  @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif

  <a class="btn btn-primary mb-3" href="{{ route('store.products.create') }}">Tạo sản phẩm</a>

  <table class="table">
    <thead><tr><th>#</th><th>Tên</th><th>Giá</th><th>Status</th><th></th></tr></thead>
    <tbody>
      @foreach($products as $p)
        <tr>
          <td>{{ $p->id }}</td>
          <td>{{ $p->name }}</td>
          <td>{{ number_format($p->price) }}</td>
          <td>{{ $p->status }}</td>
          <td>
            <a class="btn btn-sm btn-secondary" href="{{ route('store.products.edit', $p) }}">Sửa</a>
            <form class="d-inline" method="POST" action="{{ route('store.products.destroy', $p) }}">
              @csrf @method('DELETE')
              <button class="btn btn-sm btn-danger">Xóa</button>
            </form>
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>

  {{ $products->links() }}
</div>
@endsection
