<?php

namespace App\Http\Controllers\StoreAdmin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    private function currentStore()
    {
        return auth()->user()->stores()->firstOrFail();
    }

    public function index()
    {
        $store = $this->currentStore();
        $orders = $store->orders()
            ->with('customer')
            ->orderByDesc('id')
            ->paginate(10);

        return view('store_admin.orders.index', compact('store','orders'));
    }

    public function show(Order $order)
    {
        $store = $this->currentStore();
        abort_if($order->store_id !== $store->id, 403);

        $order->load(['customer','items.product']);
        return view('store_admin.orders.show', compact('store','order'));
    }

    public function update(Request $request, Order $order)
    {
        $store = $this->currentStore();
        abort_if($order->store_id !== $store->id, 403);

        $request->validate([
            'status' => ['required','in:pending,confirmed,shipped,completed,cancelled'],
        ]);

        $order->update(['status' => $request->status]);

        return back()->with('success','Cập nhật trạng thái đơn thành công');
    }
}
