<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Sinkronisasi status order yang belum dibayar dengan API Midtrans
        $unpaidOrders = Order::where('status', 'Unpaid')
            ->where('created_at', '>=', now()->subDays(30))
            ->get();

        if (!blank(config('midtrans.server_key')) && $unpaidOrders->isNotEmpty()) {
            \Midtrans\Config::$serverKey = config('midtrans.server_key');
            \Midtrans\Config::$isProduction = (bool) config('midtrans.is_production');
            \Midtrans\Config::$isSanitized = true;
            \Midtrans\Config::$is3ds = true;

            foreach ($unpaidOrders as $order) {
                try {
                    $status = \Midtrans\Transaction::status($order->order_id);
                    $transactionStatus = strtolower((string) $status->transaction_status);
                    $paidStatuses = ['settlement', 'capture'];

                    if (in_array($transactionStatus, $paidStatuses, true)) {
                        \Illuminate\Support\Facades\DB::transaction(function () use ($order, $status) {
                            $order->load('items');
                            $payment = \App\Models\Payment::where('order_id', $order->id)->lockForUpdate()->first();
                            if ($payment) {
                                $payment->status = $status->transaction_status ?: $payment->status;
                                $payment->transaction_id = $status->transaction_id ?: $payment->transaction_id;
                                $payment->type = $status->payment_type ?: $payment->type;
                                $payment->save();
                            }

                            foreach ($order->items as $item) {
                                $product = \App\Models\Product::whereKey($item->product_id)->lockForUpdate()->first();
                                if ($product) {
                                    $product->quantity = max(0, $product->quantity - $item->quantity);
                                    $product->inStock = $product->quantity > 0 ? 1 : 0;
                                    $product->save();
                                }
                            }

                            $order->status = 'Paid';
                            $order->paid_at = $status->transaction_time ?: now();
                            $order->save();

                            // Bersihkan cart items
                            foreach ($order->items as $item) {
                                $cart = \App\Models\Cart::where('user_id', $order->user_id)
                                    ->where('product_id', $item->product_id)
                                    ->whereNull('paid_at')
                                    ->lockForUpdate()
                                    ->first();

                                if ($cart) {
                                    if ($cart->quantity <= $item->quantity) {
                                        $cart->delete();
                                    } else {
                                        $cart->quantity -= $item->quantity;
                                        $cart->save();
                                    }
                                }
                            }
                        });
                    }
                } catch (\Exception $e) {
                    // Abaikan kesalahan
                }
            }
        }

        // Basic counts
        $category = Category::count();
        $brand = Brand::count();
        $product = Product::count();
        $order = Order::count();
        
        // Order statistics
        $paidOrders = Order::where('status', 'Paid')->count();
        $unpaidOrders = Order::where('status', 'Unpaid')->count();
        
        // Revenue statistics
        $totalRevenue = Order::where('status', 'Paid')
            ->selectRaw('COALESCE(SUM(gross_amount + courir_price), 0) as total')
            ->value('total');
        $monthlyRevenue = Order::where('status', 'Paid')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->selectRaw('COALESCE(SUM(gross_amount + courir_price), 0) as total')
            ->value('total');
        
        // Recent orders (last 5)
        $recentOrders = Order::with('items.product')
            ->latest()
            ->take(5)
            ->get()
            ->map(function ($order) {
                $items = $order->items->map(function ($item) {
                    return [
                        'title' => $item->product?->title ?? 'Produk tidak ditemukan',
                        'quantity' => $item->quantity,
                    ];
                });
                return [
                    'id' => $order->id,
                    'order_id' => $order->order_id,
                    'gross_amount' => $order->gross_amount + $order->courir_price,
                    'status' => $order->status,
                    'created_at' => $order->created_at->format('d M Y, H:i'),
                    'items' => $items,
                ];
            });
        
        // Low stock products (quantity < 5)
        $lowStockProducts = Product::where('quantity', '<', 5)
            ->where('quantity', '>', 0)
            ->get(['id', 'title', 'quantity']);
        
        return Inertia::render('Admin/Dashboard',[
            'category' => $category,
            'brand' => $brand,
            'product' => $product,
            'order' => $order,
            'paidOrders' => $paidOrders,
            'unpaidOrders' => $unpaidOrders,
            'totalRevenue' => $totalRevenue,
            'monthlyRevenue' => $monthlyRevenue,
            'recentOrders' => $recentOrders,
            'lowStockProducts' => $lowStockProducts,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
