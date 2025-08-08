<?php

namespace App\Services\Drug;

use App\Models\Drug\DrugDoses;
use App\Models\Drug\Prescription;
use App\Models\Drug\Subscription;
use App\Models\Patient\Patient;
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
    public function getPrescriptionList(Request $request): JsonResponse|Model|Builder
    {
        $searchKeyword = $request->input('search');
        $subscriptionTypeId = $request->input('subscription_type');

        $query = Prescription::query()
            ->leftJoin('patients', 'prescriptions.patient_id', '=', 'patients.patient_id')
            ->leftJoin('doctors', 'prescriptions.doctor_id', '=', 'doctors.doctor_id')
            ->select('prescriptions.*', 'patients.name as patient_name', 'doctors.name as doctor_name')->latest();

        if ($searchKeyword) {
            $query->where('patients.name', 'like', '%' . $searchKeyword . '%')
                ->orWhere('subscriptions.status', 'like', '%' . $searchKeyword . '%')
                ->orWhere('doctors.name', 'like', '%' . $searchKeyword . '%');
        }


        // $query->orderBy('orders');

        return Datatables::of($query)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {

                $editBtn = '<button data-id="' . $row?->prescription_id . '" class="btn btn-bg-info text-white btn-sm editPrescriptionBtn"><i class="fas fa-edit text-white"></i> Edit</button>';

                $button = '<div class="btn-group" role="group" aria-label="Basic example">
                            ' . $editBtn . '
                            </div>';
                return $button;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function createPrescription(array $data): Model|Builder|bool
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

    public function getPatientList(): Collection
    {
        return Patient::query()->where('active', 'YES')->get();
    }

    public function getSubscriptionList(int $subscriptionTypeId): Collection
    {
        return Subscription::query()->where('subscription_type_id', $subscriptionTypeId)->where('status', 'Active')->get();
    }


    public function createSubscription(Request $request, int $subscriptionTypeId): Model
    {
        DB::beginTransaction();
        try {
            $request->validate([
                'subscription_type_id' => 'nullable|exists:subscription_types,subscription_type_id',
                'subscription_name' => 'required|string',
            ]);

            $subscription = Subscription::create([
                'subscription_type_id' => $subscriptionTypeId,
                'subscription_name' => $request->subscription_name,
            ]);
            DB::commit();

            return $subscription;
        } catch (Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }

    public function getDrugDoseByType(int $drugTypeId): Collection
    {
        return DrugDoses::query()->where('drug_type_id', $drugTypeId)->where('status', 'Active')->get();
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
