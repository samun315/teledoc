<?php

namespace App\Services\Marchant;

use App\Models\Marchant\BalanceRequest;
use App\Models\Payment\Account;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class BalanceRequestApproveService
{

    public function getBalanceRequest(Request $request): JsonResponse|Model|Builder
    {
        $searchKeyword = $request->input('search');

        $query = BalanceRequest::query()->leftJoin('users', 'balance_requests.created_by', '=', 'users.id')
            ->where(function ($query) use ($searchKeyword) {
                $query->where(function ($q) use ($searchKeyword) {
                    $q->where('mobile_number', 'like', "%$searchKeyword%")
                        ->orWhere('status', 'like', "%$searchKeyword%")
                        ->orWhere('users.full_name', 'like', "%$searchKeyword%")
                        ->orWhere('users.email', 'like', "%$searchKeyword%")
                        ->orWhere('users.phone', 'like', "%$searchKeyword%");
                });
            })->select('balance_requests.*', 'users.role_id', 'users.full_name', 'users.phone', 'users.email')->latest();

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
                $transferBtn = '';
                $cancelBtn = '';

                if ($row->status == 'Transferred' || $row->status == 'Cancelled') {
                    $transferBtn = '';
                    $cancelBtn = '';
                } else {
                    $transferBtn = '<button type="button" data-id="' . $row->id . '" data-status="Transferred" class="btn btn-success btn-sm ms-lg-2 transferredBtn">Paid</button>';
                    $cancelBtn = '<button type="button" data-id="' . $row->id . '" data-status="Cancelled" class="btn btn-danger btn-sm ms-lg-2 cancelledBtn">Cancel</button>';
                }

                $button = '<div class="btn-group" role="group" aria-label="Basic example">
                            ' . $transferBtn . '
                            ' . $cancelBtn . '
                            </div>';
                return $button;
            })
            ->rawColumns(['action', 'user'])
            ->make(true);
    }

    public function updateBalanceRequestStatus(Request $request, int $id): Model|Builder|bool
    {
        DB::beginTransaction();
        try {

            // Find the whitelist by its ID or fail if not found.
            $balance = BalanceRequest::query()->where('id', $id)->first();

            if (!empty($balance)) {
                $givenAmount = $balance->amount;
                $fromUser = $balance->created_by;

                $requestStatus = [
                    'status' => $request->input('status'),
                    'updated_by' => loggedInUserId(),
                ];

                if ($request->input('status') == 'Transferred') {

                    // Update the whitelist with the provided data.
                    $balance->update($requestStatus);
                } else {
                    $fromUserAccount = Account::query()->where('user_id', $fromUser)->first();

                    if (!empty($fromUserAccount)) {
                        $from_user['current_balance'] = $fromUserAccount?->current_balance + $givenAmount;
                        $from_user['updated_by'] = loggedInUserId();

                        $fromUserAccount->update($from_user);
                    }
                    $balance->update($requestStatus);
                }
            }

            DB::commit();

            return $balance;
        } catch (Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }
}
