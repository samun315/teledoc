<?php

namespace App\Services\Payment;

use App\Models\Order\Order;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Yajra\DataTables\DataTables;

class PendingPaymentService
{
    public function getPendingPayments(Request $request): JsonResponse
    {
        $searchKeyword = $request->input('search');

        $query = Order::query()
            ->with(['user', 'doctor', 'payments' => function ($q) {
                $q->where('status', 'INITIATED');
            }])
            ->where('status', 'PENDING')
            ->where(function ($query) use ($searchKeyword) {
                if ($searchKeyword) {
                    $query->where('order_no', 'like', "%$searchKeyword%")
                        ->orWhere('total_amount', 'like', "%$searchKeyword%")
                        ->orWhere('subtotal', 'like', "%$searchKeyword%")
                        ->orWhereHas('user', function ($userQuery) use ($searchKeyword) {
                            $userQuery->where('name', 'like', "%$searchKeyword%")
                                ->orWhere('email', 'like', "%$searchKeyword%");
                        })
                        ->orWhereHas('doctor', function ($doctorQuery) use ($searchKeyword) {
                            $doctorQuery->where('name', 'like', "%$searchKeyword%")
                                ->orWhere('title', 'like', "%$searchKeyword%");
                        });
                }
            })
            ->select('orders.*')
            ->orderBy('orders.created_at', 'desc');

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('order_no', function ($row) {
                return $row->order_no ?? 'N/A';
            })
            ->addColumn('customer_name', function ($row) {
                return $row->user->name ?? 'N/A';
            })
            ->addColumn('doctor_name', function ($row) {
                if ($row->doctor) {
                    $doctor = $row->doctor;
                    $name = trim(($doctor->title ?? '') . ' ' . ($doctor->name ?? ''));
                    return $name ?: 'N/A';
                }
                return 'N/A';
            })
            ->addColumn('amount', function ($row) {
                return number_format($row->total_amount ?? $row->subtotal ?? 0, 2) . ' BDT';
            })
            ->addColumn('status', function ($row) {
                return '<span class="badge badge-light-warning">Pending</span>';
            })
            ->addColumn('created_at', function ($row) {
                return $row->created_at ? $row->created_at->format('Y-m-d H:i:s') : 'N/A';
            })
            ->addColumn('action', function ($row) {
                $payment = $row->payments->first();
                $paymentId = $payment ? $payment->payment_id : '';

                $makePaymentBtn = '<button type="button" data-payment-id="' . $paymentId . '" data-order-id="' . $row->order_id . '" class="btn btn-primary btn-sm make-payment-btn" title="Make Payment">
                    <i class="fas fa-credit-card"></i> Make Payment
                </button>';

                return '<div class="btn-group" role="group">' . $makePaymentBtn . '</div>';
            })
            ->rawColumns(['status', 'action'])
            ->make(true);
    }
}
