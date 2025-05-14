<?php

namespace App\Services\Marchant;

use App\Http\Requests\Marchant\OrderBalanceRequest;
use App\Models\Marchant\OrderBalance;
use App\Models\Payment\PaymentGateway;
use App\Traits\FileUploader;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Yajra\DataTables\DataTables;

class OrderBalanceService
{
    use FileUploader;
    public function getOrderBalanceInfo(Request $request): JsonResponse|Model|Builder
    {
        $searchKeyword = $request->input('search');

        $query = OrderBalance::query()
            ->where(function ($query) use ($searchKeyword) {
                $query->where(function ($q) use ($searchKeyword) {
                    $q->where('status', 'like', "%$searchKeyword%");
                });
                $query->where('created_by',loggedInUserId());
            })->latest();

        // dd( $query);

        return Datatables::of($query)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {

                $showBtn = '<button data-id="' . $row->id . '" class="btn btn-success btn-sm ms-lg-2 showOrderBtn" data-bs-toggle="modal" data-bs-target="#showModal">Show</button>';

                return $showBtn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function gatewayInfo(int $gatewayId): PaymentGateway
    {
        return PaymentGateway::query()->where('id', $gatewayId)->first();
    }

    public function getOrderDetails(int $orderId): OrderBalance
    {
        return OrderBalance::query()
            ->leftJoin('payment_gateways', 'orders.payment_gateway_id', '=', 'payment_gateways.id')
            ->select('orders.*', 'payment_gateways.gateway_name','payment_gateways.rate','payment_gateways.currency_code')
            ->where('orders.id', $orderId)->first();
    }

    public function storeOrderBalance(OrderBalanceRequest $request): Model
    {
        try {
            $orderData = $request->fields();
            $orderData['attachment_url'] = $this->uploadMedia($request, 'attachment_url', 'order');
            $orderData['ordered_by'] = loggedInUserId();

            $order = OrderBalance::query()->create($orderData);

            return $order;
        } catch (Exception $exception) {
            throw $exception;
        }
    }
}
