<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = session('cart', ['store_id' => null, 'items' => []]);
        return view('cart.index', compact('cart'));
    }

    public function add(Product $product)
    {
        if ($product->status !== 'active' || $product->store->status !== 'active') {
            return back()->withErrors(['cart' => 'Sản phẩm hoặc cửa hàng không khả dụng.']);
        }

        $cart = session('cart', ['store_id' => null, 'items' => []]);

        // chỉ cho cart thuộc 1 store
        if ($cart['store_id'] && $cart['store_id'] !== $product->store_id) {
            return back()->withErrors(['cart' => 'Giỏ hàng chỉ chứa sản phẩm của 1 cửa hàng. Hãy xoá giỏ hàng trước khi mua store khác.']);
        }

        $cart['store_id'] = $product->store_id;
        $items = $cart['items'];

        $pid = (string)$product->id;
        if (!isset($items[$pid])) {
            $items[$pid] = [
                'product_id' => $product->id,
                'name' => $product->name,
                'price' => (float)$product->price,
                'qty' => 1,
            ];
        } else {
            $items[$pid]['qty'] += 1;
        }

        $cart['items'] = $items;
        session(['cart' => $cart]);

        return back()->with('success', 'Đã thêm vào giỏ hàng');
    }

    public function update(Request $request)
    {
        $request->validate([
            'qty' => ['required','array'],
        ]);

        $cart = session('cart', ['store_id' => null, 'items' => []]);

        foreach ($request->qty as $productId => $qty) {
            $qty = (int)$qty;
            if (isset($cart['items'][(string)$productId])) {
                if ($qty <= 0) unset($cart['items'][(string)$productId]);
                else $cart['items'][(string)$productId]['qty'] = $qty;
            }
        }

        // nếu giỏ rỗng thì reset store_id
        if (empty($cart['items'])) $cart['store_id'] = null;

        session(['cart' => $cart]);
        return back()->with('success','Cập nhật giỏ hàng thành công');
    }

    public function remove(string $productId)
    {
        $cart = session('cart', ['store_id' => null, 'items' => []]);
        unset($cart['items'][(string)$productId]);

        if (empty($cart['items'])) $cart['store_id'] = null;

        session(['cart' => $cart]);
        return back()->with('success','Đã xoá sản phẩm khỏi giỏ');
    }

    public function clear()
    {
        session()->forget('cart');
        return back()->with('success','Đã xoá giỏ hàng');
    }
}
