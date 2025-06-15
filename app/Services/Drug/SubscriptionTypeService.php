<?php

namespace App\Services\Drug;

use App\Models\Drug\SubscriptionType;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class SubscriptionTypeService
{
    public function getSubscriptionTypeList(Request $request): JsonResponse|Model|Builder
    {
        $searchKeyword = $request->input('search');

        $query = SubscriptionType::select(['subscription_type_id', 'subscription_type', 'status'])
            ->orderBy('orders');

        if (!empty($searchKeyword)) {
            $query->where(function ($q) use ($searchKeyword) {
                $q->where('subscription_type', 'like', '%' . $searchKeyword . '%')
                    ->orWhere('status', 'like', '%' . $searchKeyword . '%');
            });
        }


        // $query->orderBy('orders');

        return Datatables::of($query)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {

                $editBtn = '<button data-id="' . $row?->subscription_type_id . '" class="btn btn-bg-info text-white btn-sm editSubscriptionTypeBtn" data-bs-toggle="modal" data-bs-target="#showModal"><i class="fas fa-edit text-white"></i> Edit</button>';

                $button = '<div class="btn-group" role="group" aria-label="Basic example">
                            ' . $editBtn . '
                            </div>';
                return $button;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function createSubscriptionType(array $data): Model|Builder|bool
    {
        DB::beginTransaction();
        try {

            $subscriptionType = SubscriptionType::query()->create($data);
            DB::commit();

            return $subscriptionType;
        } catch (Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }

    public function getSubscriptionTypeById(int $subscriptionTypeId): Model|Builder
    {
        return SubscriptionType::find($subscriptionTypeId);
    }

    public function updateSubscriptionType(array $updateData, int $subscriptionTypeId): int
    {
        $subscriptionType = $this->getSubscriptionTypeById($subscriptionTypeId);

        return $subscriptionType->update($updateData);
    }

    public function orderSubscription(array $subscriptionItems): Model|Builder|Collection|null|array
    {
        $subscriptionItem = [];
        foreach ($subscriptionItems as $index => $item) {

            $subscriptionItem = SubscriptionType::findOrFail($item?->id);

            $subscriptionItem->update([
                'orders' => $index + 1
            ]);
        }

        return $subscriptionItem;
    }
}
