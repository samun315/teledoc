<?php

namespace App\Services\Payment;

use App\Models\Payment\Account;
use App\Models\Payment\BalanceAdjust;
use App\Models\Payment\PaymentGateway;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class BalanceAdjustService
{

    public function storeAdjustBalance(array $data): bool|JsonResponse
    {
        DB::beginTransaction();
        try {
            $account = Account::query()->where('user_id', $data['user_id'])->first();

            $data['before_balance'] = $account->current_balance;

            if ($data['type'] == 'add') {
                $data['type'] = 'credit';
                $data['after_balance'] = $data['before_balance'] + $data['balance'];

                $currentAccount['current_balance'] = $account->current_balance + $data['balance'];
            } else {
                if ($data['before_balance'] >= $data['balance']) {
                    $data['type'] = 'debit';
                    $data['after_balance'] = $data['before_balance'] - $data['balance'];

                    $currentAccount['current_balance'] = $account->current_balance - $data['balance'];
                }
            }
            $updateAccount = $account->update($currentAccount);

            BalanceAdjust::query()->create($data);

            DB::commit();

            return $updateAccount;
        } catch (Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }

    public function getBalanceAdjustList(Request $request): JsonResponse
    {
        $searchKeyword = $request->input('search');

        $query = BalanceAdjust::query()
            ->leftJoin('users', 'balance_adjust.user_id', '=', 'users.id')
            ->where(function ($query) use ($searchKeyword) {
                $query->where(function ($q) use ($searchKeyword) {
                    $q->where('type', 'like', "%$searchKeyword%")
                        ->orWhere('users.full_name', 'like', "%$searchKeyword%")
                        ->orWhere('users.email', 'like', "%$searchKeyword%")
                        ->orWhere('users.phone', 'like', "%$searchKeyword%");
                });
            })
            ->select('balance_adjust.*', 'users.role_id', 'users.full_name', 'users.phone', 'users.email');

        return Datatables::of($query)
            ->addIndexColumn()
            ->addColumn('user', function ($row) {
                $name = $row->full_name ?? '';
                $phone = $row->phone ?? '';
                $email = $row->email ?? '';
                $user = $name . '<br>' . $phone . '<br>' . $email;
                return $user;
            })
            ->rawColumns(['user'])
            ->make(true);
    }
}
