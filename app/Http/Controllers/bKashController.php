<?php
// app/Http/Controllers/bKashController.php
use App\Models\Product;
use App\Models\OrderItem;
use App\Models\Vendor;
use App\Models\Payment;
use App\Models\Order;
use Illuminate\Routing\Controller;      

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class bKashController extends Controller
{
    public function createPayment(Request $request)
    {
        // ১. bKash Auth টোকেন সংগ্রহ
        // ২. bKash "Create Payment" API কল
        // ৩. প্রাপ্ত redirectURL ফ্রন্টএন্ডে ফেরত পাঠানো
    }

    public function callback(Request $request)
    {
        // ১. bKash "Execute Payment" API কল
        // ২. পেমেন্ট সফল হলে ডেটাবেসে অর্ডার স্ট্যাটাস আপডেট
        // ৩. কাস্টমারকে সফলতার বার্তা সহ ফ্রন্টএন্ডে রিডিরেক্ট করা
    }
}
    