<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Store;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    public function index()
    {
        $stores = Store::orderBy('id', 'desc')->paginate(10);

        return view('admin.stores.index', compact('stores'));
    }

    public function create()
    {
        return view('admin.stores.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ]);

        Store::create([
            'name' => $request->name,
            'description' => $request->description,
            'status' => 'active',
            // owner_id tạm để null, sau sẽ gán store_admin
        ]);

        return redirect()->route('admin.stores.index')->with('success', 'Tạo store thành công');
    }

    // edit/update nếu muốn làm luôn trong ngày 4:

    public function edit(Store $store)
    {
        return view('admin.stores.edit', compact('store'));
    }

    public function update(Request $request, Store $store)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'status' => ['required', 'in:active,inactive'],
        ]);

        $store->update($request->only('name', 'description', 'status'));

        return redirect()->route('admin.stores.index')->with('success', 'Cập nhật store thành công');
    }
}
