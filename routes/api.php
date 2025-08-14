use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;

// Auth routes (লগইন, রেজিস্ট্রেশন)
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// পাবলিকলি অ্যাক্সেসযোগ্য প্রোডাক্ট রাউট
Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{product}', [ProductController::class, 'show']);

Route::middleware('auth:sanctum')->group(function () {
    // সুরক্ষিত রাউট
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // ভেন্ডর-এর জন্য প্রোডাক্ট ম্যানেজমেন্ট
    Route::post('/vendor/products', [ProductController::class, 'store']);
    Route::put('/vendor/products/{product}', [ProductController::class, 'update']);
    Route::delete('/vendor/products/{product}', [ProductController::class, 'destroy']);

    // কাস্টমারের জন্য অর্ডার ম্যানেজমেন্ট
    Route::post('/orders', [OrderController::class, 'store']);
    Route::get('/orders/{order}', [OrderController::class, 'show']);
    Route::get('/orders', [OrderController::class, 'index']);

    // পেমেন্ট রাউট
    Route::post('/payments/bkash/create', [PaymentController::class, 'createBkashPayment']);
    Route::post('/payments/card/process', [PaymentController::class, 'processCardPayment']);
});