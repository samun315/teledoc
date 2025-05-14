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
use Yajra\DataTables\DataTables;

class TransferService
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
                $query->where('balance_transfers.created_by',loggedInUserId());
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
            ->addColumn('action', function ($row) {

                $showBtn = '<button data-id="' . $row->id . '" class="btn btn-success btn-sm ms-lg-2 showOrderBtn" data-bs-toggle="modal" data-bs-target="#showModal">Show</button>';

                return $showBtn;
            })
            ->rawColumns(['action', 'from_user', 'to_user'])
            ->make(true);
    }

    public function storeTransferBalance(array $data): Transfer|JsonResponse|bool
    {   
        try {
            $data['transfer_from_user'] = $data['created_by'];
            $data['status'] = 'Transferred';

            $account = Account::query()->where('user_id',$data['transfer_from_user'])->first();
            
            if ($account && $data['amount'] < $account->current_balance) {

                $from_user['current_balance'] = $account?->current_balance - $data['amount'];
                $from_user['updated_by'] = loggedInUserId();

                $account->update($from_user);

                return Transfer::create($data);
            }

            return false;
        
        } catch (Exception $exception) {
            report($exception);
            return response()->json(['error' => 'Something went wrong'], 500);
        }
    }
}
