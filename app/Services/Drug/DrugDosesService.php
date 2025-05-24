<?php

namespace App\Services\Drug;

use App\Models\Drug\DrugDoses;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class DrugDosesService
{
    public function getDrugDosesList(Request $request): JsonResponse|Model|Builder
    {
        $searchKeyword = $request->input('search');
        $drugTypeId = $request->input('drug_type');

        $query = DrugDoses::query()
            ->leftJoin('drug_types', 'drug_doses.drug_type_id', '=', 'drug_types.drug_type_id')
            ->select('drug_doses.*', 'drug_types.drug_type')->latest();

        if ($searchKeyword) {
            $query->where('drug_doses.drug_dose', 'like', '%' . $searchKeyword . '%')
                ->orWhere('drug_doses.status', 'like', '%' . $searchKeyword . '%');
        }

        if ($drugTypeId) {
            $query->where('drug_doses.drug_type_id', '=',   $drugTypeId);
        }

        return Datatables::of($query)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {

                $editBtn = '<button data-id="' . $row?->drug_dose_id . '" class="btn btn-bg-info text-white btn-sm editDrugDoseBtn" data-bs-toggle="modal" data-bs-target="#showModal"><i class="fas fa-edit text-white"></i> Edit</button>';

                $button = '<div class="btn-group" role="group" aria-label="Basic example">
                            ' . $editBtn . '
                            </div>';
                return $button;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function createDrugDose(array $data): Model|Builder|bool
    {
        DB::beginTransaction();
        try {

            $drugDoses = DrugDoses::query()->create($data);
            DB::commit();

            return $drugDoses;
        } catch (Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }

    public function getDrugDoseById(int $drugDosesId): Model|Builder
    {
        return DrugDoses::find($drugDosesId);
    }

    public function updateDrugDose(array $updateData, int $drugDosesId): int
    {
        $drugDoses = $this->getDrugDoseById($drugDosesId);

        return $drugDoses->update($updateData);
    }
}
