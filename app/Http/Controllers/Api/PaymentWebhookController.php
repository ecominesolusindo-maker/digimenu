<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Support\Facades\Log;

class PaymentWebhookController extends Controller
{
    /**
     * Handle Midtrans Webhook (Mock)
     */
    public function midtrans(Request $request)
    {
        $payload = $request->all();
        Log::info('Midtrans Webhook Received', $payload);

        // Typical Midtrans payload contains:
        // order_id, transaction_status, gross_amount, payment_type
        
        $orderId = $payload['order_id'] ?? null;
        $transactionStatus = $payload['transaction_status'] ?? null;
        $grossAmount = $payload['gross_amount'] ?? null;
        $paymentType = $payload['payment_type'] ?? 'unknown';

        if (!$orderId || !$transactionStatus) {
            return response()->json(['message' => 'Invalid payload'], 400);
        }

        // Midtrans typically sends order_id as ORD-XXX. Let's find it.
        // We use withoutGlobalScopes() because API doesn't have a specific tenant logged in.
        $order = Order::withoutGlobalScopes()->where('order_number', $orderId)->first();

        if (!$order) {
            Log::warning('Webhook order not found', ['order_id' => $orderId]);
            return response()->json(['message' => 'Order not found'], 404);
        }

        // Update Order Payment Status
        if (in_array($transactionStatus, ['capture', 'settlement'])) {
            $order->update(['payment_status' => 'paid']);
            
            // If the order is pending, we can optionally move it to preparing.
            // But let's leave it pending for the kitchen to accept, or auto-accept if we want.
            // For now, let's keep status as is.

            // Record Payment
            Payment::withoutGlobalScopes()->create([
                'restaurant_id' => $order->restaurant_id,
                'order_id' => $order->id,
                'amount' => $grossAmount ?: $order->total_amount,
                'payment_method' => $paymentType,
                'status' => 'completed',
            ]);

        } elseif (in_array($transactionStatus, ['deny', 'cancel', 'expire'])) {
            $order->update(['payment_status' => 'failed']);
            
            Payment::withoutGlobalScopes()->create([
                'restaurant_id' => $order->restaurant_id,
                'order_id' => $order->id,
                'amount' => $grossAmount ?: $order->total_amount,
                'payment_method' => $paymentType,
                'status' => 'failed',
            ]);
        }

        return response()->json(['message' => 'OK'], 200);
    }
}
