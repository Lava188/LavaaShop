<?php

namespace App\Http\Controllers;

use App\Models\Store;
use App\Models\Product;

class StorefrontController extends Controller
{
    public function home()
    {
        $stores = Store::where('status','active')->orderByDesc('id')->paginate(12);
        return view('storefront.home', compact('stores'));
    }

    public function store(Store $store)
    {
        abort_if($store->status !== 'active', 404);

        $products = $store->products()->where('status','active')->orderByDesc('id')->paginate(12);
        return view('storefront.store', compact('store','products'));
    }

    public function product(Product $product)
    {
        abort_if($product->status !== 'active', 404);

        $product->load('store');
        abort_if($product->store->status !== 'active', 404);

        return view('storefront.product', compact('product'));
    }
}
