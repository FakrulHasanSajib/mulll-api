<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'items' => 'required|array',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'total_amount' => 'required|numeric|min:0',
        ]);

        // শুধুমাত্র লগইন করা কাস্টমারই অর্ডার করতে পারবে
        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthorized. Please login to place an order.'], 401);
        }

        try {
            DB::beginTransaction();

            $order = new Order();
            $order->user_id = Auth::id();
            $order->total_amount = $validatedData['total_amount'];
            $order->status = 'pending';
            $order->save();

            foreach ($validatedData['items'] as $item) {
                $orderItem = new OrderItem();
                $orderItem->order_id = $order->id;
                $orderItem->product_id = $item['product_id'];
                $orderItem->quantity = $item['quantity'];
                // এখানে প্রোডাক্টের দামও সংরক্ষণ করা উচিত, তবে আপাতত আমরা এটি এড়িয়ে যাচ্ছি
                $orderItem->save();
            }

            DB::commit();

            return response()->json(['message' => 'Order placed successfully!', 'order' => $order], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Failed to place order.', 'message' => $e->getMessage()], 500);
        }
    }
}