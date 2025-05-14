<?php

namespace App\Services\Marchant;

use App\Models\Marchant\Transfer;
use App\Models\Payment\Account;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class TransferApproveService
{
    public function getTransferBalanceInfo(Request $request): JsonResponse|Model|Builder
    {
        $searchKeyword = $request->input('search');

        $query = Transfer::query()
            ->leftJoin('users as fu', 'balance_transfers.transfer_from_user', '=', 'fu.id')
            ->leftJoin('users as tu', 'balance_transfers.transfer_to_user', '=', 'tu.id')
            ->where(function ($query) use ($searchKeyword) {
                $query->where(function ($q) use ($searchKeyword) {
                    $q->where('status', 'like', "%$searchKeyword%")
                        ->orWhere('fu.email', 'like', '%' . $searchKeyword . '%')
                        ->orWhere('fu.full_name', 'like', '%' . $searchKeyword . '%')
                        ->orWhere('tu.full_name', 'like', '%' . $searchKeyword . '%')
                        ->orWhere('tu.email', 'like', '%' . $searchKeyword . '%');
                });
            })
            ->select('balance_transfers.*', 'fu.role_id as fu_role', 'fu.full_name as fu_name', 'fu.phone as fu_phone', 'fu.email as fu_email', 'tu.role_id as tu_role', 'tu.full_name as tu_name', 'tu.phone as tu_phone', 'tu.email as tu_email')
            ->latest();

        // dd( $query);

        return Datatables::of($query)
            ->addIndexColumn()
            ->addColumn('from_user', function ($row) {
                $from_name = $row->fu_name ?? '';
                $from_phone = $row->fu_phone ?? '';
                $from_email = $row->fu_email ?? '';
                $from_user = $from_name . '<br>' . $from_phone . '<br>' . $from_email;
                return $from_user;
            })
            ->addColumn('to_user', function ($row) {
                $to_name = $row->tu_name ?? '';
                $to_phone = $row->tu_phone ?? '';
                $to_email = $row->tu_email ?? '';
                $to_user = $to_name . '<br>' . $to_phone . '<br>' . $to_email;
                return $to_user;
            })
            // ->addColumn('action', function ($row) {

            //     $transferBtn = '';
            //     $cancelBtn = '';

            //     if ($row->status == 'Transferred' || $row->status == 'Cancelled') {
            //         $transferBtn = '';
            //         $cancelBtn = '';
            //     } else {
            //         $transferBtn = '<button type="button" data-id="' . $row->id . '"  data-status="Transferred" class="btn btn-success btn-sm ms-lg-2 transferredBtn">Transfer</button>';
            //         $cancelBtn = '<button type="button" data-id="' . $row->id . '" data-status="Cancelled" class="btn btn-danger btn-sm ms-lg-2 cancelledBtn">Cancel</button>';
            //     }

            //     $button = '<div class="btn-group" role="group" aria-label="Basic example">
            //     ' . $transferBtn . '
            //     ' . $cancelBtn . '
            //     </div>';
            //     return $button;
            // })
            ->rawColumns(['from_user', 'to_user'])
            ->make(true);
    }


    public function updateTransferBalanceStatus(Request $request, int $id): Model|Builder|bool
    {
        DB::beginTransaction();
        try {

            $transferInfo = Transfer::query()->where('id', $id)->first();

            if (!empty($transferInfo)) {
                $givenAmount = $transferInfo->amount;
                $fromUser = $transferInfo->transfer_from_user;
                $toUser = $transferInfo->transfer_to_user;

                $transferStatus = [
                    'status' => $request->input('status'),
                    'updated_by' => loggedInUserId(),
                ];

                if ($request->input('status') == 'Transferred') {
                    $fromUserAccount = Account::query()->where('user_id', $fromUser)->first();

                    if (!empty($fromUserAccount)) {
                        $from_user['current_balance'] = $fromUserAccount?->current_balance - $givenAmount;
                        $from_user['updated_by'] = loggedInUserId();

                        $fromUserAccount->update($from_user);
                    }

                    $toUserAccount = Account::query()->where('user_id', $toUser)->first();

                    if (!empty($toUserAccount)) {
                        $to_user['current_balance'] = $toUserAccount?->current_balance + $givenAmount;
                        $to_user['updated_by'] = loggedInUserId();
                        
                        $toUserAccount->update($to_user);
                    }
                }

                $transferInfo->update($transferStatus);
            }

            DB::commit();

            return $transferInfo;
        } catch (Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }
}
