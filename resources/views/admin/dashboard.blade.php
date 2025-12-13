@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Super Admin Dashboard</h1>
    <p>Xin chào, {{ auth()->user()->name }}</p>

    <ul>
        <li><a href="{{ route('admin.stores.index') }}">Quản lý Store</a></li>
    </ul>
</div>
@endsection
