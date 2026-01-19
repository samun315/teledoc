<?php

namespace App\Services\Order;

use App\Models\Doctor\Doctor;
use App\Models\Doctor\DoctorEarning;
use App\Models\Order\Order;
use App\Models\Payment\Payment;
use Exception;
use Illuminate\Support\Facades\DB;

class OrderPaymentService
{
    public function processPayment(array $data): array
    {
        DB::beginTransaction();

        try {
            $order = Order::with('doctor')->findOrFail($data['order_id']);

            // Check if order is already paid
            if ($order->status === 'PAID') {
                throw new Exception('This order is already paid.');
            }

            // Check if order can be paid
            if (in_array($order->status, ['CANCELLED', 'FAILED', 'REFUNDED'])) {
                throw new Exception('This order cannot be paid. Current status: ' . $order->status);
            }

            $discount = floatval($data['discount'] ?? 0);
            $finalAmount = floatval($data['final_amount']);
            $paymentMethod = $data['payment_method'];
            $transactionId = $data['transaction_id'] ?? null;

            // Validate discount doesn't exceed amount
            if ($discount > $order->subtotal) {
                throw new Exception('Discount cannot exceed the order amount.');
            }

            // Update order with discount and new total
            $order->update([
                'discount' => $discount,
                'total_amount' => $finalAmount,
                'status' => 'PAID',
            ]);

            // Create payment record
            $payment = Payment::create([
                'order_id' => $order->order_id,
                'payment_method' => $paymentMethod,
                'amount' => $finalAmount,
                'currency' => 'BDT',
                'transaction_id' => $transactionId,
                'status' => 'SUCCESS',
                'paid_at' => now(),
            ]);

            // Calculate doctor earnings if order has doctor
            if ($order->doctor_id) {
                $this->createDoctorEarning($order);
            }

            DB::commit();

            return [
                'payment_id' => $payment->payment_id,
                'order_id' => $order->order_id,
                'status' => 'PAID'
            ];
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    private function createDoctorEarning(Order $order): void
    {
        $doctor = Doctor::find($order->doctor_id);
        
        if (!$doctor) {
            return;
        }

        // Get consultation fee from order (original subtotal, not discounted amount)
        $consultationFee = $order->subtotal;

        // Calculate platform commission (20% of consultation fee)
        $platformCommission = round($consultationFee * 0.20, 2);

        // Calculate doctor amount (consultation fee - platform commission)
        $doctorAmount = round($consultationFee - $platformCommission, 2);

        // Create doctor earning record
        DoctorEarning::create([
            'doctor_id' => $doctor->doctor_id,
            'order_id' => $order->order_id,
            'consultation_fee' => $consultationFee,
            'platform_commission' => $platformCommission,
            'doctor_amount' => $doctorAmount,
            'status' => 'PENDING', // Doctor payment status
        ]);
    }
}
