<?php

namespace App\Services\Marchant;

use App\Models\Marchant\BalanceRequest;
use App\Models\Marchant\RequestWhitelist;
use App\Models\Payment\Account;
use Exception;
use FontLib\Table\Type\name;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Yajra\DataTables\DataTables;

class BalanceRequestService
{
    public function getRequestInfo(Request $request): JsonResponse|Model|Builder
    {
        $searchKeyword = $request->input('search');

        $query = BalanceRequest::query()
            ->where(function ($query) use ($searchKeyword) {
                $query->where(function ($q) use ($searchKeyword) {
                    $q->where('mobile_number', 'like', "%$searchKeyword%")
                        ->orWhere('status', 'like', "%$searchKeyword%");
                });
                $query->where('created_by', loggedInUserId());
            })->latest();

        // dd( $query);

        return Datatables::of($query)
            ->addIndexColumn()
            ->make(true);
    }

    public function storeBalanceRequest(array $data): Model|JsonResponse|bool
    {
        try {
            // $data['transfer_from_user'] = $data['created_by'];

            $account = Account::query()->where('user_id', $data['created_by'])->first();

            if ($account && $data['amount'] < $account->current_balance) {

                $from_user['current_balance'] = $account?->current_balance - $data['amount'];
                $from_user['updated_by'] = loggedInUserId();

                $account->update($from_user);

                return BalanceRequest::query()->create($data);
            }

            return false;
        } catch (Exception $exception) {
            report($exception);
            return response()->json(['error' => 'Something went wrong'], 500);
        }
    }
}
