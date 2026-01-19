<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Models\Order\Order;
use App\Services\Order\OrderPaymentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function __construct(protected OrderPaymentService $orderPaymentService) {}

    /**
     * Show payment page for an order
     */
    public function payment(int $order_id): View|RedirectResponse
    {
        $order = Order::with(['orderItems', 'doctor', 'user'])->findOrFail($order_id);

        // Check if order is already paid
        if ($order->status === 'PAID') {
            return redirect()->route('appointment.index')
                ->with('info', 'This order is already paid.');
        }

        // Check if order is cancelled or failed
        if (in_array($order->status, ['CANCELLED', 'FAILED', 'REFUNDED'])) {
            return redirect()->route('appointment.index')
                ->with('error', 'This order cannot be paid. Status: ' . $order->status);
        }

        return view('order.payment', compact('order'));
    }

    /**
     * Get order details for payment modal
     */
    public function getOrderDetails($order_id): JsonResponse
    {
        try {
            // Convert to integer and validate
            $orderId = (int) $order_id;
            
            if ($orderId <= 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid order ID provided: ' . $order_id
                ], 400);
            }
            
            // Log for debugging
            \Log::info('Fetching order details', ['order_id' => $orderId]);
            
            $order = Order::find($orderId);
            
            if (!$order) {
                \Log::warning('Order not found', ['order_id' => $orderId]);
                return response()->json([
                    'success' => false,
                    'message' => 'Order not found with ID: ' . $orderId . '. Please ensure the order exists in the database.'
                ], 404);
            }
            
            // Check if order is already paid
            if ($order->status === 'PAID') {
                return response()->json([
                    'success' => false,
                    'message' => 'This order is already paid.'
                ], 400);
            }
            
            return response()->json([
                'success' => true,
                'data' => [
                    'order_id' => $order->order_id,
                    'order_no' => $order->order_no,
                    'total_amount' => (float) $order->total_amount,
                    'discount' => (float) $order->discount,
                    'subtotal' => (float) $order->subtotal,
                ]
            ]);
        } catch (\Exception $e) {
            \Log::error('Error fetching order details', [
                'order_id' => $order_id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Error occurred: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Process payment
     */
    public function processPayment(Request $request): JsonResponse
    {
        $request->validate([
            'order_id' => 'required|exists:orders,order_id',
            'payment_method' => 'required|in:BKASH,NAGAD,ROCKET,CARD,CASH',
            'amount' => 'required|numeric|min:0',
            'discount' => 'nullable|numeric|min:0',
            'final_amount' => 'required|numeric|min:0',
            'transaction_id' => 'nullable|string|max:100',
        ]);

        try {
            $result = $this->orderPaymentService->processPayment($request->all());
            
            return response()->json([
                'success' => true,
                'message' => 'Payment processed successfully!',
                'data' => $result
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }
}
