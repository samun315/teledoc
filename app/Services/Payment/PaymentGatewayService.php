<?php

namespace App\Services\Payment;

use App\Models\Payment\PaymentGateway;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Yajra\DataTables\DataTables;

class PaymentGatewayService
{

    public function storeGateway(array $data): PaymentGateway|JsonResponse
    {
        return PaymentGateway::query()->create($data);
    }

    public function getPaymentGateway(Request $request): JsonResponse
    {
        $searchKeyword = $request->input('search');

        $query = PaymentGateway::query()->where(function ($query) use ($searchKeyword) {
            $query->where(function ($q) use ($searchKeyword) {
                $q->where('gateway_name', 'like', "%$searchKeyword%")
                    ->orWhere('currency_code', 'like', "%$searchKeyword%")
                    ->orWhere('active', 'like', "%$searchKeyword%")
                    ->orWhere('rate', 'like', "%$searchKeyword%");
            });
        })
            ->select('payment_gateways.*');

        return Datatables::of($query)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {

                $detailsBtn = '<button type="button" data-id="' . $row->id . '" class="btn btn-info btn-sm detailsGatewayBtn me-2" data-bs-toggle="modal" data-bs-target="#showDetailModal">Details</button>';

                $editBtn = '<button data-id="' . $row->id . '" class="btn btn-warning btn-sm editGatewayBtn me-2" data-bs-toggle="modal" data-bs-target="#showModal">Edit</button>';

                $deleteBtn = '<button type="button" data-id="' . $row->id . '" class="btn btn-danger btn-sm deleteGatewayBtn" >Delete</button>';

                $button = '<div class="btn-group" role="group" aria-label="Basic example">
                ' . $detailsBtn . '
                ' . $editBtn . '
                 ' . $deleteBtn . '
                </div>';
                return $button;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function updateGatewayInfo(array $updateData, int $gatewayId): bool
    {
        $user = PaymentGateway::query()->where('id', $gatewayId)->first();

        return $user->update($updateData);
    }
}
