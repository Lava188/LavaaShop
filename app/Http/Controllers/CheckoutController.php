<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = session('cart', ['store_id' => null, 'items' => []]);
        if (!$cart['store_id'] || empty($cart['items'])) {
            return redirect()->route('cart.index')->withErrors(['cart' => 'Giỏ hàng đang trống.']);
        }

        $store = Store::findOrFail($cart['store_id']);
        return view('checkout.index', compact('cart','store'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'address' => ['required','string','max:1000'],
        ]);

        $cart = session('cart', ['store_id' => null, 'items' => []]);
        if (!$cart['store_id'] || empty($cart['items'])) {
            return redirect()->route('cart.index')->withErrors(['cart' => 'Giỏ hàng đang trống.']);
        }

        $store = Store::where('status','active')->findOrFail($cart['store_id']);

        return DB::transaction(function () use ($cart, $store, $request) {
            $total = 0;

            // validate products still valid & compute total
            foreach ($cart['items'] as $row) {
                $p = Product::where('status','active')->where('store_id',$store->id)->findOrFail($row['product_id']);
                $total += ((float)$p->price) * ((int)$row['qty']);
            }

            $order = Order::create([
                'customer_id' => auth()->id(),
                'store_id' => $store->id,
                'total_amount' => $total,
                'status' => 'pending',
                'address' => $request->address,
            ]);

            foreach ($cart['items'] as $row) {
                $p = Product::findOrFail($row['product_id']);

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $p->id,
                    'quantity' => (int)$row['qty'],
                    'unit_price' => (float)$p->price,
                ]);
            }

            session()->forget('cart');

            return redirect()->route('customer.orders.show', $order)->with('success','Đặt hàng thành công');
        });
    }
}
