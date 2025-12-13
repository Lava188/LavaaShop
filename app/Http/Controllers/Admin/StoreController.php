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
            'name' => ['required','string','max:255'],
            'description' => ['nullable','string'],
            'owner_email' => ['required','email','max:255'],
            'owner_password' => ['nullable','string','min:6'],
        ]);

        // 1) tìm hoặc tạo user store_admin theo email
        $owner = User::where('email', $request->owner_email)->first();

        if (!$owner) {
            $plainPassword = $request->owner_password ?: Str::random(10);

            $owner = User::create([
                'name' => 'Store Admin - ' . $request->name,
                'email' => $request->owner_email,
                'password' => Hash::make($plainPassword),
                'role' => 'store_admin',
            ]);

            // Gợi ý: có thể flash password ra session để admin copy lưu lại
            session()->flash('store_admin_password', $plainPassword);
        } else {
            // Nếu email đã tồn tại mà không phải store_admin thì chặn (tránh lẫn role)
            if ($owner->role !== 'store_admin') {
                return back()->withErrors([
                    'owner_email' => 'Email này đã tồn tại nhưng không phải tài khoản store_admin.'
                ])->withInput();
            }
        }

        // 2) tạo store và gán owner_id
        \App\Models\Store::create([
            'name' => $request->name,
            'description' => $request->description,
            'owner_id' => $owner->id,
            'status' => 'active',
        ]);

        return redirect()->route('admin.stores.index')
            ->with('success', 'Tạo store thành công' . (session('store_admin_password') ? ' (đã tự tạo mật khẩu cho store_admin)' : ''));
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
