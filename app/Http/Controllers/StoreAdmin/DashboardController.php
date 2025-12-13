<?php

namespace App\Http\Controllers\StoreAdmin;

use App\Http\Controllers\Controller;
use App\Models\Order;

class DashboardController extends Controller
{
    public function index()
    {
        $store = auth()->user()->stores()->firstOrFail();

        $stats = [
            'products' => $store->products()->count(),
            'orders_total' => $store->orders()->count(),
            'orders_pending' => $store->orders()->where('status','pending')->count(),
        ];

        return view('store_admin.dashboard', compact('store', 'stats'));
    }
}
