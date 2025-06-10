<?php

namespace App\Services\Drug;

use App\Models\Drug\DrugDuration;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class DrugDurationService
{
    public function getDrugDurationList(Request $request): JsonResponse|Model|Builder
    {
        $searchKeyword = $request->input('search');

        $query = DrugDuration::query()->select('drug_duration_id', 'drug_duration', 'status')->latest();

        if ($searchKeyword) {
            $query->where('drug_duration', 'like', '%' . $searchKeyword . '%')
                ->orWhere('status', 'like', '%' . $searchKeyword . '%');
        }

        return Datatables::of($query)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {

                $editBtn = '<button data-id="' . $row?->drug_duration_id . '" class="btn btn-bg-info text-white btn-sm editDrugDurationBtn" data-bs-toggle="modal" data-bs-target="#showModal"><i class="fas fa-edit text-white"></i> Edit</button>';

                $button = '<div class="btn-group" role="group" aria-label="Basic example">
                            ' . $editBtn . '
                            </div>';
                return $button;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function createDrugDuration(array $data): Model|Builder|bool
    {
        DB::beginTransaction();
        try {

            $drugDuration = DrugDuration::query()->create($data);
            DB::commit();

            return $drugDuration;
        } catch (Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }

    public function getDrugDurationById(int $drugDurationId): Model|Builder
    {
        return DrugDuration::find($drugDurationId);
    }

    public function updateDrugDuration(array $updateData, int $drugDurationId): int
    {
        $drugDuration = $this->getDrugDurationById($drugDurationId);

        return $drugDuration->update($updateData);
    }
}
