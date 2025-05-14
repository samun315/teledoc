<?php

namespace App\Services\Marchant;

use App\Http\Requests\Marchant\OrderBalanceRequest;
use App\Models\Marchant\OrderBalance;
use App\Models\Payment\Account;
use App\Models\Payment\PaymentGateway;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;

class OrderBalanceApproveService
{
    public function getOrderBalanceInfo(Request $request): JsonResponse|Model|Builder
    {
        $searchKeyword = $request->input('search');

        $query = OrderBalance::query()
            ->leftJoin('users', 'orders.created_by', '=', 'users.id')
            ->leftJoin('payment_gateways', 'orders.payment_gateway_id', '=', 'payment_gateways.id')
            ->where(function ($query) use ($searchKeyword) {
                $query->where(function ($q) use ($searchKeyword) {
                    $q->where('status', 'like', "%$searchKeyword%");
                });
            })->select('orders.*', 'users.role_id', 'users.full_name', 'users.phone', 'users.email', 'payment_gateways.gateway_name', 'payment_gateways.currency_code', 'payment_gateways.rate')
            ->latest();

        // dd( $query);

        return Datatables::of($query)
            ->addIndexColumn()
            ->addColumn('user', function ($row) {
                $name = $row->full_name ?? '';
                $phone = $row->phone ?? '';
                $email = $row->email ?? '';
                $user = $name . '<br>' . $phone . '<br>' . $email;
                return $user;
            })
            ->addColumn('action', function ($row) {

                $paidBtn = '';
                $cancelBtn = '';

                if ($row->status == 'Paid' || $row->status == 'Cancelled') {
                    $paidBtn = '';
                    $cancelBtn = '';
                } else {
                    $paidBtn = '<button type="button" data-id="' . $row->id . '" data-user ="' . $row->ordered_by . '" data-amount="' . $row->diamond_quantity . '" data-status="Paid" class="btn btn-warning btn-sm ms-lg-2 paidBtn">Paid</button>';
                    $cancelBtn = '<button type="button" data-id="' . $row->id . '" data-user ="' . $row->ordered_by . '" data-amount="' . $row->diamond_quantity . '" data-status="Cancelled" class="btn btn-danger btn-sm ms-lg-2 cancelledBtn">Cancel</button>';
                }

                $showBtn = '<button data-id="' . $row->id . '" class="btn btn-success btn-sm ms-lg-2 showOrderBtn" data-bs-toggle="modal" data-bs-target="#showModal">Show</button>';

                $button = '<div class="btn-group" role="group" aria-label="Basic example">
                ' . $paidBtn . '
                ' . $cancelBtn . '
                ' . $showBtn . '
                </div>';
                return $button;
            })
            ->rawColumns(['action', 'user'])
            ->make(true);
    }

    public function updateOrderBalanceRequestStatus(Request $request, int $id): Model|Builder|bool
    {
        DB::beginTransaction();
        try {

            $data = [
                'user_id' => $request->input('user_id'),
                'current_balance' => $request->input('order_amount'),
                'created_by' => loggedInUserId(),
            ];

            $orderStatus = [
                'status' => $request->input('status')
            ];

            $account = Account::query()->where('user_id',$data['user_id'])->first();

            if (!empty($account)) {
                $old_balance = $account?->current_balance;
                if ($orderStatus['status'] == 'Paid') {
                    $data['current_balance'] = $old_balance + $data['current_balance'];
                }else{
                    $data['current_balance'] = $old_balance - $data['current_balance'];
                }
                $account->update($data);
            }else{
                Account::query()->create($data);
            }
            // Find the order list by its ID or fail if not found.
            $order = OrderBalance::query()->where('id', $id)->first();

            // Update the order with the provided data.
            $order->update($orderStatus);

            DB::commit();

            return $order;
        } catch (Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }
}
