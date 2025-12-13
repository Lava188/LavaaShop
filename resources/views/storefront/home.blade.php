@extends('layouts.app')
@section('content')
<div class="container">
  <h1>Danh sách cửa hàng</h1>
  <div class="row">
    @foreach($stores as $s)
      <div class="col-md-3 mb-3">
        <div class="card p-3">
          <h5>{{ $s->name }}</h5>
          <p>{{ $s->description }}</p>
          <a class="btn btn-sm btn-primary" href="{{ route('stores.show', $s) }}">Vào shop</a>
        </div>
      </div>
    @endforeach
  </div>
  {{ $stores->links() }}
</div>
@endsection
