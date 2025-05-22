<?php

namespace App\Services\Drug;

use App\Models\Drug\DrugStrength;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class DrugStrengthService
{
    public function getDrugStrengthList(Request $request): JsonResponse|Model|Builder
    {
        $searchKeyword = $request->input('search');

        $query = DrugStrength::query()->select('drug_strength_id', 'drug_strength', 'status')->latest();

        if ($searchKeyword) {
            $query->where('drug_strength', 'like', '%' . $searchKeyword . '%')
                ->orWhere('status', 'like', '%' . $searchKeyword . '%');
        }

        return Datatables::of($query)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {

                $editBtn = '<button data-id="' . $row?->drug_strength_id . '" class="btn btn-bg-info text-white btn-sm editDrugStrengthBtn" data-bs-toggle="modal" data-bs-target="#showModal"><i class="fas fa-edit text-white"></i> Edit</button>';

                $button = '<div class="btn-group" role="group" aria-label="Basic example">
                            ' . $editBtn . '
                            </div>';
                return $button;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function createDrugStrength(array $data): Model|Builder|bool
    {
        DB::beginTransaction();
        try {

            $drugStrength = DrugStrength::query()->create($data);
            DB::commit();

            return $drugStrength;
        } catch (Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }

    public function getDrugStrengthById(int $drugStrengthId): Model|Builder
    {
        return DrugStrength::find($drugStrengthId);
    }

    public function updateDrugStrength(array $updateData, int $drugStrengthId): int
    {
        $drugStrength = $this->getDrugStrengthById($drugStrengthId);

        return $drugStrength->update($updateData);
    }
}
