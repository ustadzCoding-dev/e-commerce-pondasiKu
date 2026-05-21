<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $successfulStatuses = ['settlement', 'capture', 'paid'];
        $pendingStatuses = ['pending'];
        $failedStatuses = ['expire', 'cancel', 'deny', 'unpaid'];

        $stats = [
            'total' => Payment::count(),
            'successful' => Payment::whereIn('status', $successfulStatuses)->count(),
            'pending' => Payment::whereIn('status', $pendingStatuses)->count(),
            'failed' => Payment::whereIn('status', $failedStatuses)->count(),
        ];

        $payments = Payment::query()
            ->with(['order.items.product'])
            ->when($request->search, function ($query, $search) {
                $query->where(function ($searchQuery) use ($search) {
                    $searchQuery->where('status', 'like', "%{$search}%")
                        ->orWhere('type', 'like', "%{$search}%")
                        ->orWhere('transaction_id', 'like', "%{$search}%")
                        ->orWhere('order_id', 'like', "%{$search}%")
                        ->orWhereHas('order', function ($orderQuery) use ($search) {
                            $orderQuery->where('order_id', 'like', "%{$search}%");
                        });
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return Inertia::render('Admin/Payment/Index', [
            'payments' => $payments,
            'filters' => $request->only(['search']),
            'stats' => $stats,
        ]);
    }
}
