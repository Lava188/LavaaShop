<?php

namespace App\Http\Controllers\StoreAdmin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    private function currentStore()
    {
        return auth()->user()->stores()->firstOrFail();
    }

    public function index()
    {
        $store = $this->currentStore();
        $products = $store->products()->orderByDesc('id')->paginate(10);

        return view('store_admin.products.index', compact('store','products'));
    }

    public function create()
    {
        $store = $this->currentStore();
        return view('store_admin.products.create', compact('store'));
    }

    public function store(Request $request)
    {
        $store = $this->currentStore();

        $request->validate([
            'name' => ['required','string','max:255'],
            'description' => ['nullable','string'],
            'price' => ['required','numeric','min:0'],
            'status' => ['required','in:active,inactive'],
        ]);

        Product::create([
            'store_id' => $store->id,
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'status' => $request->status,
        ]);

        return redirect()->route('store.products.index')->with('success','Tạo sản phẩm thành công');
    }

    public function edit(Product $product)
    {
        $store = $this->currentStore();
        abort_if($product->store_id !== $store->id, 403);

        return view('store_admin.products.edit', compact('store','product'));
    }

    public function update(Request $request, Product $product)
    {
        $store = $this->currentStore();
        abort_if($product->store_id !== $store->id, 403);

        $request->validate([
            'name' => ['required','string','max:255'],
            'description' => ['nullable','string'],
            'price' => ['required','numeric','min:0'],
            'status' => ['required','in:active,inactive'],
        ]);

        $product->update($request->only('name','description','price','status'));

        return redirect()->route('store.products.index')->with('success','Cập nhật sản phẩm thành công');
    }

    public function destroy(Product $product)
    {
        $store = $this->currentStore();
        abort_if($product->store_id !== $store->id, 403);   

        $product->delete();
        return redirect()->route('store.products.index')->with('success','Xóa sản phẩm thành công');
    }
}
