<?php

namespace App\Services\Drug;

use App\Models\Drug\Subscription;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class PrescriptionService
{
    public function getSubscriptionList(Request $request): JsonResponse|Model|Builder
    {
        $searchKeyword = $request->input('search');
        $subscriptionTypeId = $request->input('subscription_type');

        $query = Subscription::query()
            ->leftJoin('subscription_types', 'subscriptions.subscription_type_id', '=', 'subscription_types.subscription_type_id')
            ->select('subscriptions.*', 'subscription_types.subscription_type')->latest();

        if ($searchKeyword) {
            $query->where('subscriptions.subscription_name', 'like', '%' . $searchKeyword . '%')
                ->orWhere('subscriptions.status', 'like', '%' . $searchKeyword . '%')
                ->orWhere('subscription_types.subscription_type', 'like', '%' . $searchKeyword . '%');
        }

        if ($subscriptionTypeId) {
            $query->where('subscriptions.subscription_type_id', '=',   $subscriptionTypeId);
        }


        // $query->orderBy('orders');

        return Datatables::of($query)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {

                $editBtn = '<button data-id="' . $row?->subscription_id . '" class="btn btn-bg-info text-white btn-sm editSubscriptionBtn" data-bs-toggle="modal" data-bs-target="#showModal"><i class="fas fa-edit text-white"></i> Edit</button>';

                $button = '<div class="btn-group" role="group" aria-label="Basic example">
                            ' . $editBtn . '
                            </div>';
                return $button;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function createSubscription(array $data): Model|Builder|bool
    {
        DB::beginTransaction();
        try {

            $subscriptionType = Subscription::query()->create($data);
            DB::commit();

            return $subscriptionType;
        } catch (Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }

    public function getSubscriptionById(int $subscriptionId): Model|Builder
    {
        return Subscription::find($subscriptionId);
    }

    public function updateSubscription(array $updateData, int $subscriptionId): int
    {
        $subscription = $this->getSubscriptionById($subscriptionId);

        return $subscription->update($updateData);
    }
}
