<?php

namespace App\Http\Controllers;
use App\Models\Product;
use App\Models\OrderItem;
use App\Models\Vendor;
use App\Models\Payment;
use App\Models\Order;
use Illuminate\Routing\Controller;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    upadate(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $product->update($request->all());
        return response()->json($product);
    }
}
destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        return response()->json(['message' => 'Product deleted successfully']);
    }

    public function show($id)
    {
        $product = Product::with('vendor')->findOrFail($id);
        return response()->json($product);
    }

    public function index()
    {
        $products = Product::with('vendor')->get();
        return response()->json($products);
    }
}
    public function store(Request $request)
    {
        $product = Product::create($request->all());
        return response()->json($product, 201);
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $product->update($request->all());
        return response()->json($product);
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        return response()->json(['message' => 'Product deleted successfully']);
    }
}
    public function show($id)
    {
        $product = Product::with('vendor')->findOrFail($id);
        return response()->json($product);
    }